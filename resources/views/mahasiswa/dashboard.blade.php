<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mahasiswa Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-boxes"></i> Sistem Peminjaman - Mahasiswa
            </a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">
                    <i class="fas fa-user"></i> {{ Auth::user()->name }} ({{ Auth::user()->nim }})
                </span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Selamat Datang, {{ Auth::user()->name }}!</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card bg-primary text-white mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title">Informasi Mahasiswa</h5>
                                        <p class="mb-1"><strong>NIM:</strong> {{ Auth::user()->nim }}</p>
                                        <p class="mb-1"><strong>Email:</strong> {{ Auth::user()->email }}</p>
                                        <p class="mb-0"><strong>Telepon:</strong> {{ Auth::user()->phone }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-info text-white mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title">Statistik Peminjaman</h5>
                                        <p class="mb-1"><strong>Total Peminjaman:</strong> {{ $peminjaman_terbaru->count() }}</p>
                                        <p class="mb-0"><strong>Barang Tersedia:</strong> {{ \App\Models\Barang::where('status', 'tersedia')->count() }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Peminjaman Terbaru</h5>
                                    </div>
                                    <div class="card-body">
                                        @if($peminjaman_terbaru->count() > 0)
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Barang</th>
                                                            <th>Tanggal Pinjam</th>
                                                            <th>Tanggal Kembali</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($peminjaman_terbaru as $peminjaman)
                                                        <tr>
                                                            <td>{{ $peminjaman->barang->nama_barang ?? 'N/A' }}</td>
                                                            <td>{{ $peminjaman->tanggal_pinjam->format('d/m/Y') }}</td>
                                                            <td>{{ $peminjaman->tanggal_kembali->format('d/m/Y') }}</td>
                                                            <td>
                                                                <span class="badge bg-{{ $peminjaman->status == 'disetujui' ? 'success' : ($peminjaman->status == 'pending' ? 'warning' : 'danger') }}">
                                                                    {{ ucfirst($peminjaman->status) }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <p class="text-muted">Belum ada riwayat peminjaman.</p>
                                            <a href="#" class="btn btn-primary">Pinjam Barang Pertama</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Barang Populer</h5>
                                    </div>
                                    <div class="card-body">
                                        @foreach($barang_populer as $barang)
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="shrink-0">
                                                <i class="fas fa-box fa-2x text-secondary"></i>
                                            </div>
                                            <div class="grow ms-3">
                                                <h6 class="mb-0">{{ $barang->nama_barang }}</h6>
                                                <small class="text-muted">
                                                    Kode: {{ $barang->kode_barang }} | 
                                                    Stok: {{ $barang->stok }}
                                                </small>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                
                                <div class="card mt-3">
                                    <div class="card-body text-center">
                                        <h6>Quick Actions</h6>
                                        <div class="d-grid gap-2">
                                            <a href="#" class="btn btn-outline-primary btn-sm">Lihat Semua Barang</a>
                                            <a href="#" class="btn btn-outline-success btn-sm">Ajukan Peminjaman</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>