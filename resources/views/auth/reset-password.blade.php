<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reset Password - SIPINJAM</title>
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
                    <h2 class="text-3xl lg:text-4xl font-bold mb-4">Reset Password</h2>
                    <p class="text-teal-100 text-base leading-relaxed mb-8">
                        Sistem Peminjaman Inventaris<br>
                        Fakultas Ilmu Komputer<br>
                        Universitas Jember
                    </p>
                </div>
            </div>

            <!-- Right Panel - Reset Password Form -->
            <div class="lg:w-7/12 p-8 lg:p-12 flex flex-col justify-center overflow-y-auto max-h-screen">
                
                <div class="max-w-md mx-auto w-full" id="reset-password-form">
                    <!-- Form Title -->
                    <h3 class="text-2xl font-bold text-gray-800 mb-1">Atur Ulang Password</h3>
                    <p class="text-gray-500 text-xs mb-6">Masukkan password baru Anda untuk melanjutkan</p>

                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="flex items-center gap-2 p-3 rounded-lg bg-red-50 border border-red-200 text-red-800 text-xs mb-4">
                            <i class="fas fa-exclamation-circle flex-shrink-0"></i>
                            <span><strong>Reset gagal!</strong> {{ $errors->first() }}</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.update') }}" id="resetPasswordForm" class="space-y-3">
                        @csrf

                        <!-- Hidden fields: token dan email -->
                        <input type="hidden" name="token" value="{{ $token }}">
                        <input type="hidden" name="email" value="{{ $email }}">

                        <!-- Email Display (Read-only) -->
                        <div>
                            <label for="email_display" class="block text-xs font-semibold text-gray-700 mb-1">Email</label>
                            <div class="relative">
                                <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                    <i class="fas fa-envelope text-xs"></i>
                                </div>
                                <input
                                    type="email"
                                    id="email_display"
                                    value="{{ $email }}"
                                    disabled
                                    class="w-full pl-9 pr-3 py-2 bg-gray-100 border-2 border-gray-200 rounded-lg text-gray-600 text-xs cursor-not-allowed">
                            </div>
                        </div>

                        <!-- Password & Confirm Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <!-- Password Baru -->
                            <div>
                                <label for="password" class="block text-xs font-semibold text-gray-700 mb-1">Password Baru</label>
                                <div class="relative">
                                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                        <i class="fas fa-lock text-xs"></i>
                                    </div>
                                    <input
                                        type="password"
                                        id="password"
                                        name="password"
                                        required
                                        class="w-full pl-9 pr-9 py-2 bg-gray-100 border-2 border-gray-200 rounded-lg text-gray-800 text-xs placeholder-gray-400 focus:outline-none focus:bg-white focus:border-blue-500 transition"
                                        placeholder="Min 8 karakter">
                                    <button
                                        type="button"
                                        onclick="togglePassword('password')"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-blue-600 transition text-xs">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Konfirmasi Password -->
                            <div>
                                <label for="password_confirmation" class="block text-xs font-semibold text-gray-700 mb-1">Konfirmasi</label>
                                <div class="relative">
                                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                        <i class="fas fa-lock text-xs"></i>
                                    </div>
                                    <input
                                        type="password"
                                        id="password_confirmation"
                                        name="password_confirmation"
                                        required
                                        class="w-full pl-9 pr-9 py-2 bg-gray-100 border-2 border-gray-200 rounded-lg text-gray-800 text-xs placeholder-gray-400 focus:outline-none focus:bg-white focus:border-blue-500 transition"
                                        placeholder="Ulangi password">
                                    <button
                                        type="button"
                                        onclick="togglePassword('password_confirmation')"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-blue-600 transition text-xs">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Info Message -->
                        <div class="flex items-start gap-2 p-3 rounded-lg bg-blue-50 border border-blue-200 text-blue-800 text-xs">
                            <i class="fas fa-info-circle mt-0.5 flex-shrink-0"></i>
                            <span>Password minimal 8 karakter.</span>
                        </div>

                        <!-- Submit Button -->
                        <button
                            type="submit"
                            class="w-full py-2 px-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold text-sm rounded-lg hover:shadow-lg hover:from-blue-600 hover:to-blue-700 transition transform hover:-translate-y-0.5">
                            <i class="fas fa-lock-open mr-1"></i>Reset Password
                        </button>
                    </form>

                    <!-- Divider -->
                    <div class="my-3 flex items-center gap-3">
                        <div class="flex-1 h-px bg-gray-200"></div>
                        <span class="text-gray-400 text-xs">atau</span>
                        <div class="flex-1 h-px bg-gray-200"></div>
                    </div>

                    <!-- Back to Login Link -->
                    <p class="text-center text-gray-600 text-xs">
                        <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:text-blue-700 hover:underline">
                            ← Kembali ke Login
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

        document.getElementById('resetPasswordForm')?.addEventListener('submit', function () {
            const btn = this.querySelector('button[type="submit"]');
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Mengatur...';
            btn.disabled = true;
        });

        @if(session('status'))
            Swal.fire({
                icon: 'success',
                title: 'Password Berhasil Direset!',
                text: 'Silakan login dengan password baru Anda.',
                timer: 3000,
                showConfirmButton: false,
                allowOutsideClick: false,
                didOpen: (modal) => {
                    modal.parentElement.style.zIndex = 9999;
                }
            });
        @endif
    </script>
</body>
</html>