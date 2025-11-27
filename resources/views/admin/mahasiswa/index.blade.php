@extends('layouts.admin')

@section('title', 'Data Mahasiswa')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-wrap items-center justify-between gap-3">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="bi bi-people"></i>
            <span>Data Mahasiswa</span>
        </h1>
    </div>

    <!-- Tabel Mahasiswa -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-5 py-3 border-b border-gray-200 bg-gradient-to-r from-blue-600 to-indigo-600">
            <h2 class="text-sm font-semibold text-white flex items-center gap-2">
                <i class="bi bi-list-ul"></i>
                Daftar Mahasiswa
            </h2>
        </div>
        <div class="p-5">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm border border-gray-200 rounded-lg overflow-hidden">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left font-semibold text-gray-700">NIM</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-700">Nama</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-700">Email</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-700">Telepon</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-700">Total Peminjaman</th>
                            <th class="px-4 py-2 text-left font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @foreach($mahasiswa as $mhs)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2">
                                    <span class="inline-flex px-2 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">
                                        {{ $mhs->nim }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 font-semibold text-gray-800">
                                    {{ $mhs->name }}
                                </td>
                                <td class="px-4 py-2 text-gray-600">
                                    {{ $mhs->email }}
                                </td>
                                <td class="px-4 py-2 text-gray-600">
                                    {{ $mhs->phone }}
                                </td>
                                <td class="px-4 py-2">
                                    <span class="inline-flex px-2 py-1 rounded-full bg-sky-100 text-sky-700 text-xs font-semibold">
                                        {{ $mhs->peminjamans->count() }}
                                    </span>
                                </td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('admin.mahasiswa.peminjaman', $mhs->id) }}"
                                       class="inline-flex items-center gap-1 px-3 py-1 rounded-lg bg-sky-100 text-sky-700 hover:bg-sky-200 transition text-xs font-medium"
                                       title="Lihat riwayat peminjaman">
                                        <i class="fas fa-eye text-xs"></i>
                                        <span class="hidden sm:inline">Lihat Peminjaman</span>
                                    </a>
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
