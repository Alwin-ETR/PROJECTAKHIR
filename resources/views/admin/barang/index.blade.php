@extends('layouts.admin')

@section('title', 'Manajemen Barang')

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.btn-delete-barang').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const form = this.closest('form');
            const nama = this.getAttribute('data-nama') || 'barang';

            Swal.fire({
                title: 'Yakin hapus?',
                text: 'Data ' + nama + ' akan dihapus dan tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                reverseButtons: true,
                position: 'center',
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Sukses!',
        text: @json(session('success')),
        showConfirmButton: false,
        timer: 2200,
        position: 'center'
    });
    @endif

    @if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: @json(session('error')),
        showConfirmButton: false,
        timer: 2500,
        position: 'center'
    });
    @endif
});
</script>
@endpush

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-wrap items-center justify-between gap-3">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="bi bi-box-seam"></i>
            <span>Manajemen Inventaris</span>
        </h1>
        <a href="{{ route('admin.barang.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 transition">
            <i class="bi bi-plus-circle"></i>
            Tambah Barang Baru
        </a>
    </div>

    <!-- Tabel Barang -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-5 py-3 border-b border-gray-200 bg-gradient-to-r from-blue-600 to-indigo-600">
            <h2 class="text-sm font-semibold text-white flex items-center gap-2">
                <i class="bi bi-list-ul"></i>
                Daftar Barang
            </h2>
        </div>
        <div class="p-5">
            @if($barangs->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm border border-gray-200 rounded-lg overflow-hidden">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left font-semibold text-gray-700">#</th>
                                <th class="px-4 py-2 text-left font-semibold text-gray-700">Kode Barang</th>
                                <th class="px-4 py-2 text-left font-semibold text-gray-700">Nama Barang</th>
                                <th class="px-4 py-2 text-left font-semibold text-gray-700">Deskripsi</th>
                                <th class="px-4 py-2 text-left font-semibold text-gray-700">Stok</th>
                                <th class="px-4 py-2 text-left font-semibold text-gray-700">Status</th>
                                <th class="px-4 py-2 text-left font-semibold text-gray-700">Gambar</th>
                                <th class="px-4 py-2 text-left font-semibold text-gray-700">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @foreach($barangs as $barang)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 text-gray-600">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2">
                                        <span class="inline-flex px-2 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">
                                            {{ $barang->kode_barang }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 font-semibold text-gray-800">
                                        {{ $barang->nama }}
                                    </td>
                                    <td class="px-4 py-2 text-gray-600">
                                        {{ $barang->deskripsi ? Str::limit($barang->deskripsi, 50) : '-' }}
                                    </td>
                                    <td class="px-4 py-2">
                                        <span class="inline-flex px-2 py-1 rounded-full text-xs font-semibold
                                            {{ $barang->stok > 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                            {{ $barang->stok }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2">
                                        @php
                                            $statusClass =
                                                $barang->status == 'tersedia' ? 'bg-emerald-100 text-emerald-700' :
                                                ($barang->status == 'dipinjam' ? 'bg-amber-100 text-amber-700' : 'bg-gray-100 text-gray-700');
                                        @endphp
                                        <span class="inline-flex px-2 py-1 rounded-full text-xs font-semibold capitalize {{ $statusClass }}">
                                            {{ $barang->status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2">
                                        @if($barang->gambar)
                                            <img src="{{ asset('storage/' . $barang->gambar) }}"
                                                 alt="{{ $barang->nama }}"
                                                 class="w-12 h-12 rounded object-cover border border-gray-200">
                                        @else
                                            <span class="text-xs text-gray-400 italic">No image</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="flex gap-2">
                                            <a href="{{ route('admin.barang.edit', $barang->id) }}"
                                               class="inline-flex items-center gap-1 px-2 py-1 rounded-lg bg-amber-100 text-amber-700 hover:bg-amber-200 transition text-xs font-medium"
                                               title="Edit barang">
                                                <i class="bi bi-pencil text-sm"></i>
                                                <span class="hidden sm:inline">Edit</span>
                                            </a>

                                            <form action="{{ route('admin.barang.destroy', $barang->id) }}"
                                                  method="POST"
                                                  class="inline delete-barang-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                        class="inline-flex items-center gap-1 px-2 py-1 rounded-lg bg-red-100 text-red-700 hover:bg-red-200 transition text-xs font-medium btn-delete-barang"
                                                        data-nama="{{ $barang->nama }}"
                                                        title="Hapus barang">
                                                    <i class="bi bi-trash text-sm"></i>
                                                    <span class="hidden sm:inline">Hapus</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="py-10 text-center text-gray-500">
                    <i class="bi bi-inbox text-4xl mb-2"></i>
                    <h5 class="text-gray-700 font-semibold">Belum ada barang</h5>
                    <p class="text-sm text-gray-500 mb-4">Silakan tambah barang terlebih dahulu.</p>
                    <a href="{{ route('admin.barang.create') }}"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 transition">
                        <i class="bi bi-plus-circle"></i>
                        Tambah Barang Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
