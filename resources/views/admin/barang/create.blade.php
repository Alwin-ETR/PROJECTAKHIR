@extends('layouts.admin')

@section('title', 'Tambah Barang Baru')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-wrap items-center justify-between gap-3">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="bi bi-plus-circle"></i>
            <span>Tambah Barang Baru</span>
        </h1>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-5 py-3 border-b border-gray-200 bg-blue-600">
            <h2 class="text-sm font-semibold text-white flex items-center gap-2">
                <i class="bi bi-box-seam"></i>
                Form Tambah Barang
            </h2>
        </div>

        <div class="p-5">
            <form method="POST" action="{{ route('admin.barang.store') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="kode_barang" class="block text-sm font-medium text-gray-700">
                            Kode Barang <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               id="kode_barang"
                               name="kode_barang"
                               value="{{ old('kode_barang') }}"
                               required
                               class="mt-1 block w-full rounded-lg border @error('kode_barang') border-red-500 @else border-gray-300 @enderror px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('kode_barang')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700">
                            Nama Barang <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               id="nama"
                               name="nama"
                               value="{{ old('nama') }}"
                               required
                               class="mt-1 block w-full rounded-lg border @error('nama') border-red-500 @else border-gray-300 @enderror px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('nama')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700">
                        Deskripsi
                    </label>
                    <textarea id="deskripsi"
                              name="deskripsi"
                              rows="3"
                              class="mt-1 block w-full rounded-lg border @error('deskripsi') border-red-500 @else border-gray-300 @enderror px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="stok" class="block text-sm font-medium text-gray-700">
                            Stok <span class="text-red-500">*</span>
                        </label>
                        <input type="number"
                               id="stok"
                               name="stok"
                               value="{{ old('stok', 0) }}"
                               min="0"
                               required
                               class="mt-1 block w-full rounded-lg border @error('stok') border-red-500 @else border-gray-300 @enderror px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('stok')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select id="status"
                                name="status"
                                required
                                class="mt-1 block w-full rounded-lg border @error('status') border-red-500 @else border-gray-300 @enderror px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="tersedia" {{ old('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="dipinjam" {{ old('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                            <option value="perbaikan" {{ old('status') == 'perbaikan' ? 'selected' : '' }}>Perbaikan</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="gambar" class="block text-sm font-medium text-gray-700">
                            Gambar
                        </label>
                        <input type="file"
                               id="gambar"
                               name="gambar"
                               accept="image/*"
                               class="mt-1 block w-full rounded-lg border @error('gambar') border-red-500 @else border-gray-300 @enderror px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <p class="mt-1 text-xs text-gray-500">Max 2MB, format: JPG, PNG, JPEG.</p>
                        @error('gambar')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex flex-wrap justify-end gap-2 pt-3 border-t border-gray-100">
                    <button type="reset"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 text-gray-700 text-sm font-medium hover:bg-gray-100 transition">
                        <i class="bi bi-arrow-clockwise"></i>
                        Reset
                    </button>
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 transition">
                        <i class="bi bi-save"></i>
                        Simpan Barang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
