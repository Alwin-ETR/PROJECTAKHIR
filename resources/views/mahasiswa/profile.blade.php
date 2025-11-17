@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-user me-2"></i>Profil Mahasiswa
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

                    <div class="row">
                        <!-- Informasi Profil -->
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0">Informasi Pribadi</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="40%">Nama</th>
                                            <td>{{ $user->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{ $user->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>NIM</th>
                                            <td>{{ $user->nim ?? 'Belum diisi' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nomor HP</th>
                                            <td>{{ $user->phone ?? 'Belum diisi' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Role</th>
                                            <td>
                                                <span class="badge bg-success text-capitalize">
                                                    {{ $user->role }}
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Statistik Peminjaman -->
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header bg-warning text-dark">
                                    <h5 class="mb-0">Statistik Peminjaman</h5>
                                </div>
                                <div class="card-body">
                                    <div class="text-center">
                                        <div class="row">
                                            <div class="col-6 mb-3">
                                                <div class="card bg-primary text-white">
                                                    <div class="card-body py-3">
                                                        <h3>{{ $totalPeminjaman }}</h3>
                                                        <small>Total Peminjaman</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 mb-3">
                                                <div class="card bg-info text-white">
                                                    <div class="card-body py-3">
                                                        <h3>{{ $peminjamanAktif }}</h3>
                                                        <small>Sedang Dipinjam</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Actions -->
                            <div class="card">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0">Aksi Cepat</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-outline-primary">
                                            <i class="fas fa-home me-2"></i>Dashboard
                                        </a>
                                        <a href="{{ route('mahasiswa.riwayat') }}" class="btn btn-outline-info">
                                            <i class="fas fa-history me-2"></i>Riwayat Peminjaman
                                        </a>
                                        <a href="{{ route('logout') }}" class="btn btn-outline-danger" 
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Riwayat Terbaru -->
                    <div class="card mt-4">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="mb-0">Peminjaman Terbaru</h5>
                        </div>
                        <div class="card-body">
                            @php
                                $peminjamanTerbaru = \App\Models\Peminjaman::with('barang')
                                    ->where('user_id', $user->id)
                                    ->orderBy('created_at', 'desc')
                                    ->limit(5)
                                    ->get();
                            @endphp

                            @if($peminjamanTerbaru->count() > 0)
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
                                            @foreach($peminjamanTerbaru as $pinjam)
                                            <tr>
                                                <td>{{ $pinjam->barang->nama }}</td>
                                                <td>{{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('d/m/Y') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($pinjam->tanggal_kembali)->format('d/m/Y') }}</td>
                                                <td>
                                                    @php
                                                        $statusClass = [
                                                            'pending' => 'warning',
                                                            'disetujui' => 'success',
                                                            'ditolak' => 'danger',
                                                            'dikembalikan' => 'info'
                                                        ][$pinjam->status] ?? 'secondary';
                                                    @endphp
                                                    <span class="badge bg-{{ $statusClass }} text-capitalize">
                                                        {{ $pinjam->status }}
                                                    </span>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-center mt-3">
                                    <a href="{{ route('mahasiswa.riwayat') }}" class="btn btn-primary">
                                        Lihat Semua Riwayat
                                    </a>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-history fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Belum ada riwayat peminjaman</p>
                                    <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-primary">
                                        Pinjam Barang Sekarang
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        timer: 3000,
        showConfirmButton: false
    });
</script>
@endif
@endsection