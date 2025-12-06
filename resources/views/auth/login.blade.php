<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - SIPINJAM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="min-h-screen bg-gray-50 flex items-center justify-center px-4 py-8 relative overflow-hidden">

    <!-- Decorative Background Shapes -->
    <div class="pointer-events-none absolute inset-0">
        <!-- Top Left Teal Shape -->
        <div class="absolute -top-40 -left-32 w-80 h-80 bg-teal-400/20 rounded-full blur-3xl"></div>
        
        <!-- Bottom Right Yellow Shape -->
        <div class="absolute -bottom-40 -left-20 w-72 h-72 bg-yellow-300/20 rounded-full blur-3xl"></div>
        
        <!-- Top Right Red/Pink Shape -->
        <div class="absolute -top-32 -right-32 w-96 h-96 bg-red-400/15 rounded-full blur-3xl"></div>
    </div>

    <!-- Main Container -->
    <div class="w-full max-w-5xl bg-white rounded-3xl shadow-2xl overflow-hidden relative z-10">
        <div class="flex flex-col lg:flex-row">
            
            <!-- Left Panel - Welcome Section -->
            <div class="lg:w-5/12 bg-gradient-to-br from-blue-500 via-blue-600 to-blue-700 text-white p-8 lg:p-12 flex flex-col items-center justify-center text-center relative overflow-hidden">
                
                <!-- Decorative Circle -->
                <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full -mr-20 -mt-20"></div>
                <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/5 rounded-full -ml-16 -mb-16"></div>
                
                <div class="relative z-10">
                    <!-- Logo -->
                    <div class="flex justify-center items-center mb-12">
                        <div class="p-2 bg-white rounded-3xl shadow-lg">
                            <img src="{{ asset('storage/images/sipinjam (2).png') }}"
                                alt="SIPINJAM"
                                class="h-48 w-48 object-contain">
                        </div>
                    </div>

                    <!-- Welcome Message -->
                    <h2 class="text-3xl lg:text-4xl font-bold mb-4">Welcome Back!</h2>
                    <p class="text-teal-100 text-base leading-relaxed mb-8">
                        Sistem Peminjaman Inventaris<br>
                        Fakultas Ilmu Komputer<br>
                        Universitas Jember
                    </p>                      
                </div>
            </div>

            <!-- Right Panel - Login Form -->
            <div class="lg:w-7/12 p-8 lg:p-12 flex flex-col justify-center">
                
                <div class="max-w-md mx-auto w-full" id="login-form">
                    <!-- Form Title -->
                    <h3 class="text-3xl font-bold text-gray-800 mb-2">Login Akun</h3>
                    <p class="text-gray-500 text-sm mb-8">Masukkan informasi pribadi Anda untuk mengakses sistem</p>

                    <!-- Error Messages -->
                    @if($errors->any() && $errors->has('email') && !$errors->has('name'))
                        <div class="flex items-center gap-3 p-4 rounded-lg bg-yellow-50 border border-yellow-200 text-yellow-800 text-sm mb-4">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ $errors->first('email') }}</span>
                        </div>
                    @endif

                    @if($errors->any() && $errors->has('password'))
                        <div class="flex items-center gap-3 p-4 rounded-lg bg-red-50 border border-red-200 text-red-800 text-sm mb-4">
                            <i class="fas fa-lock"></i>
                            <span>{{ $errors->first('password') }}</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                        @csrf

                        <!-- Email Input -->
                        <div>
                            <label for="login_email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                            <div class="relative">
                                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <input
                                    type="email"
                                    id="login_email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    class="w-full pl-12 pr-4 py-3 bg-gray-100 border-2 border-gray-200 rounded-lg text-gray-800 placeholder-gray-400 focus:outline-none focus:bg-white focus:border-blue-500 transition"
                                    placeholder="email@example.com">
                            </div>
                            @error('email')
                                <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password Input -->
                        <div>
                            <label for="login_password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                            <div class="relative">
                                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <input
                                    type="password"
                                    id="login_password"
                                    name="password"
                                    required
                                    class="w-full pl-12 pr-12 py-3 bg-gray-100 border-2 border-gray-200 rounded-lg text-gray-800 placeholder-gray-400 focus:outline-none focus:bg-white focus:border-blue-500 transition"
                                    placeholder="Masukkan password">
                                <button
                                    type="button"
                                    onclick="togglePassword('login_password')"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-blue-600 transition">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Forgot Password Link -->
                        <div class="text-right">
                            <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-700 font-semibold hover:underline">
                                Lupa Password?
                            </a>
                        </div>

                        <!-- Submit Button -->
                        <button
                            type="submit"
                            class="w-full py-3 px-4 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-lg hover:shadow-lg hover:from-blue-600 hover:to-blue-700 transition transform hover:-translate-y-0.5">
                            <i class="fas fa-sign-in-alt mr-2"></i>Login ke Sistem
                        </button>
                    </form>

                    <!-- Divider -->
                    <div class="my-6 flex items-center gap-4">
                        <div class="flex-1 h-px bg-gray-200"></div>
                        <span class="text-gray-400 text-sm">atau</span>
                        <div class="flex-1 h-px bg-gray-200"></div>
                    </div>

                    <!-- Sign Up Link -->
                    <p class="text-center text-gray-600 text-sm">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:text-blue-700 hover:underline">
                            Daftar di sini
                        </a>
                    </p>
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