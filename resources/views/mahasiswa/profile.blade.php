@extends('layouts.mahasiswa')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Title Section -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Profil Mahasiswa</h1>
            <p class="text-gray-500">Kelola informasi akun Anda</p>
        </div>
        <button id="btnEdit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium inline-flex items-center gap-2">
            <i class="fas fa-edit"></i>
            Edit Profil
        </button>
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
                    <!-- View Mode -->
                    <div id="viewMode" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                <div class="bg-gray-50 px-4 py-2 rounded-lg border border-gray-200 text-gray-800">
                                    {{ $user->name }}
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">NIM</label>
                                <div class="bg-gray-50 px-4 py-2 rounded-lg border border-gray-200 text-gray-800">
                                    {{ $user->nim ?? 'Belum diisi' }}
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <div class="bg-gray-50 px-4 py-2 rounded-lg border border-gray-200 text-gray-800 break-all">
                                    {{ $user->email }}
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor HP</label>
                                <div class="bg-gray-50 px-4 py-2 rounded-lg border border-gray-200 text-gray-800">
                                    {{ $user->phone ?? 'Belum diisi' }}
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Role / Status</label>
                            <div class="flex items-center gap-2">
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-semibold rounded-full capitalize">
                                    {{ $user->role }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Mode -->
                    <div id="editMode" class="hidden">
                        <div class="space-y-6">
                            <!-- Tabs -->
                            <div class="flex gap-2 border-b border-gray-200">
                                <button type="button" class="tab-btn active px-4 py-2 border-b-2 border-blue-600 text-blue-600 font-medium" data-tab="data-pribadi">
                                    Data Pribadi
                                </button>
                                <button type="button" class="tab-btn px-4 py-2 border-b-2 border-transparent text-gray-600 font-medium hover:text-gray-800" data-tab="password">
                                    Password
                                </button>
                            </div>

                            <!-- Tab: Data Pribadi -->
                            <div id="data-pribadi" class="tab-content space-y-4">
                                <form id="formEdit" method="POST" action="{{ route('mahasiswa.profile.update') }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                            <input type="text" value="{{ $user->name }}" 
                                                   class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-gray-100 text-gray-600 cursor-not-allowed" disabled>
                                            <p class="text-xs text-gray-500 mt-1">Tidak dapat diubah</p>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">NIM</label>
                                            <input type="text" value="{{ $user->nim }}" 
                                                   class="w-full px-4 py-2 rounded-lg border border-gray-300 bg-gray-100 text-gray-600 cursor-not-allowed" disabled>
                                            <p class="text-xs text-gray-500 mt-1">Tidak dapat diubah</p>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                            <input type="email" name="email" value="{{ $user->email }}" 
                                                   class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                            @error('email')
                                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor HP</label>
                                            <input type="text" name="phone" value="{{ $user->phone }}" 
                                                   class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="08xxxxxxxxxx">
                                            @error('phone')
                                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="flex gap-2 pt-4">
                                        <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium">
                                            <i class="fas fa-save mr-1"></i>Simpan
                                        </button>
                                        <button type="button" class="btnCancel px-6 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition font-medium">
                                            <i class="fas fa-times mr-1"></i>Batal
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Tab: Password -->
                            <div id="password" class="tab-content hidden space-y-4">
                                <form id="formPassword" method="POST" action="{{ route('mahasiswa.profile.update-password') }}">
                                    @csrf
                                    @method('PUT')

                                    <div id="errorPassword" class="hidden bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4"></div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Password Lama</label>
                                        <div class="relative">
                                            <input type="password" name="current_password" id="oldPassword"
                                                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 pr-10" required>
                                            <button type="button" class="togglePassword absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-target="oldPassword">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        @error('current_password')
                                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                                        <div class="relative">
                                            <input type="password" name="password" id="newPassword"
                                                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 pr-10" required>
                                            <button type="button" class="togglePassword absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-target="newPassword">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        @error('password')
                                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                        @enderror
                                        <p class="text-xs text-gray-500 mt-1">Minimal 8 karakter</p>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                                        <div class="relative">
                                            <input type="password" name="password_confirmation" id="confirmPassword"
                                                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 pr-10" required>
                                            <button type="button" class="togglePassword absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700" data-target="confirmPassword">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="flex gap-2 pt-4">
                                        <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium">
                                            <i class="fas fa-key mr-1"></i>Update Password
                                        </button>
                                        <button type="button" class="btnCancel px-6 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition font-medium">
                                            <i class="fas fa-times mr-1"></i>Batal
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik Peminjaman -->
        <div class="lg:col-span-1">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-xl shadow-lg p-6 mb-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm mb-1">Total Peminjaman</p>
                        <h3 class="text-3xl font-bold">{{ $totalPeminjaman }}</h3>
                    </div>
                    <i class="fas fa-box-open text-4xl opacity-20"></i>
                </div>
            </div>

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
                                            'menunggu_verifikasi' => 'bg-orange-100 text-orange-800',
                                            'dikembalikan' => 'bg-blue-100 text-blue-800'
                                        ];
                                        $statusClass = $statusClasses[$pinjam->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusClass }} capitalize">
                                        {{ $pinjam->status_text }}
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
<script>
// Tab switching
document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const tab = this.getAttribute('data-tab');
        
        // Hide all tabs
        document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
        
        // Remove active state from all buttons
        document.querySelectorAll('.tab-btn').forEach(el => {
            el.classList.remove('border-blue-600', 'text-blue-600');
            el.classList.add('border-transparent', 'text-gray-600');
        });
        
        // Show selected tab
        document.getElementById(tab).classList.remove('hidden');
        
        // Add active state to clicked button
        this.classList.remove('border-transparent', 'text-gray-600');
        this.classList.add('border-blue-600', 'text-blue-600');
    });
});

// Edit/Cancel toggle
document.getElementById('btnEdit').addEventListener('click', function() {
    document.getElementById('viewMode').classList.add('hidden');
    document.getElementById('editMode').classList.remove('hidden');
});

document.querySelectorAll('.btnCancel').forEach(btn => {
    btn.addEventListener('click', function() {
        document.getElementById('editMode').classList.add('hidden');
        document.getElementById('viewMode').classList.remove('hidden');
    });
});

// Toggle password visibility
document.querySelectorAll('.togglePassword').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        const targetId = this.getAttribute('data-target');
        const input = document.getElementById(targetId);
        const icon = this.querySelector('i');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
});

// Validasi form password
document.getElementById('formPassword').addEventListener('submit', function(e) {
    const oldPassword = document.getElementById('oldPassword').value.trim();
    const newPassword = document.getElementById('newPassword').value.trim();
    const confirmPassword = document.getElementById('confirmPassword').value.trim();
    const errorDiv = document.getElementById('errorPassword');
    
    // Clear error
    errorDiv.classList.add('hidden');
    errorDiv.innerHTML = '';
    
    // Validasi 1: Password lama tidak boleh kosong
    if (!oldPassword) {
        e.preventDefault();
        errorDiv.innerHTML = '<i class="fas fa-exclamation-circle mr-2"></i>Password lama harus diisi!';
        errorDiv.classList.remove('hidden');
        return false;
    }
    
    // Validasi 2: Password baru tidak boleh sama dengan password lama
    if (oldPassword === newPassword) {
        e.preventDefault();
        errorDiv.innerHTML = '<i class="fas fa-exclamation-circle mr-2"></i>Password baru tidak boleh sama dengan password lama!';
        errorDiv.classList.remove('hidden');
        return false;
    }
    
    // Validasi 3: Password baru minimal 8 karakter
    if (newPassword.length < 8) {
        e.preventDefault();
        errorDiv.innerHTML = '<i class="fas fa-exclamation-circle mr-2"></i>Password baru minimal 8 karakter!';
        errorDiv.classList.remove('hidden');
        return false;
    }
    
    // Validasi 4: Password baru dan konfirmasi harus sama
    if (newPassword !== confirmPassword) {
        e.preventDefault();
        errorDiv.innerHTML = '<i class="fas fa-exclamation-circle mr-2"></i>Password baru dan konfirmasi tidak cocok!';
        errorDiv.classList.remove('hidden');
        return false;
    }
    
    // Jika semua validasi lolos, form bisa disubmit
});

// Tampilkan error Laravel dari server jika ada
@error('current_password')
Swal.fire({
    icon: 'error',
    title: 'Gagal!',
    text: '{{ $message }}',
    confirmButtonText: 'OK',
    position: 'center' // muncul di tengah
}).then(() => {
    // Pastikan edit mode tetap terbuka
    document.getElementById('viewMode').classList.add('hidden');
    document.getElementById('editMode').classList.remove('hidden');
    // Tampilkan tab password
    document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
    document.getElementById('password').classList.remove('hidden');
    document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('border-blue-600','text-blue-600'));
    document.querySelector('[data-tab="password"]').classList.add('border-blue-600','text-blue-600');
});
@enderror

@error('password')
Swal.fire({
    icon: 'error',
    title: 'Gagal!',
    text: '{{ $message }}',
    confirmButtonText: 'OK',
    position: 'center'
}).then(() => {
    document.getElementById('viewMode').classList.add('hidden');
    document.getElementById('editMode').classList.remove('hidden');
    document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
    document.getElementById('password').classList.remove('hidden');
    document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('border-blue-600','text-blue-600'));
    document.querySelector('[data-tab="password"]').classList.add('border-blue-600','text-blue-600');
});
@enderror

@if(session('success'))
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: '{{ session('success') }}',
    timer: 3000,
    showConfirmButton: false,
    position: 'top-end'
});
@endif

@if(session('error'))
Swal.fire({
    icon: 'error',
    title: 'Gagal!',
    text: '{{ session('error') }}',
    timer: 3000,
    showConfirmButton: false,
    position: 'top-end'
});
@endif
</script>
@endsection
