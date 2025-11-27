@extends('layouts.mahasiswa')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Title Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Dashboard Mahasiswa</h1>
        <p class="text-gray-500">Sistem Peminjaman Inventaris Fasilkom</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Total Peminjaman -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm mb-1">Total Peminjaman</p>
                    <h3 class="text-3xl font-bold">{{ $totalPeminjaman ?? 0 }}</h3>
                </div>
                <i class="fas fa-box-open text-5xl opacity-20"></i>
            </div>
        </div>

        <!-- Sedang Dipinjam -->
        <div class="bg-gradient-to-br from-amber-500 to-amber-600 text-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-amber-100 text-sm mb-1">Sedang Dipinjam</p>
                    <h3 class="text-3xl font-bold">{{ $peminjamanAktif ?? 0 }}</h3>
                </div>
                <i class="fas fa-clock text-5xl opacity-20"></i>
            </div>
        </div>

        <!-- Sudah Dikembalikan -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 text-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm mb-1">Sudah Dikembalikan</p>
                    <h3 class="text-3xl font-bold">{{ $peminjamanSelesai ?? 0 }}</h3>
                </div>
                <i class="fas fa-check-circle text-5xl opacity-20"></i>
            </div>
        </div>
    </div>

    <!-- Search Bar (shortcut ke katalog) -->
    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
        <form action="{{ route('mahasiswa.katalog') }}" method="GET" class="flex gap-2">
            <input type="text" name="search" placeholder="Cari barang di katalog..."
                   value="{{ request('search') }}" class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium flex items-center gap-2">
                <i class="fas fa-search"></i>
                Cari di Katalog
            </button>
        </form>
    </div>

    <!-- Alert Session -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-4 rounded-lg mb-4 flex items-start gap-3" role="alert">
            <i class="fas fa-check-circle mt-0.5"></i>
            <span>{{ session('success') }}</span>
            <button type="button" class="ml-auto text-green-700 hover:text-green-900" onclick="this.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-4 rounded-lg mb-4 flex items-start gap-3" role="alert">
            <i class="fas fa-exclamation-triangle mt-0.5"></i>
            <span>{{ session('error') }}</span>
            <button type="button" class="ml-auto text-red-700 hover:text-red-900" onclick="this.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <a href="{{ route('mahasiswa.katalog') }}" class="bg-white rounded-xl shadow-sm p-6 hover:shadow-lg transition border-l-4 border-blue-600">
            <h3 class="text-lg font-bold text-gray-800 mb-1">Buka Katalog Barang</h3>
            <p class="text-gray-500 text-sm mb-3">Cari dan tambahkan barang ke keranjang peminjaman.</p>
            <span class="inline-flex items-center text-blue-600 text-sm font-medium">
                Pergi ke katalog <i class="fas fa-arrow-right ml-2"></i>
            </span>
        </a>

        <a href="{{ route('mahasiswa.riwayat') }}" class="bg-white rounded-xl shadow-sm p-6 hover:shadow-lg transition border-l-4 border-amber-500">
            <h3 class="text-lg font-bold text-gray-800 mb-1">Lihat Riwayat Peminjaman</h3>
            <p class="text-gray-500 text-sm mb-3">Pantau status pengajuan dan riwayat lengkap peminjaman.</p>
            <span class="inline-flex items-center text-amber-600 text-sm font-medium">
                Lihat riwayat <i class="fas fa-arrow-right ml-2"></i>
            </span>
        </a>

        <a href="{{ route('mahasiswa.profile') }}" class="bg-white rounded-xl shadow-sm p-6 hover:shadow-lg transition border-l-4 border-green-600">
            <h3 class="text-lg font-bold text-gray-800 mb-1">Profil & Informasi Akun</h3>
            <p class="text-gray-500 text-sm mb-3">Periksa data diri dan ringkasan aktivitas Anda.</p>
            <span class="inline-flex items-center text-green-600 text-sm font-medium">
                Buka profil <i class="fas fa-arrow-right ml-2"></i>
            </span>
        </a>
    </div>

    <!-- Barang Terbaru / Rekomendasi -->
    <div class="bg-white rounded-xl shadow-sm">
        <div class="bg-blue-800 text-white px-6 py-4 rounded-t-xl flex items-center justify-between">
            <h2 class="text-lg font-bold flex items-center gap-2">
                <i class="fas fa-star"></i>
                Barang Terbaru
            </h2>
            <a href="{{ route('mahasiswa.katalog') }}" class="text-blue-100 text-sm hover:text-white">
                Lihat semua
            </a>
        </div>
        <div class="p-6">
            @if(isset($barangPopuler) && $barangPopuler->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                @foreach($barangPopuler as $item)
                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition-all hover:-translate-y-1 card-hover">
                    @if($item->gambar)
                    <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama }}" class="w-full h-32 object-cover">
                    @else
                    <div class="w-full h-32 bg-gray-100 flex items-center justify-center">
                        <i class="fas fa-box fa-2x text-gray-300"></i>
                    </div>
                    @endif
                    <div class="p-4">
                        <h5 class="font-bold text-gray-800 mb-1 line-clamp-2">{{ $item->nama }}</h5>
                        <p class="text-xs text-gray-500 mb-2">{{ $item->kode_barang }}</p>
                        <div class="flex items-center justify-between text-xs">
                            <span class="@if($item->stok_tersedia > 0) bg-green-100 text-green-700 @else bg-red-100 text-red-700 @endif px-2 py-1 rounded-full font-semibold">
                                Stok: {{ $item->stok_tersedia }}
                            </span>
                            <a href="{{ route('mahasiswa.katalog', ['search' => $item->kode_barang]) }}" class="text-blue-600 hover:underline">
                                Lihat
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-gray-500 text-sm">Belum ada data barang untuk ditampilkan.</p>
            @endif
        </div>
    </div>
</div>

<style>
.card-hover {
    transition: all 0.3s ease;
}
.card-hover:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    border-color: #0d6efd;
}
</style>
@endsection
