@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-box me-2"></i>Detail Barang
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            @if($barang->gambar)
                                <img src="{{ asset('storage/' . $barang->gambar) }}" 
                                     alt="{{ $barang->nama }}" 
                                     class="img-fluid rounded">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center rounded" 
                                     style="height: 200px;">
                                    <i class="fas fa-box fa-3x text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h3>{{ $barang->nama }}</h3>
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Kode Barang</th>
                                    <td><code>{{ $barang->kode_barang }}</code></td>
                                </tr>
                                <tr>
                                    <th>Stok Tersedia</th>
                                    <td>
                                        <span class="badge bg-success fs-6">
                                            {{ $barang->stok_tersedia }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge bg-{{ $barang->status_badge }}">
                                            {{ $barang->status_text }}
                                        </span>
                                    </td>
                                </tr>
                                @if($barang->deskripsi)
                                <tr>
                                    <th>Deskripsi</th>
                                    <td>{{ $barang->deskripsi }}</td>
                                </tr>
                                @endif
                            </table>

                            <div class="mt-4">
                                @if($barang->canBeBorrowed())
                                <form action="{{ route('mahasiswa.cart.add', $barang->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-cart-plus me-2"></i>Tambah ke Keranjang Pinjam
                                    </button>
                                </form>
                                @else
                                <button class="btn btn-secondary btn-lg" disabled>
                                    <i class="fas fa-ban me-2"></i>Barang Tidak Tersedia
                                </button>
                                @endif
                                
                                <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-outline-secondary ms-2">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection