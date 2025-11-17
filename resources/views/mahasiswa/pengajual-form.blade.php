@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-paper-plane me-2"></i>Form Pengajuan Peminjaman
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Daftar Barang di Keranjang -->
                    <div class="card mb-4">
                        <div class="card-header bg-warning">
                            <h5 class="mb-0">Barang yang akan Dipinjam</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Barang</th>
                                            <th>Kode</th>
                                            <th>Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cartItems as $id => $item)
                                        <tr>
                                            <td>{{ $item['nama'] }}</td>
                                            <td><code>{{ $item['kode_barang'] }}</code></td>
                                            <td>{{ $item['quantity'] }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Form Pengajuan -->
                    <form action="{{ route('mahasiswa.peminjaman.submit') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam *</label>
                                    <input type="date" class="form-control" id="tanggal_pinjam" 
                                           name="tanggal_pinjam" required 
                                           min="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tanggal_kembali" class="form-label">Tanggal Kembali *</label>
                                    <input type="date" class="form-control" id="tanggal_kembali" 
                                           name="tanggal_kembali" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="alasan" class="form-label">Alasan Peminjaman *</label>
                            <textarea class="form-control" id="alasan" name="alasan" 
                                      rows="4" placeholder="Jelaskan alasan dan tujuan peminjaman..." 
                                      required minlength="10" maxlength="500"></textarea>
                            <div class="form-text">Minimal 10 karakter, maksimal 500 karakter.</div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-success">
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
    // Set min date for tanggal_kembali based on tanggal_pinjam
    document.getElementById('tanggal_pinjam').addEventListener('change', function() {
        const pinjamDate = this.value;
        document.getElementById('tanggal_kembali').min = pinjamDate;
        
        // Auto-set tanggal_kembali to 7 days after tanggal_pinjam
        if (pinjamDate) {
            const pinjam = new Date(pinjamDate);
            pinjam.setDate(pinjam.getDate() + 7);
            const kembalDate = pinjam.toISOString().split('T')[0];
            document.getElementById('tanggal_kembali').value = kembalDate;
        }
    });
</script>
@endsection