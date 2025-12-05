@extends('layouts.mahasiswa')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- SUSPEND ALERT -->
    @if(auth()->user()->isSuspended())
        @php
            $suspension = auth()->user()->getActiveSuspension();
        @endphp
        
        <div class="mb-6 p-5 rounded-xl bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-600 shadow-md">
            <div class="flex items-start gap-4">
                <i class="fas fa-exclamation-triangle text-red-600 text-3xl mt-1 flex-shrink-0"></i>
                <div class="flex-1">
                    <h3 class="font-bold text-red-900 text-lg mb-3">🚫 Akun Anda Sedang Dalam Status Suspend</h3>
                    <div class="space-y-2 text-red-800">
                        <p><strong>📋 Alasan Suspend:</strong> {{ $suspension->reason }}</p>
                        <p><strong>⏰ Suspend Berakhir:</strong> {{ $suspension->suspended_until->format('d M Y') }}</p>
                        <p class="text-base mt-3">
                            <strong>⏱️ Sisa Waktu:</strong> 
                            <span class="text-2xl font-bold text-red-700">{{ $suspension->getRemainingDays() }} hari</span>
                        </p>
                    </div>
                    <div class="mt-4 p-3 rounded-lg bg-red-200 text-red-900 text-sm border border-red-300">
                        <strong>⚠️ Perhatian:</strong> Anda TIDAK DAPAT membuat peminjaman baru sampai suspend berakhir. Anda masih dapat melihat katalog, tetapi tombol "Pinjam" akan dinonaktifkan.
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- END SUSPEND ALERT -->

    <!-- Title Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Katalog Barang</h1>
        <p class="text-gray-500">Jelajahi semua barang yang tersedia untuk dipinjam</p>
    </div>

    <!-- Search & Filter Bar -->
    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
        <form action="{{ route('mahasiswa.katalog') }}" method="GET" class="flex gap-2">
            <input type="text" name="search" placeholder="Cari barang berdasarkan nama, kode, atau deskripsi..."
                   value="{{ request('search') }}" class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium flex items-center gap-2">
                <i class="fas fa-search"></i>
                Cari
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

    <!-- Keranjang Peminjaman -->
    @php
        $cartItems = session('cart_peminjaman', []);
    @endphp

    @if(count($cartItems) > 0)
    <div class="bg-white rounded-xl shadow-sm mb-6 border-l-4 border-amber-500">
        <div class="bg-amber-50 px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                <i class="fas fa-shopping-cart text-amber-600"></i>
                Keranjang Peminjaman
                <span class="ml-2 px-3 py-1 bg-red-500 text-white text-sm rounded-full font-semibold">{{ count($cartItems) }}</span>
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                @foreach($cartItems as $id => $item)
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 hover:shadow-md transition">
                    <h5 class="font-bold text-gray-800 mb-3">{{ $item['nama'] }}</h5>
                    <div class="space-y-2 text-sm text-gray-600 mb-4">
                        <p><strong>Kode:</strong>
                            <code class="bg-gray-100 px-2 py-1 rounded text-gray-800 text-xs block break-all">
                                {{ $item['kode_barang'] }}
                            </code>
                        </p>
                        <p><strong>Jumlah:</strong> <span id="quantity-{{ $id }}">{{ $item['quantity'] }}</span></p>
                        <p><strong>Status:</strong>
                            <span class="px-2 py-1 rounded text-white text-xs font-semibold
                                @if($item['status_badge'] === 'success') bg-green-500
                                @elseif($item['status_badge'] === 'warning') bg-amber-500
                                @elseif($item['status_badge'] === 'danger') bg-red-500
                                @else bg-blue-500
                                @endif">
                                {{ $item['status_text'] }}
                            </span>
                        </p>
                    </div>
                    <div class="flex gap-2 flex-wrap">
                        <div class="flex items-center border border-gray-300 rounded-lg">
                            <button class="px-2 py-1 text-gray-600 hover:bg-gray-200 transition" type="button" onclick="updateQuantity({{ $id }}, -1)">
                                <i class="fas fa-minus text-xs"></i>
                            </button>
                            <input type="number" id="input-{{ $id }}"
                                    value="{{ $item['quantity'] }}"
                                    min="1" max="{{ $item['max_stok'] }}"
                                    class="w-12 text-center border-none focus:outline-none"
                                    onchange="updateQuantity({{ $id }}, 0, this.value)">
                            <button class="px-2 py-1 text-gray-600 hover:bg-gray-200 transition" type="button" onclick="updateQuantity({{ $id }}, 1)">
                                <i class="fas fa-plus text-xs"></i>
                            </button>
                        </div>
                        <form action="{{ route('mahasiswa.cart.remove', $id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition text-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                <form action="{{ route('mahasiswa.cart.clear') }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition font-medium text-sm">
                        <i class="fas fa-trash-alt"></i> Kosongkan Keranjang
                    </button>
                </form>
                
                @if(auth()->user()->isSuspended())
                    <button disabled class="px-4 py-2 bg-gray-400 text-white rounded-lg cursor-not-allowed font-medium flex items-center gap-2 text-sm opacity-60">
                        <i class="fas fa-lock"></i>
                        Suspend - Tidak Bisa Ajukan
                    </button>
                @else
                    <a href="{{ route('mahasiswa.pengajuan.form') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium flex items-center gap-2">
                        <i class="fas fa-paper-plane"></i>
                        Ajukan Peminjaman
                    </a>
                @endif
            </div>
        </div>
    </div>
    @endif

    <!-- Katalog Barang -->
    <div class="bg-white rounded-xl shadow-sm">
        <div class="bg-blue-800 text-white px-6 py-4 rounded-t-xl">
            <h2 class="text-lg font-bold flex items-center gap-2">
                <i class="fas fa-book-open"></i>
                Katalog Lengkap
                <span class="ml-2 px-3 py-1 bg-blue-700 text-white text-sm rounded-full">{{ $barang->count() }}</span>
            </h2>
        </div>
        <div class="p-6">
            @if($barang->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($barang as $item)
                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition-all hover:-translate-y-1 card-hover">
                    <!-- Gambar -->
                    @if($item->gambar)
                    <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama }}" class="w-full h-48 object-cover">
                    @else
                    <div class="w-full h-48 bg-gray-100 flex items-center justify-center">
                        <i class="fas fa-box fa-3x text-gray-300"></i>
                    </div>
                    @endif

                    <!-- Content -->
                    <div class="p-4">
                        <h5 class="font-bold text-gray-800 mb-2 line-clamp-2">{{ $item->nama }}</h5>

                        <div class="space-y-3 text-sm mb-4">
                            <!-- Kode Barang -->
                            <div>
                                <p class="text-gray-600 font-medium mb-1"><strong>Kode:</strong></p>
                                <code class="bg-gray-100 px-2 py-1 rounded text-gray-800 text-xs block break-all">
                                    {{ $item->kode_barang }}
                                </code>
                            </div>

                            <!-- Deskripsi -->
                            @if($item->deskripsi)
                            <div>
                                <p class="text-gray-600 line-clamp-2">{{ $item->deskripsi }}</p>
                            </div>
                            @endif

                            <!-- Stok -->
                            <div class="flex items-center justify-between">
                                <p class="text-gray-600"><strong>Stok:</strong></p>
                                <span class="@if($item->stok_tersedia > 0) bg-green-100 text-green-700 @else bg-red-100 text-red-700 @endif px-3 py-1 rounded-full text-xs font-bold">
                                    {{ $item->stok_tersedia }} unit
                                </span>
                            </div>

                            <!-- Status -->
                            <div class="flex items-center justify-between">
                                <p class="text-gray-600"><strong>Status:</strong></p>
                                <span class="px-3 py-1 rounded-full text-white text-xs font-semibold
                                    @if($item->status_badge === 'success') bg-green-500
                                    @elseif($item->status_badge === 'warning') bg-amber-500
                                    @elseif($item->status_badge === 'danger') bg-red-500
                                    @else bg-blue-500
                                    @endif">
                                    {{ $item->status_text }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="border-t border-gray-200 p-4 flex gap-2">
                        <button type="button" class="flex-1 px-3 py-2 border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 transition text-sm font-medium" onclick="showBarangDetail({{ $item->id }})">
                            <i class="fas fa-eye"></i> Detail
                        </button>
                        @if(auth()->user()->isSuspended())
                            <button class="flex-1 px-3 py-2 bg-gray-300 text-gray-600 rounded-lg cursor-not-allowed text-sm font-medium" disabled title="Anda tidak bisa pinjam saat suspend">
                                <i class="fas fa-ban"></i> Suspend
                            </button>
                        @elseif($item->canBeBorrowed())
                            <form action="{{ route('mahasiswa.cart.add', $item->id) }}" method="POST" class="inline flex-1">
                                @csrf
                                <button type="submit" class="w-full px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                                    <i class="fas fa-cart-plus"></i> Pinjam
                                </button>
                            </form>
                        @else
                            <button class="flex-1 px-3 py-2 bg-gray-300 text-gray-600 rounded-lg cursor-not-allowed text-sm font-medium" disabled>
                                <i class="fas fa-lock"></i> Tidak Tersedia
                            </button>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-16">
                <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Tidak ada barang ditemukan</h3>
                <p class="text-gray-500">Coba ubah pencarian atau kembali nanti</p>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Detail Barang -->
<div id="barangDetailModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4 modal">
    <div class="bg-white rounded-xl shadow-xl max-w-2xl w-full modal-content">
        <div class="bg-blue-900 text-white px-6 py-4 flex justify-between items-center rounded-t-xl">
            <h2 class="text-lg font-bold">Informasi Barang</h2>
            <button onclick="closeModal()" class="text-white hover:text-gray-200">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <div id="barangDetailContent" class="p-6">
            <!-- Content akan diisi via JavaScript -->
        </div>
    </div>
</div>

<script>
function updateQuantity(itemId, change, customValue = null) {
    const input = document.getElementById('input-' + itemId);
    const quantitySpan = document.getElementById('quantity-' + itemId);

    let newQuantity;

    if (customValue !== null) {
        newQuantity = parseInt(customValue);
    } else {
        newQuantity = parseInt(input.value) + change;
    }

    const maxStock = parseInt(input.max);
    if (newQuantity < 1) newQuantity = 1;
    if (newQuantity > maxStock) newQuantity = maxStock;

    input.value = newQuantity;
    quantitySpan.textContent = newQuantity;

    fetch(`/mahasiswa/cart/update/${itemId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ quantity: newQuantity })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('success', data.message || 'Jumlah berhasil diupdate');
        } else {
            input.value = parseInt(input.value) - change;
            quantitySpan.textContent = input.value;
            showToast('error', data.message || 'Terjadi kesalahan');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        input.value = parseInt(input.value) - change;
        quantitySpan.textContent = input.value;
        showToast('error', 'Terjadi kesalahan saat mengupdate');
    });
}

function showToast(type, message) {
    const bgColor = type === 'success' ? 'bg-green-500' : (type === 'error' ? 'bg-red-500' : 'bg-blue-500');
    const icon = type === 'success' ? 'fa-check-circle' : (type === 'error' ? 'fa-exclamation-triangle' : 'fa-info-circle');

    const toast = document.createElement('div');
    toast.className = `${bgColor} text-white px-6 py-4 rounded-lg shadow-lg flex items-center gap-3`;
    toast.innerHTML = `
        <i class="fas ${icon}"></i>
        <span>${message}</span>
        <button onclick="this.parentElement.remove()" class="ml-auto text-white hover:text-gray-200">
            <i class="fas fa-times"></i>
        </button>
    `;

    const container = document.getElementById('toast-container') || document.createElement('div');
    if (!container.id) {
        container.id = 'toast-container';
        container.className = 'fixed top-4 right-4 z-50 space-y-2';
        document.body.appendChild(container);
    }

    container.appendChild(toast);

    setTimeout(() => {
        if (toast.parentNode) {
            toast.parentNode.removeChild(toast);
        }
    }, 5000);
}

function showBarangDetail(barangId) {
    const modal = document.getElementById('barangDetailModal');
    const content = document.getElementById('barangDetailContent');

    content.innerHTML = `
        <div class="text-center py-8">
            <i class="fas fa-spinner fa-spin text-3xl text-blue-600"></i>
            <p class="mt-3 text-gray-600">Memuat detail barang...</p>
        </div>
    `;

    modal.classList.remove('hidden');

    fetch(`/mahasiswa/barang/${barangId}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.text())
    .then(html => {
        document.getElementById('barangDetailContent').innerHTML = html;
    })
    .catch(error => {
        document.getElementById('barangDetailContent').innerHTML = `
            <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg">
                <i class="fas fa-exclamation-triangle"></i>
                Gagal memuat detail barang.
            </div>
        `;
    });
}

function closeModal() {
    document.getElementById('barangDetailModal').classList.add('hidden');
}

document.getElementById('barangDetailModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});
</script>

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