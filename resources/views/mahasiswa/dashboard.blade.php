@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
    }
    .admin-content {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        padding: 25px;
        margin: 20px 0;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }
    .stat-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    .card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    .table {
        background: white;
        border-radius: 8px;
        overflow: hidden;
    }
    .table th {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
    }
    .btn {
        border-radius: 8px;
        transition: all 0.3s ease;
        font-weight: 500;
    }
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }
</style>

<div class="admin-content">
    <!-- Header -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2 text-dark">Dashboard Mahasiswa</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{ route('mahasiswa.riwayat') }}" class="btn btn-primary">
                    <i class="bi bi-clock-history"></i> Riwayat Peminjaman
                </a>
                <a href="{{ route('mahasiswa.profile') }}" class="btn btn-outline-primary">
                    <i class="bi bi-person"></i> Profil Saya
                </a>
            </div>
        </div>
    </div>

    <!-- Alert Session -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                PEMINJAMAN AKTIF</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $peminjamanAktif ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-clipboard-check fa-2x text-primary"></i>
                        </div>
                    </div>
                    <a href="{{ route('mahasiswa.riwayat') }}" class="btn btn-primary btn-sm mt-2 w-100">
                        Lihat Detail
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                MENUNGGU PERSETUJUAN</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $peminjamanPending ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-clock-history fa-2x text-warning"></i>
                        </div>
                    </div>
                    <a href="{{ route('mahasiswa.riwayat') }}" class="btn btn-warning btn-sm mt-2 w-100">
                        Lihat Detail
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                TOTAL DIPINJAM</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalDipinjam ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-check-circle fa-2x text-success"></i>
                        </div>
                    </div>
                    <a href="{{ route('mahasiswa.riwayat') }}" class="btn btn-success btn-sm mt-2 w-100">
                        Lihat Riwayat
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                BARANG TERSEDIA</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $barangTersedia ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-box-seam fa-2x text-info"></i>
                        </div>
                    </div>
                    <a href="#barang-tersedia" class="btn btn-info btn-sm mt-2 w-100">
                        Jelajahi Barang
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h5 class="mb-0"><i class="bi bi-lightning"></i> Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('mahasiswa.search') }}" class="btn btn-primary w-100 py-3">
                                <i class="bi bi-search display-6 d-block mb-2"></i>
                                Cari Barang
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('mahasiswa.riwayat') }}" class="btn btn-success w-100 py-3">
                                <i class="bi bi-clock-history display-6 d-block mb-2"></i>
                                Riwayat Saya
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            @if(count($cartItems) > 0)
                                <a href="{{ route('mahasiswa.pengajuan.form') }}" class="btn btn-warning w-100 py-3">
                                    <i class="bi bi-cart-check display-6 d-block mb-2"></i>
                                    Ajukan Peminjaman
                                    <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">
                                        {{ count($cartItems) }}
                                    </span>
                                </a>
                            @else
                                <button class="btn btn-secondary w-100 py-3" disabled>
                                    <i class="bi bi-cart display-6 d-block mb-2"></i>
                                    Ajukan Peminjaman
                                </button>
                            @endif
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('mahasiswa.profile') }}" class="btn btn-info w-100 py-3">
                                <i class="bi bi-person display-6 d-block mb-2"></i>
                                Profil Saya
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Peminjaman Terbaru -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h5 class="mb-0"><i class="bi bi-clock-history"></i> Peminjaman Terbaru</h5>
                </div>
                <div class="card-body">
                    @php
                        // Ambil data peminjaman terbaru langsung di view
                        $peminjamanTerbaru = \App\Models\Peminjaman::where('user_id', Auth::id())
                            ->with('barang')
                            ->orderBy('created_at', 'desc')
                            ->limit(5)
                            ->get();
                    @endphp

                    @if($peminjamanTerbaru->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Barang</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Tanggal Kembali</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($peminjamanTerbaru as $peminjaman)
                                    <tr>
                                        <td class="fw-bold">{{ $peminjaman->barang->nama ?? 'N/A' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d/m/Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d/m/Y') }}</td>
                                        <td>
                                            <span class="badge bg-{{
                                                $peminjaman->status == 'disetujui' ? 'success' :
                                                ($peminjaman->status == 'pending' ? 'warning' : 'danger')
                                            }} text-capitalize">
                                                {{ $peminjaman->status }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-inbox display-4 text-muted"></i>
                            <p class="text-muted mt-2">Belum ada peminjaman.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Barang Tersedia -->
    <div class="row mt-4" id="barang-tersedia">
        <div class="col-12">
            <div class="card">
                <div class="card-header text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h5 class="mb-0">
                        <i class="bi bi-box-seam me-2"></i>Daftar Barang Tersedia
                        <span class="badge bg-light text-dark ms-2">{{ $barang->count() }}</span>
                    </h5>
                </div>
                <div class="card-body">
                    @if($barang->count() > 0)
                    <div class="row g-4">
                        @foreach($barang as $item)
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="card h-100 shadow-sm">
                                @if($item->gambar)
                                <img src="{{ asset('storage/' . $item->gambar) }}" class="card-img-top" alt="{{ $item->nama }}" style="height: 200px; object-fit: cover;">
                                @else
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="bi bi-box fa-3x text-muted"></i>
                                </div>
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title text-dark mb-3">{{ $item->nama }}</h5>
                                    <div class="mb-2">
                                        <strong class="text-muted">Kode:</strong>
                                        <code class="bg-light text-dark px-2 py-1 rounded">{{ $item->kode_barang }}</code>
                                    </div>
                                    <div class="mb-2">
                                        <strong class="text-muted">Stok Tersedia:</strong>
                                        <span class="badge bg-{{ $item->stok_tersedia > 0 ? 'success' : 'danger' }}">
                                            {{ $item->stok_tersedia }}
                                        </span>
                                    </div>
                                    <div class="mb-3">
                                        <strong class="text-muted">Status:</strong>
                                        <span class="badge bg-{{ $item->status == 'tersedia' ? 'success' : 'warning' }}">
                                            {{ $item->status }}
                                        </span>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent border-0 pt-0">
                                    <div class="btn-group w-100">
                                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="showBarangDetail({{ $item->id }})">
                                            <i class="bi bi-eye me-1"></i>Detail
                                        </button>

                                        @if($item->status == 'tersedia' && $item->stok_tersedia > 0)
                                        <form action="{{ route('mahasiswa.cart.add', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="bi bi-cart-plus me-1"></i>Pinjam
                                            </button>
                                        </form>
                                        @else
                                        <button class="btn btn-secondary btn-sm" disabled>
                                            <i class="bi bi-ban me-1"></i>Tidak Tersedia
                                        </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="bi bi-box fa-3x text-muted mb-3"></i>
                        <h5 class="text-dark">Tidak ada barang tersedia</h5>
                        <p class="text-muted">Semua barang sedang dipinjam atau dalam perbaikan</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Barang -->
<div class="modal fade" id="barangDetailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <h5 class="modal-title">Detail Barang</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="barangDetailContent">
                <!-- Content akan diisi via JavaScript -->
            </div>
        </div>
    </div>
</div>

<script>
function showBarangDetail(barangId) {
    $('#barangDetailContent').html(`
        <div class="text-center py-4">
            <div class="spinner-border text-primary"></div>
            <p class="mt-2">Memuat detail barang...</p>
        </div>
    `);

    var modal = new bootstrap.Modal(document.getElementById('barangDetailModal'));
    modal.show();

    fetch(`/mahasiswa/barang/${barangId}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.text())
    .then(html => {
        document.getElementById('barangDetailContent').innerHTML = html;
    })
    .catch(error => {
        document.getElementById('barangDetailContent').innerHTML = `
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle"></i>
                Gagal memuat detail barang.
            </div>
        `;
    });
}

// Auto-hide alerts after 5 seconds
setTimeout(() => {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        const bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    });
}, 5000);
</script>
@endsection