@extends('layouts.admin')

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

    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3">
        <h1 class="h2 text-dark">
            <i class="bi bi-clipboard-check"></i> Manajemen Peminjaman
        </h1>

        <!-- TOMBOL DOWNLOAD LAPORAN PDF (buka halaman laporan) -->
        <a href="{{ route('admin.peminjaman.laporan') }}" 
           class="btn btn-success">
            <i class="fas fa-file-pdf"></i> Download Laporan PDF
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header text-white"
             style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <h5 class="mb-0"><i class="bi bi-list-ul"></i> Daftar Peminjaman</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Mahasiswa</th>
                            <th>Inventaris</th>
                            <th>Jumlah</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($peminjaman as $p)
                        <tr>
                            <td class="fw-bold">{{ $p->user->name }} ({{ $p->user->nim }})</td>
                            <td>{{ $p->barang->nama }}</td>
                            <td>{{ $p->jumlah }}</td>
                            <td>{{ $p->tanggal_pinjam->format('d/m/Y') }}</td>
                            <td>{{ $p->tanggal_kembali->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $p->status_badge }} text-capitalize">
                                    {{ $p->status_text }}
                                </span>
                                @if($p->isOverdue())
                                    <span class="badge bg-danger mt-1">
                                        <i class="fas fa-exclamation-triangle"></i> Terlambat
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($p->status === 'pending')
                                    <div class="btn-group" role="group">
                                        <!-- Tombol Setujui -->
                                        <form method="POST" action="{{ route('admin.peminjaman.approve', $p->id) }}" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm" 
                                                    onclick="return confirm('Setujui peminjaman ini?')">
                                                <i class="fas fa-check"></i> Setujui
                                            </button>
                                        </form>
                                        
                                        <!-- Tombol Tolak -->
                                        <form method="POST" action="{{ route('admin.peminjaman.reject', $p->id) }}" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm ms-1" 
                                                    onclick="return confirm('Tolak peminjaman ini?')">
                                                <i class="fas fa-times"></i> Tolak
                                            </button>
                                        </form>
                                    </div>
                                @elseif($p->status === 'dikembalikan')
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle"></i> Selesai
                                    </span>
                                @elseif($p->status === 'disetujui')
                                    <span class="badge bg-primary">
                                        <i class="fas fa-clock"></i> Sedang Dipinjam
                                    </span>
                                @elseif($p->status === 'ditolak')
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-ban"></i> Ditolak
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
