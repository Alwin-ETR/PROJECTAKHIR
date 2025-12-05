<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - SIPINJAM</title>
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
            {{-- KIRI: logo & teks center --}}
            <div class="md:w-5/12 bg-gray-900 text-white p-6 md:p-7 flex flex-col items-center justify-center text-center">
                <div>
                    <div class="flex justify-center items-center gap-4 mb-6">

                        <!-- Logo UNEJ -->
                        <div class="p-2 bg-white rounded-xl shadow-md border border-gray-200">
                            <img src="{{ asset('storage/images/unej.png') }}"
                                alt="UNEJ"
                                class="h-10 object-contain">
                        </div>

                        <!-- Logo Fasilkom (Wrapper Biru Gradient) -->
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

                {{-- <p class="mt-8 text-[11px] text-gray-400">
                    &copy; 2025 Sistem Peminjaman Inventaris Fasilkom UNEJ.
                </p> --}}
            </div>

            {{-- KANAN: form reset password --}}
            <div class="md:w-7/12 p-6 md:p-7">
                <h2 class="text-lg font-semibold text-gray-800 mb-1 text-center md:text-left">
                    Reset Password
                </h2>
                <p class="text-sm text-gray-600 mb-5 text-center md:text-left">
                    Masukkan password baru Anda.
                </p>

                <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                    @csrf

                    {{-- Hidden fields: token dan email --}}
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ $email }}">

                    @if ($errors->any())
                        <div class="flex items-start gap-2 p-3 rounded-lg bg-red-50 text-red-800 text-sm mb-2">
                            <i class="fas fa-exclamation-triangle mt-0.5"></i>
                            <span><strong>Reset gagal!</strong> {{ $errors->first() }}</span>
                        </div>
                    @endif

                    <!-- Email (tampilan saja, tidak bisa edit) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input
                            type="email"
                            value="{{ $email }}"
                            disabled
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-600 bg-gray-100 cursor-not-allowed">
                    </div>

                    <!-- Password Baru -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                        <div class="flex rounded-lg border border-gray-300 overflow-hidden">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                required
                                placeholder="Minimal 8 karakter"
                                class="flex-1 px-4 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <button
                                type="button"
                                onclick="togglePassword('password')"
                                class="inline-flex items-center px-3 bg-white text-gray-500 hover:text-blue-600 text-sm">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                        <div class="flex rounded-lg border border-gray-300 overflow-hidden">
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                required
                                placeholder="Ulangi password baru"
                                class="flex-1 px-4 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <button
                                type="button"
                                onclick="togglePassword('password_confirmation')"
                                class="inline-flex items-center px-3 bg-white text-gray-500 hover:text-blue-600 text-sm">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button
                        type="submit"
                        class="w-full py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white text-sm font-semibold rounded-full hover:shadow-lg hover:-translate-y-0.5 transition transform">
                        Reset Password
                    </button>
                </form>

                <div class="text-center mt-6">
                    <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                        ← Kembali ke halaman login
                    </a>
                </div>
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

        @if(session('status'))
            Swal.fire({
                icon: 'success',
                title: 'Password Berhasil Direset!',
                text: '{{ session('status') }}',
                timer: 3000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        @endif
    </script>
</body>
</html>
