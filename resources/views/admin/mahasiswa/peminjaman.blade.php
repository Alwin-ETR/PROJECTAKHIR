@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Riwayat Peminjaman Mahasiswa</h1>
    <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Data Mahasiswa</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <th width="30%">NIM</th>
                        <td>{{ $user->nim }}</td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th>Telepon</th>
                        <td>{{ $user->phone }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <h4>{{ $peminjaman->count() }}</h4>
                        <p class="mb-0">Total Peminjaman</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header">
        <h5 class="card-title mb-0">Riwayat Peminjaman</h5>
    </div>
    <div class="card-body">
        @if($peminjaman->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Inventaris</th>
                            <th>Jumlah</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                            <th>Keterlambatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($peminjaman as $index => $p)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $p->barang->nama }}</strong><br>
                                <small class="text-muted">Kode: {{ $p->barang->kode_barang }}</small>
                            </td>
                            <td>{{ $p->jumlah }}</td>
                            <td>{{ $p->tanggal_pinjam->format('d/m/Y') }}</td>
                            <td>{{ $p->tanggal_kembali->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $p->status == 'disetujui' ? 'success' : ($p->status == 'pending' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>
                            <td>
                                @if($p->isOverdue())
                                    @php
                                        $daysLate = now()->diffInDays($p->tanggal_kembali);
                                    @endphp
                                    <span class="badge bg-danger">
                                        Terlambat {{ $daysLate }} hari
                                    </span>
                                @elseif($p->status == 'disetujui' && now()->lessThanOrEqualTo($p->tanggal_kembali))
                                    @php
                                        $daysLeft = now()->diffInDays($p->tanggal_kembali, false);
                                    @endphp
                                    @if($daysLeft >= 0)
                                        <span class="badge bg-success">
                                            {{ $daysLeft }} hari lagi
                                        </span>
                                    @endif
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-4">
                <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                <p class="text-muted">Mahasiswa ini belum memiliki riwayat peminjaman.</p>
            </div>
        @endif
    </div>
</div>

<!-- Statistik Peminjaman -->
@if($peminjaman->count() > 0)
<div class="row mt-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5 class="card-title">Disetujui</h5>
                <p class="card-text display-4">
                    {{ $peminjaman->where('status', 'disetujui')->count() }}
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h5 class="card-title">Pending</h5>
                <p class="card-text display-4">
                    {{ $peminjaman->where('status', 'pending')->count() }}
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <h5 class="card-title">Ditolak</h5>
                <p class="card-text display-4">
                    {{ $peminjaman->where('status', 'ditolak')->count() }}
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h5 class="card-title">Terlambat</h5>
                <p class="card-text display-4">
                    {{ $peminjaman->where('status', 'disetujui')->filter(function($p) { return $p->isOverdue(); })->count() }}
                </p>
            </div>
        </div>
    </div>
</div>
@endif
@endsection