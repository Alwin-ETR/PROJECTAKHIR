@extends('layouts.admin')

@section('title', 'Manajemen Barang')

@push('scripts')
<!-- CDN SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

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
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
</style>

<div class="admin-content">
    <!-- Header -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
        <h1 class="h2 text-dark"><i class="bi bi-box-seam"></i> Manajemen Inventaris</h1>
        <a href="{{ route('admin.barang.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Barang Baru
        </a>
    </div>

    <!-- SweetAlert2 Notification -->
    @if(session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2200
                });
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '{{ session('error') }}',
                    showConfirmButton: false,
                    timer: 2500
                });
            });
        </script>
    @endif

    <!-- Tabel Barang -->
    <div class="card">
        <div class="card-header text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <h5 class="mb-0"><i class="bi bi-list-ul"></i> Daftar Barang</h5>
        </div>
        <div class="card-body">
            @if($barangs->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Deskripsi</th>
                                <th>Stok</th>
                                <th>Status</th>
                                <th>Gambar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($barangs as $barang)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <span class="badge bg-primary">{{ $barang->kode_barang }}</span>
                                </td>
                                <td class="fw-bold">{{ $barang->nama }}</td>
                                <td>{{ $barang->deskripsi ? Str::limit($barang->deskripsi, 50) : '-' }}</td>
                                <td>
                                    <span class="badge bg-{{ $barang->stok > 0 ? 'success' : 'danger' }} fs-6">
                                        {{ $barang->stok }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{
                                        $barang->status == 'tersedia' ? 'success' :
                                        ($barang->status == 'dipinjam' ? 'warning' : 'secondary')
                                    }}">
                                        {{ $barang->status }}
                                    </span>
                                </td>
                                <td>
                                    @if($barang->gambar)
                                        <img src="{{ asset('storage/' . $barang->gambar) }}"
                                             alt="{{ $barang->nama }}"
                                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                                    @else
                                        <span class="text-muted">No Image</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.barang.edit', $barang->id) }}"
                                           class="btn btn-warning btn-sm" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.barang.destroy', $barang->id) }}"
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Yakin hapus barang {{ $barang->nama }}?')"
                                                    title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-inbox display-4 text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada barang</h5>
                    <p class="text-muted">Silakan tambah barang terlebih dahulu</p>
                    <a href="{{ route('admin.barang.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i> Tambah Barang Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
