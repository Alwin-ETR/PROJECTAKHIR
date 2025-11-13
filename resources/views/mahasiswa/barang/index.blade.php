@extends('layouts.mahasiswa')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Daftar Barang Tersedia</h1>
</div>

@if($terakhir_dilihat)
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Barang Terakhir Dilihat</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($terakhir_dilihat as $barangId)
                        @php $barang = \App\Models\Barang::find($barangId) @endphp
                        @if($barang)
                        <div class="col-md-2 mb-3">
                            <div class="card h-100">
                                <img src="{{ $barang->gambar ? asset('storage/' . $barang->gambar) : '/img/default-barang.jpg' }}" 
                                     class="card-img-top" alt="{{ $barang->nama_barang }}" style="height: 100px; object-fit: cover;">
                                <div class="card-body p-2">
                                    <h6 class="card-title small">{{ Str::limit($barang->nama_barang, 20) }}</h6>
                                    <a href="{{ route('mahasiswa.barang.show', $barang->id) }}" class="btn btn-sm btn-primary w-100">Lihat</a>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<div class="row">
    @foreach($barang as $item)
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <img src="{{ $item->gambar ? asset('storage/' . $item->gambar) : '/img/default-barang.jpg' }}" 
                 class="card-img-top" alt="{{ $item->nama_barang }}" style="height: 200px; object-fit: cover;">
            <div class="card-body">
                <h5 class="card-title">{{ $item->nama_barang }}</h5>
                <p class="card-text text-muted small">{{ Str::limit($item->deskripsi, 100) }}</p>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="badge bg-{{ $item->status == 'tersedia' ? 'success' : 'secondary' }}">
                        {{ $item->status == 'tersedia' ? 'Tersedia' : 'Tidak Tersedia' }}
                    </span>
                    <small class="text-muted">Stok: {{ $item->stok_tersedia }}</small>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('mahasiswa.barang.show', $item->id) }}" class="btn btn-primary btn-sm w-100">
                    <i class="fas fa-eye"></i> Lihat Detail
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection