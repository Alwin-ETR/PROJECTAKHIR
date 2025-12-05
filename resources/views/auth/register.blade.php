<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - Sistem Peminjaman Inventaris Fasilkom</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-600 via-blue-700 to-blue-800 flex items-center justify-center px-4 py-8 relative overflow-hidden">

    {{-- Dekorasi background blur --}}
    <div class="pointer-events-none absolute inset-0">
        <div class="absolute -top-32 -left-24 w-56 h-56 bg-blue-400/40 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-36 -right-16 w-64 h-64 bg-indigo-500/40 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 -right-24 w-52 h-52 bg-cyan-400/30 rounded-full blur-3xl"></div>
    </div>

    <div class="w-full max-w-3xl bg-white rounded-2xl shadow-2xl overflow-hidden relative z-10">
        <div class="flex flex-col md:flex-row">
    
            <div class="md:w-5/12 bg-gray-900 text-white p-6 md:p-7 flex flex-col items-center justify-center text-center">
                <div>

                    <div class="flex justify-center items-center gap-4 mb-6">

                        <!-- Logo UNEJ -->
                        <div class="p-2 bg-white rounded-xl shadow-md border border-gray-200">
                            <img src="{{ asset('storage/images/unej.png') }}"
                                alt="UNEJ"
                                class="h-10 object-contain">
                        </div>

                        <!-- Logo Fasilkom -->
                        <div class="p-2 rounded-xl shadow-md border border-blue-300 bg-gradient-to-br from-blue-400 to-blue-600">
                            <img src="{{ asset('storage/images/fasilkom.png') }}"
                                alt="Fasilkom"
                                class="h-9 object-contain">
                        </div>

                        <!-- Logo SIPINJAM -->
                        <div class="p-2 bg-white rounded-xl shadow-md border border-gray-200">
                            <img src="{{ asset('storage/images/logo-sipinjam.png') }}"
                                alt="Sipinjam"
                                class="h-10 object-contain">
                        </div>

                    </div>

                    <h4 class="text-xl font-semibold mb-2">SIPINJAM</h4>
                    <p class="text-sm text-gray-200 leading-relaxed">
                        Sistem Peminjaman Inventaris<br>
                        Fakultas Ilmu Komputer<br>
                        Universitas Jember
                    </p>
                </div>
            </div>

            <div class="md:w-7/12 p-6 md:p-7">
                <h5 class="text-center text-lg font-semibold mb-5">
                    Daftar Akun Baru
                </h5>

                <form method="POST" action="{{ route('register') }}" id="registerForm" class="space-y-4">
                    @csrf

                    @if($errors->any() && ($errors->has('name') || $errors->has('nim') || $errors->has('phone') || $errors->has('email')))
                        <div class="flex items-start gap-2 p-3 rounded-lg bg-red-50 text-red-800 text-sm mb-2">
                            <i class="fas fa-exclamation-triangle mt-0.5"></i>
                            <span><strong>Registrasi gagal!</strong> Periksa data yang Anda masukkan.</span>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="register_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <div class="flex rounded-lg border border-gray-300 overflow-hidden">
                                <span class="inline-flex items-center px-3 bg-gray-900 text-white">
                                    <i class="fas fa-user text-sm"></i>
                                </span>
                                <input
                                    type="text"
                                    id="register_name"
                                    name="name"
                                    value="{{ old('name') }}"
                                    required
                                    placeholder="Nama lengkap"
                                    class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror">
                                @error('name')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="register_nim" class="block text-sm font-medium text-gray-700 mb-1">NIM</label>
                            <div class="flex rounded-lg border border-gray-300 overflow-hidden">
                                <span class="inline-flex items-center px-3 bg-gray-900 text-white">
                                    <i class="fas fa-id-card text-sm"></i>
                                </span>
                                <input
                                    type="text"
                                    id="register_nim"
                                    name="nim"
                                    value="{{ old('nim') }}"
                                    required
                                    maxlength="12"
                                    placeholder="12 digit NIM"
                                    class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nim') border-red-500 @enderror">
                                @error('nim')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="register_email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <div class="flex rounded-lg border border-gray-300 overflow-hidden">
                            <span class="inline-flex items-center px-3 bg-gray-900 text-white">
                                <i class="fas fa-envelope text-sm"></i>
                            </span>
                            <input
                                type="email"
                                id="register_email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                placeholder="email@student.unej.ac.id"
                                class="flex-1 px-3 py-2 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        @error('email')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="register_phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor HP</label>
                            <div class="flex rounded-lg border border-gray-300 overflow-hidden">
                                <span class="inline-flex items-center px-3 bg-gray-900 text-white">
                                    <i class="fas fa-phone text-sm"></i>
                                </span>
                                <input
                                    type="tel"
                                    id="register_phone"
                                    name="phone"
                                    value="{{ old('phone') }}"
                                    required
                                    placeholder="08xxxxxxxxxx"
                                    class="flex-1 px-3 py-2 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            @error('phone')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="register_password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <div class="flex rounded-lg border border-gray-300 overflow-hidden">
                                <span class="inline-flex items-center px-3 bg-gray-900 text-white">
                                    <i class="fas fa-lock text-sm"></i>
                                </span>
                                <input
                                    type="password"
                                    id="register_password"
                                    name="password"
                                    required
                                    placeholder="Minimal 6 karakter"
                                    class="flex-1 px-3 py-2 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <button
                                    type="button"
                                    onclick="togglePassword('register_password')"
                                    class="inline-flex items-center px-3 bg-white text-gray-500 hover:text-blue-600 text-sm">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="register_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                        <div class="flex rounded-lg border border-gray-300 overflow-hidden">
                            <span class="inline-flex items-center px-3 bg-gray-900 text-white">
                                <i class="fas fa-lock text-sm"></i>
                            </span>
                            <input
                                type="password"
                                id="register_password_confirmation"
                                name="password_confirmation"
                                required
                                placeholder="Ulangi password"
                                class="flex-1 px-3 py-2 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <button
                                type="button"
                                onclick="togglePassword('register_password_confirmation')"
                                class="inline-flex items-center px-3 bg-white text-gray-500 hover:text-blue-600 text-sm">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-start gap-2 p-3 rounded-lg bg-blue-50 text-blue-800 text-xs">
                        <i class="fas fa-info-circle mt-0.5"></i>
                        <span>Pastikan NIM terdiri dari 12 digit angka dan data yang dimasukkan valid.</span>
                    </div>

                    <button
                        type="submit"
                        class="w-full py-2.5 rounded-full text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:shadow-lg hover:-translate-y-0.5 transition transform">
                        <i class="fas fa-user-plus mr-2"></i> Daftar Akun Mahasiswa
                    </button>
                </form>

                <p class="mt-4 text-center text-sm text-gray-600">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:text-blue-700">
                        Login di sini
                    </a>
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const btn = input.parentNode.querySelector('button');
            const icon = btn.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        document.getElementById('register_nim')?.addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length > 12) this.value = this.value.slice(0, 12);
        });

        document.getElementById('register_phone')?.addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        document.getElementById('registerForm')?.addEventListener('submit', function () {
            const btn = this.querySelector('button[type="submit"]');
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mendaftarkan...';
            btn.disabled = true;
        });

        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Registrasi Berhasil!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        @endif
    </script>
</body>
</html>
