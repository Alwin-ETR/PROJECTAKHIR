{{-- <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - Sistem Peminjaman Inventaris Fasilkom</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-slide-up {
            animation: slideUp 0.6s ease-out;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-600 via-blue-700 to-blue-800 min-h-screen flex items-center justify-center p-4">
    <!-- Background decoration -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-cyan-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
    </div>

    <!-- Main Container -->
    <div class="w-full max-w-4xl relative z-10">
        <div class="flex rounded-3xl shadow-2xl overflow-hidden animate-slide-up">
            <!-- Left Side - Welcome Section -->
            <div class="hidden md:flex w-1/2 bg-gradient-to-br from-blue-600 to-blue-700 p-10 flex-col justify-between relative">
                <!-- Decorative shapes -->
                <div class="absolute top-0 right-0 w-40 h-40 bg-blue-500 rounded-full opacity-10 blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-40 h-40 bg-cyan-400 rounded-full opacity-10 blur-3xl"></div>

                <div class="relative z-10">
                    <!-- Logo -->
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                            <i class="fas fa-box text-blue-600 text-lg"></i>
                        </div>
                        <span class="text-white font-bold text-base">SIPINJAM</span>
                    </div>

                    <!-- Welcome Text -->
                    <div>
                        <h2 class="text-3xl font-bold text-white mb-3">Bergabunglah Dengan Kami!</h2>
                        <p class="text-blue-100 text-sm leading-relaxed">
                            Daftar sekarang untuk mendapatkan akses penuh ke sistem peminjaman inventaris
                        </p>
                    </div>
                </div>

                <!-- Footer -->
                <p class="text-blue-100 text-xs text-center">
                    &copy; 2025 SIPINJAM - Fakultas Ilmu Komputer Universitas Jember
                </p>
            </div>

            <!-- Right Side - Register Form -->
            <div class="w-full md:w-1/2 bg-white p-10 overflow-y-auto max-h-[90vh]">
                <div class="mb-6">
                    <h3 class="text-3xl font-bold text-gray-800">Daftar</h3>
                    <p class="text-gray-600 text-sm mt-1">Buat akun baru Anda</p>
                </div>

                <form method="POST" action="{{ route('register') }}" id="registerForm">
                    @csrf

                    @if($errors->any())
                        <div class="mb-4 p-3 bg-red-50 border border-red-300 rounded-lg text-red-800 text-sm">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <strong>Registrasi gagal!</strong> Periksa data.
                        </div>
                    @endif

                    <!-- Nama -->
                    <div class="mb-3">
                        <label for="register_name" class="block text-gray-700 font-semibold text-sm mb-1">Nama Lengkap</label>
                        <div class="flex border border-gray-300 rounded-lg overflow-hidden">
                            <span class="inline-flex items-center px-3 bg-gray-900 text-white">
                                <i class="fas fa-user text-xs"></i>
                            </span>
                            <input type="text" id="register_name" name="name" value="{{ old('name') }}" required
                                   class="flex-1 px-3 py-2 bg-gray-100 text-gray-800 placeholder-gray-500 text-sm focus:outline-none"
                                   placeholder="Nama lengkap">
                        </div>
                        @error('name')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- NIM -->
                    <div class="mb-3">
                        <label for="register_nim" class="block text-gray-700 font-semibold text-sm mb-1">NIM</label>
                        <div class="flex border border-gray-300 rounded-lg overflow-hidden">
                            <span class="inline-flex items-center px-3 bg-gray-900 text-white">
                                <i class="fas fa-id-card text-xs"></i>
                            </span>
                            <input type="text" id="register_nim" name="nim" value="{{ old('nim') }}" required maxlength="12"
                                   class="flex-1 px-3 py-2 bg-gray-100 text-gray-800 placeholder-gray-500 text-sm focus:outline-none"
                                   placeholder="12 digit NIM">
                        </div>
                        <p class="text-gray-500 text-xs mt-1">Hanya angka</p>
                        @error('nim')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="register_email" class="block text-gray-700 font-semibold text-sm mb-1">Email</label>
                        <div class="flex border border-gray-300 rounded-lg overflow-hidden">
                            <span class="inline-flex items-center px-3 bg-gray-900 text-white">
                                <i class="fas fa-envelope text-xs"></i>
                            </span>
                            <input type="email" id="register_email" name="email" value="{{ old('email') }}" required
                                   class="flex-1 px-3 py-2 bg-gray-100 text-gray-800 placeholder-gray-500 text-sm focus:outline-none"
                                   placeholder="email@student.unej.ac.id">
                        </div>
                        @error('email')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="mb-3">
                        <label for="register_phone" class="block text-gray-700 font-semibold text-sm mb-1">Nomor HP</label>
                        <div class="flex border border-gray-300 rounded-lg overflow-hidden">
                            <span class="inline-flex items-center px-3 bg-gray-900 text-white">
                                <i class="fas fa-phone text-xs"></i>
                            </span>
                            <input type="tel" id="register_phone" name="phone" value="{{ old('phone') }}" required minlength="10" maxlength="15"
                                   class="flex-1 px-3 py-2 bg-gray-100 text-gray-800 placeholder-gray-500 text-sm focus:outline-none"
                                   placeholder="08xxxxxxxxxx">
                        </div>
                        @error('phone')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="register_password" class="block text-gray-700 font-semibold text-sm mb-1">Password</label>
                        <div class="flex border border-gray-300 rounded-lg overflow-hidden">
                            <span class="inline-flex items-center px-3 bg-gray-900 text-white">
                                <i class="fas fa-lock text-xs"></i>
                            </span>
                            <input type="password" id="register_password" name="password" required minlength="6"
                                   class="flex-1 px-3 py-2 bg-gray-100 text-gray-800 placeholder-gray-500 text-sm focus:outline-none"
                                   placeholder="Min 6 karakter">
                            <button type="button" onclick="togglePassword('register_password')"
                                    class="inline-flex items-center px-3 bg-gray-100 text-gray-600 hover:text-blue-600 text-sm">
                                <i class="fas fa-eye text-xs"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="mb-5">
                        <label for="register_password_confirmation" class="block text-gray-700 font-semibold text-sm mb-1">Konfirmasi Password</label>
                        <div class="flex border border-gray-300 rounded-lg overflow-hidden">
                            <span class="inline-flex items-center px-3 bg-gray-900 text-white">
                                <i class="fas fa-lock text-xs"></i>
                            </span>
                            <input type="password" id="register_password_confirmation" name="password_confirmation" required minlength="6"
                                   class="flex-1 px-3 py-2 bg-gray-100 text-gray-800 placeholder-gray-500 text-sm focus:outline-none"
                                   placeholder="Ulangi password">
                            <button type="button" onclick="togglePassword('register_password_confirmation')"
                                    class="inline-flex items-center px-3 bg-gray-100 text-gray-600 hover:text-blue-600 text-sm">
                                <i class="fas fa-eye text-xs"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Info Alert -->
                    <div class="mb-4 p-3 bg-blue-50 border border-blue-300 rounded-lg text-blue-800 text-xs">
                        <i class="fas fa-info-circle mr-2"></i>
                        NIM harus 12 digit angka
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold py-2 rounded-full text-sm hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200">
                        Daftar
                    </button>
                </form>

                <hr class="my-4 border-gray-300">

                <!-- Login Link -->
                <p class="text-center text-gray-600 text-sm">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 font-bold">
                        Login
                    </a>
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const button = input.parentNode.querySelector('button');
            const icon = button.querySelector('i');

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

        document.getElementById('register_nim')?.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        document.getElementById('register_phone')?.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        document.getElementById('registerForm')?.addEventListener('submit', function(e) {
            const password = document.getElementById('register_password').value;
            const confirmPassword = document.getElementById('register_password_confirmation').value;

            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Password tidak cocok!');
                return false;
            }
        });

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
    </script>
</body>
</html> --}}
