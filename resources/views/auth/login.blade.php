<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Sistem Peminjaman Inventaris Fasilkom</title>
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
            {{-- KIRI: logo & teks, center --}}
            <div class="md:w-5/12 bg-gray-900 text-white p-6 md:p-7 flex flex-col items-center justify-center text-center">
                <div>
                    <div class="flex justify-center items-center gap-4 mb-6">
                        <img src="{{ asset('storage/images/unej.png') }}" alt="UNEJ" class="h-9" onerror="this.style.display='none'">
                        <img src="{{ asset('storage/images/fasilkom.png') }}" alt="Fasilkom" class="h-8 invert" onerror="this.style.display='none'">
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

            {{-- KANAN: form login --}}
            <div class="md:w-7/12 p-6 md:p-7">
                <h5 class="text-center text-lg font-semibold mb-5">
                    Login Akun
                </h5>

                <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
                    @csrf

                    @if($errors->any() && $errors->has('email') && !$errors->has('name'))
                        <div class="flex items-start gap-2 p-3 rounded-lg bg-yellow-50 text-yellow-800 text-sm">
                            <i class="fas fa-exclamation-circle mt-0.5"></i>
                            <span>{{ $errors->first('email') }}</span>
                        </div>
                    @endif

                    @if($errors->any() && $errors->has('password'))
                        <div class="flex items-start gap-2 p-3 rounded-lg bg-red-50 text-red-800 text-sm">
                            <i class="fas fa-lock mt-0.5"></i>
                            <span>{{ $errors->first('password') }}</span>
                        </div>
                    @endif

                    <!-- Email -->
                    <div>
                        <label for="login_email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <div class="flex rounded-lg border border-gray-300 overflow-hidden">
                            <span class="inline-flex items-center px-3 bg-gray-900 text-white">
                                <i class="fas fa-envelope text-sm"></i>
                            </span>
                            <input
                                type="email"
                                id="login_email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                class="flex-1 px-3 py-2 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="email@example.com">
                        </div>
                        @error('email')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="login_password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <div class="flex rounded-lg border border-gray-300 overflow-hidden">
                            <span class="inline-flex items-center px-3 bg-gray-900 text-white">
                                <i class="fas fa-lock text-sm"></i>
                            </span>
                            <input
                                type="password"
                                id="login_password"
                                name="password"
                                required
                                class="flex-1 px-3 py-2 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Masukkan password">
                            {{-- SATU tombol mata saja --}}
                            <button
                                type="button"
                                onclick="togglePassword('login_password')"
                                class="inline-flex items-center px-3 bg-white text-gray-500 hover:text-blue-600 text-sm">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Lupa Password -->
                    <div class="text-right">
                        <a href="{{ route('password.request') }}" class="text-xs text-blue-600 hover:text-blue-700 font-medium">
                            <i class="fas fa-question-circle mr-1"></i>Lupa Password?
                        </a>
                    </div>

                    <!-- Submit -->
                    <button
                        type="submit"
                        class="w-full py-2.5 rounded-full text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:shadow-lg hover:-translate-y-0.5 transition transform">
                        <i class="fas fa-sign-in-alt mr-2"></i>Login ke Sistem
                    </button>
                </form>

                <hr class="my-5 border-gray-200">

                <p class="text-center text-sm text-gray-600">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:text-blue-700">
                        Daftar di sini
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

        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Login Berhasil!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        @endif

        @if(session('status'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
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
