@extends('layouts.mahasiswa')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Title Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Profil Mahasiswa</h1>
        <p class="text-gray-500">Kelola informasi akun Anda</p>
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
        <!-- Informasi Pribadi -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="bg-blue-600 text-white px-6 py-4">
                    <h2 class="text-lg font-bold flex items-center gap-2">
                        <i class="fas fa-user"></i>
                        Informasi Pribadi
                    </h2>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Nama -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                <div class="bg-gray-50 px-4 py-2 rounded-lg border border-gray-200 text-gray-800">
                                    {{ $user->name }}
                                </div>
                            </div>

                            <!-- NIM -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">NIM</label>
                                <div class="bg-gray-50 px-4 py-2 rounded-lg border border-gray-200 text-gray-800">
                                    {{ $user->nim ?? 'Belum diisi' }}
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <div class="bg-gray-50 px-4 py-2 rounded-lg border border-gray-200 text-gray-800 break-all">
                                    {{ $user->email }}
                                </div>
                            </div>

                            <!-- Nomor HP -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor HP</label>
                                <div class="bg-gray-50 px-4 py-2 rounded-lg border border-gray-200 text-gray-800">
                                    {{ $user->phone ?? 'Belum diisi' }}
                                </div>
                            </div>
                        </div>

                        <!-- Role -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Role / Status</label>
                            <div class="flex items-center gap-2">
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-semibold rounded-full capitalize">
                                    {{ $user->role }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik Peminjaman -->
        <div class="lg:col-span-1">
            <!-- Card Statistik 1 -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-xl shadow-lg p-6 mb-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm mb-1">Total Peminjaman</p>
                        <h3 class="text-3xl font-bold">{{ $totalPeminjaman }}</h3>
                    </div>
                    <i class="fas fa-box-open text-4xl opacity-20"></i>
                </div>
            </div>

            <!-- Card Statistik 2 -->
            <div class="bg-gradient-to-br from-amber-500 to-amber-600 text-white rounded-xl shadow-lg p-6 mb-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-amber-100 text-sm mb-1">Sedang Dipinjam</p>
                        <h3 class="text-3xl font-bold">{{ $peminjamanAktif }}</h3>
                    </div>
                    <i class="fas fa-shopping-cart text-4xl opacity-20"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Riwayat Peminjaman Terbaru -->
    <div class="mt-8 bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="bg-gray-700 text-white px-6 py-4">
            <h2 class="text-lg font-bold flex items-center gap-2">
                <i class="fas fa-history"></i>
                Peminjaman Terbaru
            </h2>
        </div>
        <div class="p-6">
            @php
                $peminjamanTerbaru = \App\Models\Peminjaman::with('barang')
                    ->where('user_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get();
            @endphp

            @if($peminjamanTerbaru->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-100 border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">Barang</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">Tanggal Pinjam</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">Tanggal Kembali</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-700">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($peminjamanTerbaru as $pinjam)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 text-gray-800 font-medium">{{ $pinjam->barang->nama ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('d/m/Y') }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ \Carbon\Carbon::parse($pinjam->tanggal_kembali)->format('d/m/Y') }}</td>
                                <td class="px-4 py-3">
                                    @php
                                        $statusClasses = [
                                            'pending' => 'bg-amber-100 text-amber-800',
                                            'disetujui' => 'bg-green-100 text-green-800',
                                            'ditolak' => 'bg-red-100 text-red-800',
                                            'dikembalikan' => 'bg-blue-100 text-blue-800'
                                        ];
                                        $statusClass = $statusClasses[$pinjam->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusClass }} capitalize">
                                        {{ $pinjam->status }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 text-center">
                    <a href="{{ route('mahasiswa.riwayat') }}" class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                        Lihat Semua Riwayat
                    </a>
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-inbox text-5xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Belum ada riwayat peminjaman</h3>
                </div>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        timer: 3000,
        showConfirmButton: false,
        position: 'top-end'
    });
</script>
@endif
@endsection
