@extends('layouts.admin')

@section('title', 'Riwayat Peminjaman Mahasiswa')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-wrap items-center justify-between gap-3">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="bi bi-clock-history"></i>
            <span>Riwayat Peminjaman Mahasiswa</span>
        </h1>
    </div>

    <!-- Data Mahasiswa -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-5 py-3 border-b border-gray-200 bg-gray-50">
            <h2 class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                <i class="bi bi-person-badge"></i>
                Data Mahasiswa
            </h2>
        </div>
        <div class="p-5">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2">
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3 text-sm">
                        <div>
                            <dt class="font-medium text-gray-600">NIM</dt>
                            <dd class="mt-1">
                                <span class="inline-flex px-2 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">
                                    {{ $user->nim }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-600">Nama</dt>
                            <dd class="mt-1 text-gray-800 font-semibold">{{ $user->name }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-600">Email</dt>
                            <dd class="mt-1 text-gray-700">{{ $user->email }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-600">Telepon</dt>
                            <dd class="mt-1 text-gray-700">{{ $user->phone }}</dd>
                        </div>
                    </dl>
                </div>
                <div>
                    <div class="rounded-xl border border-blue-100 bg-blue-50 px-4 py-4 text-center">
                        <p class="text-xs font-semibold text-blue-700 uppercase tracking-wide">Total Peminjaman</p>
                        <p class="mt-2 text-3xl font-bold text-blue-900">
                            {{ $peminjaman->count() }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Riwayat Peminjaman -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-5 py-3 border-b border-gray-200 bg-linear-to-br from-blue-600 to-indigo-600">
            <h2 class="text-sm font-semibold text-white flex items-center gap-2">
                <i class="bi bi-clipboard-check"></i>
                Riwayat Peminjaman
            </h2>
        </div>
        <div class="p-5">
            @if($peminjaman->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm border border-gray-200 rounded-lg overflow-hidden">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left font-semibold text-gray-700">#</th>
                                <th class="px-4 py-2 text-left font-semibold text-gray-700">Inventaris</th>
                                <th class="px-4 py-2 text-left font-semibold text-gray-700">Jumlah</th>
                                <th class="px-4 py-2 text-left font-semibold text-gray-700">Tanggal Pinjam</th>
                                <th class="px-4 py-2 text-left font-semibold text-gray-700">Tanggal Kembali</th>
                                <th class="px-4 py-2 text-left font-semibold text-gray-700">Status</th>
                                <th class="px-4 py-2 text-left font-semibold text-gray-700">Keterlambatan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @foreach($peminjaman as $index => $p)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 text-gray-600">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2">
                                        <p class="font-semibold text-gray-800">
                                            {{ $p->barang->nama }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            Kode: {{ $p->barang->kode_barang }}
                                        </p>
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
                                        @php
                                            $statusClass =
                                                $p->status == 'disetujui' ? 'bg-emerald-100 text-emerald-700' :
                                                ($p->status == 'pending' ? 'bg-amber-100 text-amber-700' :
                                                ($p->status == 'dikembalikan' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700'));
                                        @endphp
                                        <span class="inline-flex px-2 py-1 rounded-full text-xs font-semibold capitalize {{ $statusClass }}">
                                            {{ $p->status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2">
                                        @php
                                            $today = now()->startOfDay();
                                            $due   = $p->tanggal_kembali->startOfDay();
                                        @endphp

                                        @if($p->isOverdue())
                                            @php
                                                // jumlah hari telat (integer)
                                                $daysLate = $today->diffInDays($due, false) * -1; // hasil negatif dibalik
                                            @endphp
                                            <span class="inline-flex px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                                Terlambat {{ $daysLate }} hari
                                            </span>

                                        @elseif($p->status == 'disetujui' && $today->lessThanOrEqualTo($due))
                                            @php
                                                // sisa hari sampai jatuh tempo (bisa 0,1,2,...)
                                                $daysLeft = $today->diffInDays($due, false);
                                            @endphp
                                            @if($daysLeft >= 0)
                                                <span class="inline-flex px-2 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                                    {{ $daysLeft }} hari lagi
                                                </span>
                                            @endif

                                        @else
                                            <span class="text-xs text-gray-400">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="py-10 text-center text-gray-500">
                    <i class="fas fa-clipboard-list text-4xl mb-2 text-gray-400"></i>
                    <p>Mahasiswa ini belum memiliki riwayat peminjaman.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
