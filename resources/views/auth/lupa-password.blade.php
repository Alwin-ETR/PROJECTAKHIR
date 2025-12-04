{{-- <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reset Password - Sistem Peminjaman Inventaris Fasilkom</title>
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
                        <span class="text-white font-bold text-base">Inventaris</span>
                    </div>

                    <!-- Welcome Text -->
                    <div>
                        <h2 class="text-3xl font-bold text-white mb-3">Buat Password Baru</h2>
                        <p class="text-blue-100 text-sm leading-relaxed">
                            Masukkan password baru Anda untuk melanjutkan proses reset password
                        </p>
                    </div>
                </div>

                <!-- Footer -->
                <p class="text-blue-100 text-xs text-center">
                    &copy; 2025 Inventaris Fasilkom UNEJ
                </p>
            </div>

            <!-- Right Side - Form -->
            <div class="w-full md:w-1/2 bg-white p-10 overflow-y-auto max-h-[90vh]">
                <div class="mb-6">
                    <h3 class="text-3xl font-bold text-gray-800">Reset Password</h3>
                    <p class="text-gray-600 text-sm mt-1">Buat password baru Anda</p>
                </div>

                @if($errors->any())
                    <div class="mb-4 p-3 bg-red-50 border border-red-300 rounded-lg text-red-800 text-sm">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <strong>Terjadi kesalahan!</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.store') }}" id="resetForm">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 font-semibold text-sm mb-2">Email</label>
                        <div class="flex border border-gray-300 rounded-lg overflow-hidden">
                            <span class="inline-flex items-center px-3 bg-gray-900 text-white">
                                <i class="fas fa-envelope text-xs"></i>
                            </span>
                            <input type="email" id="email" name="email" value="{{ $email ?? '' }}" required readonly
                                   class="flex-1 px-3 py-2 bg-gray-100 text-gray-800 text-sm focus:outline-none">
                        </div>
                    </div>

                    <!-- Password Baru -->
                    <div class="mb-4">
                        <label for="password" class="block text-gray-700 font-semibold text-sm mb-2">Password Baru</label>
                        <div class="flex border border-gray-300 rounded-lg overflow-hidden">
                            <span class="inline-flex items-center px-3 bg-gray-900 text-white">
                                <i class="fas fa-lock text-xs"></i>
                            </span>
                            <input type="password" id="password" name="password" required minlength="6"
                                   class="flex-1 px-3 py-2 bg-gray-100 text-gray-800 placeholder-gray-500 text-sm focus:outline-none"
                                   placeholder="Minimal 6 karakter">
                            <button type="button" onclick="togglePassword('password')"
                                    class="inline-flex items-center px-3 bg-gray-100 text-gray-600 hover:text-blue-600 text-sm">
                                <i class="fas fa-eye text-xs"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="mb-6">
                        <label for="password_confirmation" class="block text-gray-700 font-semibold text-sm mb-2">Konfirmasi Password</label>
                        <div class="flex border border-gray-300 rounded-lg overflow-hidden">
                            <span class="inline-flex items-center px-3 bg-gray-900 text-white">
                                <i class="fas fa-lock text-xs"></i>
                            </span>
                            <input type="password" id="password_confirmation" name="password_confirmation" required minlength="6"
                                   class="flex-1 px-3 py-2 bg-gray-100 text-gray-800 placeholder-gray-500 text-sm focus:outline-none"
                                   placeholder="Ulangi password baru">
                            <button type="button" onclick="togglePassword('password_confirmation')"
                                    class="inline-flex items-center px-3 bg-gray-100 text-gray-600 hover:text-blue-600 text-sm">
                                <i class="fas fa-eye text-xs"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold py-2 rounded-full text-sm hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200">
                        <i class="fas fa-check mr-2"></i>Reset Password
                    </button>
                </form>

                <hr class="my-4 border-gray-300">

                <!-- Back to Login -->
                <div class="text-center">
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                        <i class="fas fa-arrow-left mr-1"></i>Kembali ke Login
                    </a>
                </div>
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

        document.getElementById('resetForm')?.addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;

            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Password dan konfirmasi password tidak cocok!');
                return false;
            }
        });
    </script>
</body>
</html> --}}
