@extends('layouts.mahasiswa')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Title Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Form Pengajuan Peminjaman</h1>
        <p class="text-gray-500">Ajukan peminjaman barang dari keranjang Anda</p>
    </div>

    <!-- Alert Session -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-4 rounded-lg mb-6 flex items-start gap-3" role="alert">
            <i class="fas fa-check-circle mt-0.5"></i>
            <span>{{ session('success') }}</span>
            <button type="button" class="ml-auto text-green-700 hover:text-green-900" onclick="this.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-4 rounded-lg mb-6 flex items-start gap-3" role="alert">
            <i class="fas fa-exclamation-triangle mt-0.5"></i>
            <span>{{ session('error') }}</span>
            <button type="button" class="ml-auto text-red-700 hover:text-red-900" onclick="this.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Form -->
        <div class="lg:col-span-2">
            <!-- Daftar Barang di Keranjang -->
            <div class="bg-white rounded-xl shadow-sm mb-6 overflow-hidden">
                <div class="bg-amber-50 border-b border-gray-200 px-6 py-4">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-shopping-cart text-amber-600"></i>
                        Barang yang akan Dipinjam
                        <span class="ml-2 px-3 py-1 bg-red-500 text-white text-sm rounded-full font-semibold">{{ count($cartItems) }}</span>
                    </h3>
                </div>
                <div class="p-6">
                    @if(count($cartItems) > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-100 border-b border-gray-200">
                                <tr>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Nama Barang</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Kode</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Jumlah</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($cartItems as $id => $item)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3 text-gray-800 font-medium">{{ $item['nama'] }}</td>
                                    <td class="px-4 py-3">
                                        <code class="bg-gray-100 px-2 py-1 rounded text-gray-800 text-xs">
                                            {{ $item['kode_barang'] }}
                                        </code>
                                    </td>
                                    <td class="px-4 py-3 text-gray-600">{{ $item['quantity'] }}</td>
                                    <td class="px-4 py-3">
                                        @php
                                            $statusColors = [
                                                'success' => 'bg-green-100 text-green-800',
                                                'warning' => 'bg-amber-100 text-amber-800',
                                                'danger' => 'bg-red-100 text-red-800',
                                                'info' => 'bg-blue-100 text-blue-800'
                                            ];
                                            $statusClass = $statusColors[$item['status_badge']] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">
                                            {{ $item['status_text'] }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-8">
                        <i class="fas fa-inbox text-5xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500">Keranjang kosong</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Informasi Peminjaman Aktif Lainnya -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="bg-blue-50 border-b border-gray-200 px-6 py-4">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-users text-blue-600"></i>
                        Peminjaman Aktif oleh Mahasiswa Lain
                    </h3>
                </div>
                <div class="p-6">
                    @php
                        $peminjamanAktifLain = \App\Models\Peminjaman::with(['barang', 'user'])
                            ->whereIn('barang_id', array_keys($cartItems))
                            ->whereIn('status', ['disetujui', 'pending'])
                            ->where('user_id', '!=', Auth::id())
                            ->where('tanggal_kembali', '>=', now())
                            ->orderBy('tanggal_kembali', 'asc')
                            ->get();
                    @endphp

                    @if($peminjamanAktifLain->count() > 0)
                        <div class="overflow-x-auto mb-4">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-100 border-b border-gray-200">
                                    <tr>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Barang</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Dipinjam Oleh</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Tanggal Kembali</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($peminjamanAktifLain as $pinjam)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-4 py-3 text-gray-800 font-medium">{{ $pinjam->barang->nama }}</td>
                                        <td class="px-4 py-3 text-gray-600">{{ $pinjam->user->name }}</td>
                                        <td class="px-4 py-3 text-gray-600">{{ \Carbon\Carbon::parse($pinjam->tanggal_kembali)->format('d/m/Y') }}</td>
                                        <td class="px-4 py-3">
                                            <span class="px-2 py-1 rounded-full text-xs font-semibold @if($pinjam->status === 'disetujui') bg-green-100 text-green-800 @else bg-amber-100 text-amber-800 @endif">
                                                {{ $pinjam->status }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-lg">
                            <i class="fas fa-info-circle me-2"></i>
                            <small>Perhatikan jadwal peminjaman mahasiswa lain untuk menghindari konflik.</small>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-check-circle text-5xl text-green-500 mb-3"></i>
                            <p class="text-gray-600">Tidak ada peminjaman aktif untuk barang yang dipilih.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="lg:col-span-1">
            <!-- Form Pengajuan -->
            <form action="{{ route('mahasiswa.peminjaman.submit') }}" method="POST" class="bg-white rounded-xl shadow-sm p-6 overflow-hidden">
                @csrf

                <h3 class="text-lg font-bold text-gray-800 mb-6">Rincian Peminjaman</h3>

                <!-- Tanggal Pinjam -->
                <div class="mb-6">
                    <label for="tanggal_pinjam" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-calendar-alt me-1"></i>Tanggal Pinjam <span class="text-red-500">*</span>
                    </label>
                    <input type="date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tanggal_pinjam') border-red-500 @enderror"
                           id="tanggal_pinjam" name="tanggal_pinjam"
                           value="{{ old('tanggal_pinjam') }}" required
                           min="{{ date('Y-m-d') }}">
                    @error('tanggal_pinjam')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-gray-500 text-xs mt-1">Mulai peminjaman</p>
                </div>

                <!-- Tanggal Kembali -->
                <div class="mb-6">
                    <label for="tanggal_kembali" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-calendar-check me-1"></i>Tanggal Kembali <span class="text-red-500">*</span>
                    </label>
                    <input type="date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tanggal_kembali') border-red-500 @enderror"
                           id="tanggal_kembali" name="tanggal_kembali"
                           value="{{ old('tanggal_kembali') }}" required>
                    @error('tanggal_kembali')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-gray-500 text-xs mt-1">Pengembalian barang</p>
                </div>

                <!-- Alasan Peminjaman -->
                <div class="mb-6">
                    <label for="alasan" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-file-alt me-1"></i>Alasan Peminjaman <span class="text-red-500">*</span>
                    </label>
                    <textarea class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('alasan') border-red-500 @enderror"
                              id="alasan" name="alasan" rows="3"
                              placeholder="Jelaskan alasan peminjaman..."
                              required minlength="10" maxlength="500">{{ old('alasan') }}</textarea>
                    @error('alasan')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <div class="flex justify-between mt-1">
                        <p class="text-gray-500 text-xs">Min 10, Max 500 karakter</p>
                        <p class="text-gray-500 text-xs"><span id="charCount">0</span>/500</p>
                    </div>
                </div>

                <!-- Summary Card -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <h4 class="font-semibold text-gray-800 mb-3 flex items-center gap-2">
                        <i class="fas fa-clipboard-list text-blue-600"></i>Ringkasan
                    </h4>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Jumlah Barang:</span>
                            <span class="font-bold text-gray-800">{{ count($cartItems) }} barang</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Item:</span>
                            <span class="font-bold text-gray-800">{{ array_sum(array_column($cartItems, 'quantity')) }} item</span>
                        </div>
                        <div class="border-t border-blue-200 pt-2 mt-2">
                            <p class="text-gray-600 mb-1">Periode:</p>
                            <p class="font-bold text-blue-600" id="periodeText">-</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col gap-3">
                    <button type="submit" class="w-full px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium flex items-center justify-center gap-2">
                        <i class="fas fa-paper-plane"></i>
                        Ajukan Peminjaman
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Character counter for alasan textarea
    document.getElementById('alasan').addEventListener('input', function() {
        document.getElementById('charCount').textContent = this.value.length;
    });

    // Set min date for tanggal_kembali based on tanggal_pinjam
    document.getElementById('tanggal_pinjam').addEventListener('change', function() {
        const pinjamDate = this.value;
        const kembaliInput = document.getElementById('tanggal_kembali');

        if (pinjamDate) {
            kembaliInput.min = pinjamDate;

            if (!kembaliInput.value) {
                const pinjam = new Date(pinjamDate);
                pinjam.setDate(pinjam.getDate() + 7);
                const kembalDate = pinjam.toISOString().split('T')[0];
                kembaliInput.value = kembalDate;
            }

            updatePeriodeText();
        }
    });

    document.getElementById('tanggal_kembali').addEventListener('change', updatePeriodeText);

    function updatePeriodeText() {
        const pinjam = document.getElementById('tanggal_pinjam').value;
        const kembali = document.getElementById('tanggal_kembali').value;

        if (pinjam && kembali) {
            const start = new Date(pinjam);
            const end = new Date(kembali);
            const diffTime = Math.abs(end - start);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            const options = { day: 'numeric', month: 'long', year: 'numeric' };
            const startFormatted = start.toLocaleDateString('id-ID', options);
            const endFormatted = end.toLocaleDateString('id-ID', options);

            document.getElementById('periodeText').textContent =
                `${startFormatted} - ${endFormatted} (${diffDays} hari)`;
        } else {
            document.getElementById('periodeText').textContent = '-';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        updatePeriodeText();
        document.getElementById('charCount').textContent =
            document.getElementById('alasan').value.length;
    });
</script>
@endsection
