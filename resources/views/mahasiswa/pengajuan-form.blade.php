@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-paper-plane me-2"></i>Form Pengajuan Peminjaman
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Alert Session -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Daftar Barang di Keranjang -->
                    <div class="card mb-4">
                        <div class="card-header bg-warning">
                            <h5 class="mb-0">
                                <i class="fas fa-shopping-cart me-2"></i>Barang yang akan Dipinjam
                                <span class="badge bg-danger">{{ count($cartItems) }}</span>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Gambar</th>
                                            <th>Nama Barang</th>
                                            <th>Kode</th>
                                            <th>Jumlah</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cartItems as $id => $item)
                                        <tr>
                                            <td>
                                                @if($item['gambar'])
                                                    <img src="{{ asset('storage/' . $item['gambar']) }}" 
                                                         alt="{{ $item['nama'] }}" width="50" class="img-thumbnail">
                                                @else
                                                    <div class="bg-light d-flex align-items-center justify-content-center" 
                                                         style="width: 50px; height: 50px;">
                                                        <i class="fas fa-box text-muted"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>{{ $item['nama'] }}</td>
                                            <td><code>{{ $item['kode_barang'] }}</code></td>
                                            <td>{{ $item['quantity'] }}</td>
                                            <td>
                                                <span class="badge bg-{{ $item['status_badge'] }}">
                                                    {{ $item['status_text'] }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Peminjaman Aktif Lainnya -->
                    <div class="card mb-4">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-users me-2"></i>Peminjaman Aktif oleh Mahasiswa Lain
                            </h5>
                        </div>
                        <div class="card-body">
                            @php
                                $peminjamanAktifLain = \App\Models\Peminjaman::with(['barang', 'user'])
                                    ->whereIn('barang_id', array_keys($cartItems))
                                    ->whereIn('status', ['disetujui', 'pending'])
                                    ->where('user_id', '!=', Auth::id())
                                    ->where('tanggal_kembali', '>=', now())
                                    ->orderBy('tanggal_kembali', 'asc')
                                    ->get();
                            @endphp

                            @if($peminjamanAktifLain->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Barang</th>
                                                <th>Dipinjam Oleh</th>
                                                <th>Tanggal Pinjam</th>
                                                <th>Tanggal Kembali</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($peminjamanAktifLain as $pinjam)
                                            <tr>
                                                <td>{{ $pinjam->barang->nama }}</td>
                                                <td>{{ $pinjam->user->name }}</td>
                                                <td>{{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('d/m/Y') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($pinjam->tanggal_kembali)->format('d/m/Y') }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $pinjam->status == 'disetujui' ? 'success' : 'warning' }}">
                                                        {{ $pinjam->status }}
                                                    </span>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="alert alert-info mt-3">
                                    <small>
                                        <i class="fas fa-info-circle me-2"></i>
                                        Perhatikan jadwal peminjaman mahasiswa lain untuk menghindari konflik.
                                    </small>
                                </div>
                            @else
                                <div class="text-center py-3">
                                    <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                                    <p class="text-muted mb-0">Tidak ada peminjaman aktif untuk barang yang dipilih.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Form Pengajuan -->
                    <form action="{{ route('mahasiswa.peminjaman.submit') }}" method="POST" id="pengajuanForm">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tanggal_pinjam" class="form-label">
                                        <i class="fas fa-calendar-alt me-2"></i>Tanggal Pinjam *
                                    </label>
                                    <input type="date" class="form-control @error('tanggal_pinjam') is-invalid @enderror" 
                                           id="tanggal_pinjam" name="tanggal_pinjam" 
                                           value="{{ old('tanggal_pinjam') }}" required 
                                           min="{{ date('Y-m-d') }}">
                                    @error('tanggal_pinjam')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Pilih tanggal mulai peminjaman</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tanggal_kembali" class="form-label">
                                        <i class="fas fa-calendar-check me-2"></i>Tanggal Kembali *
                                    </label>
                                    <input type="date" class="form-control @error('tanggal_kembali') is-invalid @enderror" 
                                           id="tanggal_kembali" name="tanggal_kembali" 
                                           value="{{ old('tanggal_kembali') }}" required>
                                    @error('tanggal_kembali')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Pilih tanggal pengembalian barang</div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="alasan" class="form-label">
                                <i class="fas fa-file-alt me-2"></i>Alasan Peminjaman *
                            </label>
                            <textarea class="form-control @error('alasan') is-invalid @enderror" 
                                      id="alasan" name="alasan" rows="4" 
                                      placeholder="Jelaskan alasan dan tujuan peminjaman barang-barang ini..." 
                                      required minlength="10" maxlength="500">{{ old('alasan') }}</textarea>
                            @error('alasan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <span id="charCount">0</span>/500 karakter (minimal 10 karakter)
                            </div>
                        </div>

                        <!-- Summary -->
                        <div class="card bg-light mb-4">
                            <div class="card-body">
                                <h6 class="card-title">
                                    <i class="fas fa-clipboard-list me-2"></i>Ringkasan Peminjaman
                                </h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <small class="text-muted">Jumlah Barang:</small>
                                        <p class="mb-1 fw-bold">{{ count($cartItems) }} barang</p>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted">Total Item:</small>
                                        <p class="mb-1 fw-bold">
                                            {{ array_sum(array_column($cartItems, 'quantity')) }} item
                                        </p>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <small class="text-muted">Periode Peminjaman:</small>
                                        <p class="mb-0 fw-bold" id="periodeText">-</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                            </a>
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-paper-plane me-2"></i>Ajukan Peminjaman
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Character counter for alasan textarea
    document.getElementById('alasan').addEventListener('input', function() {
        document.getElementById('charCount').textContent = this.value.length;
    });

    // Set min date for tanggal_kembali based on tanggal_pinjam
    document.getElementById('tanggal_pinjam').addEventListener('change', function() {
        const pinjamDate = this.value;
        const kembaliInput = document.getElementById('tanggal_kembali');
        
        if (pinjamDate) {
            // Set min date for kembali
            kembaliInput.min = pinjamDate;
            
            // Auto-set tanggal_kembali to 7 days after tanggal_pinjam if empty
            if (!kembaliInput.value) {
                const pinjam = new Date(pinjamDate);
                pinjam.setDate(pinjam.getDate() + 7);
                const kembalDate = pinjam.toISOString().split('T')[0];
                kembaliInput.value = kembalDate;
            }
            
            updatePeriodeText();
        }
    });

    document.getElementById('tanggal_kembali').addEventListener('change', updatePeriodeText);

    function updatePeriodeText() {
        const pinjam = document.getElementById('tanggal_pinjam').value;
        const kembali = document.getElementById('tanggal_kembali').value;
        
        if (pinjam && kembali) {
            const start = new Date(pinjam);
            const end = new Date(kembali);
            const diffTime = Math.abs(end - start);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            
            const options = { day: 'numeric', month: 'long', year: 'numeric' };
            const startFormatted = start.toLocaleDateString('id-ID', options);
            const endFormatted = end.toLocaleDateString('id-ID', options);
            
            document.getElementById('periodeText').textContent = 
                `${startFormatted} - ${endFormatted} (${diffDays} hari)`;
        } else {
            document.getElementById('periodeText').textContent = '-';
        }
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        updatePeriodeText();
        document.getElementById('charCount').textContent = 
            document.getElementById('alasan').value.length;
    });
</script>

<style>
    .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    .card-header {
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
    }
</style>
@endsection