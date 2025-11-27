@extends('layouts.admin')

@section('title', 'Manajemen Peminjaman')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-wrap items-center justify-between gap-3">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="bi bi-clipboard-check"></i>
            <span>Manajemen Peminjaman</span>
        </h1>

        <a href="{{ route('admin.peminjaman.laporan') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-emerald-600 text-white text-sm font-medium hover:bg-emerald-700 transition">
            <i class="fas fa-file-pdf"></i>
            Download Laporan PDF
        </a>
    </div>

    <!-- Alert -->
    @if(session('success'))
        <div class="flex items-center gap-2 px-4 py-3 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm">
            <i class="bi bi-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="flex items-center gap-2 px-4 py-3 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm">
            <i class="bi bi-exclamation-circle"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Tabel Peminjaman -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-5 py-3 border-b border-gray-200 bg-gradient-to-r from-blue-600 to-indigo-600">
            <h2 class="text-sm font-semibold text-white flex items-center gap-2">
                <i class="bi bi-list-ul"></i>
                Daftar Peminjaman
            </h2>
        </div>
        <div class="p-5">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm border border-gray-200 rounded-lg overflow-hidden">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left font-semibold text-gray-700">Mahasiswa</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-700">Inventaris</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-700">Jumlah</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-700">Tanggal Pinjam</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-700">Tanggal Kembali</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-700">Status</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @foreach($peminjaman as $p)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2">
                                    <p class="font-semibold text-gray-800">{{ $p->user->name }}</p>
                                    <p class="text-xs text-gray-500">NIM: {{ $p->user->nim }}</p>
                                </td>
                                <td class="px-4 py-2 text-gray-700">
                                    {{ $p->barang->nama }}
                                </td>
                                <td class="px-4 py-2 text-gray-700">
                                    {{ $p->jumlah }}
                                </td>
                                <td class="px-4 py-2 text-gray-600">
                                    {{ $p->tanggal_pinjam->format('d/m/Y') }}
                                </td>
                                <td class="px-4 py-2 text-gray-600">
                                    {{ $p->tanggal_kembali->format('d/m/Y') }}
                                </td>
                                <td class="px-4 py-2">
                                    <span class="inline-flex px-2 py-1 rounded-full text-xs font-semibold capitalize bg-{{ $p->status_badge == 'success' ? 'emerald' : ($p->status_badge == 'warning' ? 'amber' : ($p->status_badge == 'danger' ? 'red' : 'gray')) }}-100 text-{{ $p->status_badge == 'success' ? 'emerald' : ($p->status_badge == 'warning' ? 'amber' : ($p->status_badge == 'danger' ? 'red' : 'gray')) }}-700">
                                        {{ $p->status_text }}
                                    </span>
                                    @if($p->isOverdue())
                                        <span class="inline-flex mt-1 px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                            <i class="fas fa-exclamation-triangle mr-1"></i> Terlambat
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-2">
                                    @if($p->status === 'pending')
                                        <div class="flex flex-wrap gap-2">
                                            <form method="POST" action="{{ route('admin.peminjaman.approve', $p->id) }}">
                                                @csrf
                                                <button type="submit"
                                                        onclick="return confirm('Setujui peminjaman ini?')"
                                                        class="inline-flex items-center gap-1 px-3 py-1 rounded-lg bg-emerald-100 text-emerald-700 hover:bg-emerald-200 transition text-xs font-medium">
                                                    <i class="fas fa-check text-xs"></i>
                                                    <span class="hidden sm:inline">Setujui</span>
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.peminjaman.reject', $p->id) }}">
                                                @csrf
                                                <button type="submit"
                                                        onclick="return confirm('Tolak peminjaman ini?')"
                                                        class="inline-flex items-center gap-1 px-3 py-1 rounded-lg bg-red-100 text-red-700 hover:bg-red-200 transition text-xs font-medium">
                                                    <i class="fas fa-times text-xs"></i>
                                                    <span class="hidden sm:inline">Tolak</span>
                                                </button>
                                            </form>
                                        </div>
                                    @elseif($p->status === 'dikembalikan')
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-lg bg-emerald-100 text-emerald-700 text-xs font-medium">
                                            <i class="fas fa-check-circle text-xs"></i>
                                            Selesai
                                        </span>
                                    @elseif($p->status === 'disetujui')
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-lg bg-blue-100 text-blue-700 text-xs font-medium">
                                            <i class="fas fa-clock text-xs"></i>
                                            Sedang Dipinjam
                                        </span>
                                    @elseif($p->status === 'ditolak')
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-lg bg-gray-100 text-gray-700 text-xs font-medium">
                                            <i class="fas fa-ban text-xs"></i>
                                            Ditolak
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
