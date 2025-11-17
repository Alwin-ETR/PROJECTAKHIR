@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Dashboard Mahasiswa</h2>
                <div class="btn-group">
                    <a href="{{ route('mahasiswa.riwayat') }}" class="btn btn-outline-primary">
                        <i class="fas fa-history"></i> Riwayat Peminjaman
                    </a>
                    <a href="{{ route('mahasiswa.profile') }}" class="btn btn-outline-info">
                        <i class="fas fa-user"></i> Profil Saya
                    </a>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{ route('mahasiswa.search') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Cari barang berdasarkan nama, kode, atau deskripsi..." 
                                   value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Cari
                            </button>
                        </div>
                    </form>
                </div>
            </div>

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

            <!-- Keranjang Peminjaman -->
            @if(count($cartItems) > 0)
            <div class="card mb-4">
                <div class="card-header bg-warning">
                    <h5 class="mb-0">
                        <i class="fas fa-shopping-cart"></i> Keranjang Peminjaman
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
                                    <th>Status</th>
                                    <th>Jumlah</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cartItems as $id => $details)
                                <tr>
                                    <td>
                                        @if($details['gambar'])
                                            <img src="{{ asset('storage/' . $details['gambar']) }}" alt="{{ $details['nama'] }}" width="50" class="img-thumbnail">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                <i class="fas fa-box text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $details['nama'] }}</td>
                                    <td><code>{{ $details['kode_barang'] }}</code></td>
                                    <td>
                                        <span class="badge bg-{{ $details['status_badge'] ?? 'secondary' }}">
                                            {{ $details['status_text'] ?? 'Unknown' }}
                                        </span>
                                    </td>
                                    <td>
                                        <form action="{{ route('mahasiswa.cart.update', $id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <div class="input-group input-group-sm" style="width: 120px;">
                                                <input type="number" name="quantity" value="{{ $details['quantity'] }}" 
                                                       min="1" max="{{ $details['max_stok'] }}" class="form-control">
                                                <button type="submit" class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-sync-alt"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{ route('mahasiswa.cart.remove', $id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <form action="{{ route('mahasiswa.cart.clear') }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="fas fa-trash"></i> Kosongkan Keranjang
                            </button>
                        </form>
                        <a href="{{ route('mahasiswa.pengajuan.form') }}" class="btn btn-success">
                            <i class="fas fa-paper-plane"></i> Ajukan Peminjaman
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- Barang Terakhir Dilihat -->
            @if(count($lastViewed) > 0)
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-history"></i> Barang Terakhir Dilihat
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($lastViewed as $barangId)
                            @php $barang = \App\Models\Barang::find($barangId); @endphp
                            @if($barang)
                            <div class="col-md-2 mb-3">
                                <div class="card h-100">
                                    @if($barang->gambar)
                                    <img src="{{ asset('storage/' . $barang->gambar) }}" class="card-img-top" alt="{{ $barang->nama }}" style="height: 120px; object-fit: cover;">
                                    @else
                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 120px;">
                                        <i class="fas fa-box fa-2x text-muted"></i>
                                    </div>
                                    @endif
                                    <div class="card-body">
                                        <h6 class="card-title">{{ Str::limit($barang->nama, 20) }}</h6>
                                        <p class="card-text small">
                                            <strong>Kode:</strong> {{ $barang->kode_barang }}<br>
                                            <strong>Stok:</strong> 
                                            <span class="badge bg-success">{{ $barang->stok }}</span><br>
                                            <strong>Status:</strong> 
                                            <span class="badge bg-{{ $barang->status_badge }}">
                                                {{ $barang->status_text }}
                                            </span>
                                        </p>
                                    </div>
                                    <div class="card-footer">
                                        <a href="{{ route('mahasiswa.barang.show', $barang->id) }}" class="btn btn-info btn-sm w-100 mb-1">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                        
                                        <!-- TAMPILKAN TOMBOL PINJAM HANYA JIKA BARANG BISA DIPINJAM -->
                                        @if($barang->status === 'tersedia' && $barang->stok > 0)
                                        <form action="{{ route('mahasiswa.cart.add', $barang->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-sm w-100">
                                                <i class="fas fa-cart-plus"></i> Pinjam
                                            </button>
                                        </form>
                                        @else
                                        <button class="btn btn-secondary btn-sm w-100" disabled>
                                            <i class="fas fa-ban"></i> 
                                            {{ $barang->status === 'dipinjam' ? 'Sedang Dipinjam' : 'Tidak Tersedia' }}
                                        </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Daftar Barang Tersedia -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-boxes"></i> Daftar Barang
                        <span class="badge bg-light text-dark">{{ $barang->count() }}</span>
                    </h5>
                </div>
                <div class="card-body">
                    @if($barang->count() > 0)
                    <div class="row">
                        @foreach($barang as $item)
                        <div class="col-md-3 mb-4">
                            <div class="card h-100 shadow-sm">
                                @if($item->gambar)
                                <img src="{{ asset('storage/' . $item->gambar) }}" class="card-img-top" alt="{{ $item->nama }}" style="height: 200px; object-fit: cover;">
                                @else
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="fas fa-box fa-3x text-muted"></i>
                                </div>
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ $item->nama }}</h5>
                                    <p class="card-text">
                                        <strong>Kode:</strong> <code>{{ $item->kode_barang }}</code><br>
                                        <strong>Stok:</strong> 
                                        <span class="badge bg-success">{{ $item->stok }}</span><br> <!-- PAKAI $item->stok BUKAN stok_tersedia -->
                                        <strong>Status:</strong>
                                        <span class="badge bg-{{ $item->status_badge }}">
                                            {{ $item->status_text }}
                                        </span><br>
                                        @if($item->deskripsi)
                                        <strong>Deskripsi:</strong> 
                                        <small>{{ Str::limit($item->deskripsi, 50) }}</small>
                                        @endif
                                    </p>
                                </div>
                                <div class="card-footer">
                                    <div class="btn-group w-100">
                                        <a href="{{ route('mahasiswa.barang.show', $item->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                        
                                        <!-- TAMPILKAN TOMBOL PINJAM HANYA JIKA BARANG BISA DIPINJAM -->
                                        @if($item->status === 'tersedia' && $item->stok > 0)
                                        <form action="{{ route('mahasiswa.cart.add', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="fas fa-cart-plus"></i> Pinjam
                                            </button>
                                        </form>
                                        @else
                                        <button class="btn btn-secondary btn-sm" disabled>
                                            <i class="fas fa-ban"></i> 
                                            {{ $item->status === 'dipinjam' ? 'Sedang Dipinjam' : 'Tidak Tersedia' }}
                                        </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-4">
                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                        <h5>Tidak ada barang tersedia</h5>
                        <p class="text-muted">Semua barang sedang dipinjam atau dalam perbaikan</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Simple Alert -->
<script>
    @if(session('success'))
        alert('{{ session('success') }}');
    @endif
    
    @if(session('error'))
        alert('{{ session('error') }}');
    @endif
</script>
@endsection