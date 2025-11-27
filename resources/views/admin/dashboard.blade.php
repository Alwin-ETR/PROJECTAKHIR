@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Admin Panel</h1>
            <p class="text-sm text-gray-500">Ringkasan status inventaris dan peminjaman</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.barang.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 transition">
                <i class="bi bi-plus-circle"></i>
                Tambah Barang
            </a>
            <a href="{{ route('admin.barang.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-blue-600 text-blue-600 text-sm font-medium hover:bg-blue-50 transition">
                <i class="bi bi-list"></i>
                Lihat Semua Barang
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="stat-card bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 tracking-wide">TOTAL BARANG</p>
                    <p class="mt-2 text-2xl font-bold text-gray-800">{{ $stats['total_barang'] }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                    <i class="bi bi-box-seam"></i>
                </div>
            </div>
            <a href="{{ route('admin.barang.index') }}"
               class="mt-3 inline-flex items-center text-xs text-blue-600 hover:text-blue-800 font-medium">
                Kelola Barang <i class="bi bi-arrow-right-short text-base"></i>
            </a>
        </div>

        <div class="stat-card bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 tracking-wide">TOTAL MAHASISWA</p>
                    <p class="mt-2 text-2xl font-bold text-gray-800">{{ $stats['total_mahasiswa'] }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                    <i class="bi bi-people"></i>
                </div>
            </div>
            <a href="{{ route('admin.mahasiswa.index') }}"
               class="mt-3 inline-flex items-center text-xs text-emerald-600 hover:text-emerald-800 font-medium">
                Lihat Mahasiswa <i class="bi bi-arrow-right-short text-base"></i>
            </a>
        </div>

        <div class="stat-card bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 tracking-wide">PEMINJAMAN PENDING</p>
                    <p class="mt-2 text-2xl font-bold text-gray-800">{{ $stats['peminjaman_pending'] }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center text-amber-600">
                    <i class="bi bi-clock-history"></i>
                </div>
            </div>
            <a href="{{ route('admin.peminjaman.index') }}"
               class="mt-3 inline-flex items-center text-xs text-amber-600 hover:text-amber-800 font-medium">
                Proses Peminjaman <i class="bi bi-arrow-right-short text-base"></i>
            </a>
        </div>

        <div class="stat-card bg-white rounded-xl shadow-sm p-5 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 tracking-wide">PEMINJAMAN AKTIF</p>
                    <p class="mt-2 text-2xl font-bold text-gray-800">{{ $stats['peminjaman_aktif'] }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-sky-100 flex items-center justify-center text-sky-600">
                    <i class="bi bi-check-circle"></i>
                </div>
            </div>
            <a href="{{ route('admin.peminjaman.index') }}"
               class="mt-3 inline-flex items-center text-xs text-sky-600 hover:text-sky-800 font-medium">
                Lihat Aktif <i class="bi bi-arrow-right-short text-base"></i>
            </a>
        </div>
    </div>

    <!-- Peminjaman Terbaru -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mt-4">
        <div class="px-5 py-3 border-b border-gray-200 bg-gradient-to-r from-blue-600 to-indigo-600">
            <h2 class="text-sm font-semibold text-white flex items-center gap-2">
                <i class="bi bi-clock-history"></i>
                Peminjaman Terbaru
            </h2>
        </div>
        <div class="p-5">
            @if($peminjaman_terbaru->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm border border-gray-200 rounded-lg overflow-hidden">
                        <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left font-semibold text-gray-700">Mahasiswa</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-700">Barang</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-700">Tanggal</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-700">Status</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                        @foreach($peminjaman_terbaru as $peminjaman)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 font-semibold text-gray-800">
                                    {{ $peminjaman->user->name ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-2 text-gray-700">
                                    {{ $peminjaman->barang->nama ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-2 text-gray-600">
                                    {{ $peminjaman->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-4 py-2">
                                    @php
                                        $badgeClass =
                                            $peminjaman->status == 'disetujui' ? 'bg-emerald-100 text-emerald-700' :
                                            ($peminjaman->status == 'pending' ? 'bg-amber-100 text-amber-700' :
                                            ($peminjaman->status == 'dikembalikan' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700'));
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold capitalize {{ $badgeClass }}">
                                        {{ $peminjaman->status }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="py-10 text-center text-gray-500">
                    <i class="bi bi-inbox text-4xl mb-2"></i>
                    <p>Belum ada peminjaman.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
