@extends('layouts.mahasiswa')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Title Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Riwayat Peminjaman</h1>
        <p class="text-gray-500">Kelola semua peminjaman barang Anda</p>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <!-- Header -->
        <div class="bg-blue-600 text-white px-6 py-4">
            <h2 class="text-lg font-bold flex items-center gap-2">
                <i class="fas fa-history"></i>
                Daftar Peminjaman
            </h2>
        </div>

        <!-- Content -->
        <div class="p-6">
            @if($peminjaman->count() > 0)
                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-100 border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">Barang</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">Jumlah</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">Tanggal Pinjam</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">Tanggal Kembali</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">Status</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($peminjaman as $pinjam)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 text-gray-800 font-medium">{{ $pinjam->barang->nama }}</td>
                                <td class="px-4 py-3 text-gray-600">
                                    <span class="inline-block bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-xs font-semibold">
                                        {{ $pinjam->jumlah }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-gray-600">{{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('d/m/Y') }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ \Carbon\Carbon::parse($pinjam->tanggal_kembali)->format('d/m/Y') }}</td>
                                <td class="px-4 py-3">
                                    @php
                                        $statusConfig = [
                                            'pending' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-800', 'icon' => 'fa-clock'],
                                            'disetujui' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'icon' => 'fa-check-circle'],
                                            'ditolak' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'icon' => 'fa-times-circle'],
                                            'dikembalikan' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'icon' => 'fa-check-double']
                                        ];
                                        $config = $statusConfig[$pinjam->status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'icon' => 'fa-question-circle'];
                                    @endphp
                                    <span class="inline-block {{ $config['bg'] }} {{ $config['text'] }} px-3 py-1 rounded-full text-xs font-semibold capitalize">
                                        <i class="fas {{ $config['icon'] }} mr-1"></i>{{ $pinjam->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-2 flex-wrap">
                                        @if($pinjam->status === 'disetujui')
                                            <!-- Tombol Konfirmasi Pengembalian -->
                                            <form method="POST" action="{{ route('mahasiswa.peminjaman.return', $pinjam->id) }}" class="inline">
                                                @csrf
                                                <button type="submit"
                                                        class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition text-xs font-medium"
                                                        onclick="return confirm('Konfirmasi bahwa Anda telah mengembalikan barang ini?')">
                                                    <i class="fas fa-undo"></i> Kembalikan
                                                </button>
                                            </form>
                                        @elseif($pinjam->status === 'pending')
                                            <button class="px-3 py-1 bg-amber-100 text-amber-800 rounded-lg cursor-not-allowed text-xs font-medium" disabled>
                                                <i class="fas fa-clock"></i> Menunggu
                                            </button>
                                        @elseif($pinjam->status === 'dikembalikan')
                                            <button class="px-3 py-1 bg-green-100 text-green-800 rounded-lg cursor-not-allowed text-xs font-medium" disabled>
                                                <i class="fas fa-check"></i> Selesai
                                            </button>
                                        @elseif($pinjam->status === 'ditolak')
                                            <button class="px-3 py-1 bg-red-100 text-red-800 rounded-lg cursor-not-allowed text-xs font-medium" disabled>
                                                <i class="fas fa-times"></i> Ditolak
                                            </button>
                                        @endif

                                        <!-- Tombol Download Bukti PDF -->
                                        <a href="{{ route('mahasiswa.peminjaman.bukti-pdf', $pinjam->id) }}"
                                           class="px-3 py-1 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition text-xs font-medium"
                                           target="_blank">
                                            <i class="fas fa-file-pdf"></i> Bukti
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($peminjaman->hasPages())
                <div class="mt-6 flex justify-center">
                    <div class="space-x-2">
                        {{ $peminjaman->links('pagination::tailwind') }}
                    </div>
                </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="text-center py-16">
                    <div class="inline-block bg-gray-100 p-4 rounded-full mb-4">
                        <i class="fas fa-inbox text-5xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Belum ada riwayat peminjaman</h3>
                    <p class="text-gray-500 mb-6">Mulai pinjam barang untuk melihat riwayat di sini</p>
                    <a href="{{ route('mahasiswa.katalog') }}" class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                        Pinjam Barang
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
