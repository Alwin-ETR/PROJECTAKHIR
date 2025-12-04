<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        @if($barang->gambar)
            <img src="{{ asset('storage/' . $barang->gambar) }}"
                 alt="{{ $barang->nama }}"
                 class="w-full max-h-72 object-cover rounded-xl border border-gray-200">
        @else
            <div class="w-full h-52 bg-gray-100 rounded-xl flex items-center justify-center border border-dashed border-gray-300">
                <i class="fas fa-box fa-3x text-gray-300"></i>
            </div>
        @endif
    </div>

    <div>
        <h4 class="text-xl font-bold text-gray-800 mb-4">{{ $barang->nama }}</h4>

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
            <table class="w-full text-sm">
                <tbody class="divide-y divide-gray-100">
                    <tr>
                        <td class="px-4 py-3 w-40 font-semibold text-gray-600">Kode Barang</td>
                        <td class="px-4 py-3">
                            <code class="inline-block px-2 py-1 rounded bg-gray-100 text-gray-800 text-xs">
                                {{ $barang->kode_barang }}
                            </code>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 font-semibold text-gray-600">Stok Total</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex px-2 py-1 rounded-full bg-gray-100 text-gray-700 text-xs font-semibold">
                                {{ $barang->stok }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 font-semibold text-gray-600">Stok Tersedia</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex px-2 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-semibold">
                                {{ $barang->stok_tersedia }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 font-semibold text-gray-600">Status</td>
                        <td class="px-4 py-3">
                            @php
                                $badgeClass =
                                    $barang->status_badge === 'success' ? 'bg-emerald-100 text-emerald-700' :
                                    ($barang->status_badge === 'warning' ? 'bg-amber-100 text-amber-700' :
                                    ($barang->status_badge === 'danger' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-700'));
                            @endphp
                            <span class="inline-flex px-2 py-1 rounded-full text-xs font-semibold capitalize {{ $badgeClass }}">
                                {{ $barang->status_text }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3 align-top font-semibold text-gray-600">Deskripsi</td>
                        <td class="px-4 py-3 text-gray-700">
                            @if($barang->deskripsi)
                                {{ $barang->deskripsi }}
                            @else
                                <span class="text-xs italic text-gray-400">Tidak ada deskripsi</span>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-5">
            @if($barang->canBeBorrowed())
                <form action="{{ route('mahasiswa.cart.add', $barang->id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 transition">
                        <i class="fas fa-cart-plus"></i>
                        Tambah ke Keranjang
                    </button>
                </form>
            @else
                <button type="button"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-gray-300 text-gray-700 text-sm font-medium cursor-not-allowed"
                        disabled>
                    <i class="fas fa-ban"></i>
                    {{ $barang->status === 'perbaikan' ? 'Dalam Perbaikan' : 'Tidak Tersedia' }}
                </button>
            @endif
        </div>
    </div>
</div>
