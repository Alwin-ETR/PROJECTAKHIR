@extends('layouts.admin')

@section('title', 'Unduh Laporan Peminjaman')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-wrap items-center justify-between gap-3">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="bi bi-file-earmark-bar-graph"></i>
            <span>Unduh Laporan Riwayat Peminjaman</span>
        </h1>
    </div>

    <!-- Form Filter Laporan -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-5 py-3 border-b border-gray-200 bg-emerald-600">
            <h2 class="text-sm font-semibold text-white flex items-center gap-2">
                <i class="bi bi-funnel"></i>
                Filter Laporan
            </h2>
        </div>
        <div class="p-5">
            <form method="GET"
                  action="{{ route('admin.peminjaman.laporan.download') }}"
                  target="_blank"
                  class="space-y-5">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700">
                            Tanggal Mulai
                        </label>
                        <input type="date"
                               name="start_date"
                               id="start_date"
                               class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700">
                            Tanggal Akhir
                        </label>
                        <input type="date"
                               name="end_date"
                               id="end_date"
                               class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="mahasiswa_id" class="block text-sm font-medium text-gray-700">
                            Mahasiswa
                        </label>
                        <select name="mahasiswa_id"
                                id="mahasiswa_id"
                                class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Mahasiswa</option>
                            @foreach($list_mahasiswa as $mhs)
                                <option value="{{ $mhs->id }}">
                                    {{ $mhs->name }} ({{ $mhs->nim }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">
                            Status
                        </label>
                        <select name="status"
                                id="status"
                                class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Status</option>
                            <option value="pending">Pending</option>
                            <option value="disetujui">Disetujui</option>
                            <option value="borrowed">Dipinjam</option>
                            <option value="returned">Dikembalikan</option>
                            <option value="ditolak">Ditolak</option>
                        </select>
                    </div>

                    <div>
                        <label for="terbaru" class="block text-sm font-medium text-gray-700">
                            Terbaru Saja
                        </label>
                        <select name="terbaru"
                                id="terbaru"
                                class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="0">Semua Data</option>
                            <option value="1">Hanya 10 Terakhir</option>
                        </select>
                    </div>
                </div>

                <div class="pt-3 border-t border-gray-100">
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-emerald-600 text-white text-sm font-medium hover:bg-emerald-700 transition">
                        <i class="fas fa-file-download"></i>
                        Download Laporan PDF
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
