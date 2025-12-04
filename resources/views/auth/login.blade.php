{{-- <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Sistem Peminjaman Inventaris Fasilkom</title>
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
                        <h2 class="text-3xl font-bold text-white mb-3">Selamat Datang Kembali!</h2>
                        <p class="text-blue-100 text-sm leading-relaxed">
                            Silakan login dengan informasi pribadi Anda
                        </p>
                    </div>
                </div>

                <!-- Footer -->
                <p class="text-blue-100 text-xs text-center">
                    &copy; 2025 SIPINJAM - Fakultas Ilmu Komputer Universitas Jember
                </p>
            </div>

            <!-- Right Side - Login Form -->
            <div class="w-full md:w-1/2 bg-white p-10">
                <div class="mb-6">
                    <h3 class="text-3xl font-bold text-gray-800">Login</h3>
                    <p class="text-gray-600 text-sm mt-1">Masuk ke akun Anda</p>
                </div>

                <form method="POST" action="{{ route('login.post') }}" id="loginForm">
                    @csrf

                    @if($errors->has('email'))
                        <div class="mb-4 p-3 bg-yellow-50 border border-yellow-300 rounded-lg text-yellow-800 text-sm">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            {{ $errors->first('email') }}
                        </div>
                    @endif

                    @if($errors->has('password'))
                        <div class="mb-4 p-3 bg-red-50 border border-red-300 rounded-lg text-red-800 text-sm">
                            <i class="fas fa-lock mr-2"></i>
                            {{ $errors->first('password') }}
                        </div>
                    @endif

                    <!-- Email -->
                    <div class="mb-4">
                        <label for="login_email" class="block text-gray-700 font-semibold text-sm mb-2">Email</label>
                        <div class="flex border-2 border-gray-300 rounded-lg overflow-hidden">
                            <span class="inline-flex items-center px-3 bg-gray-900 text-white">
                                <i class="fas fa-envelope text-sm"></i>
                            </span>
                            <input type="email" id="login_email" name="email" value="{{ old('email') }}" required
                                   class="flex-1 px-3 py-2 bg-white text-gray-800 placeholder-gray-500 text-sm focus:outline-none"
                                   placeholder="email@example.com">
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label for="login_password" class="block text-gray-700 font-semibold text-sm mb-2">Password</label>
                        <div class="flex border-2 border-gray-300 rounded-lg overflow-hidden">
                            <span class="inline-flex items-center px-3 bg-gray-900 text-white">
                                <i class="fas fa-lock text-sm"></i>
                            </span>
                            <input type="password" id="login_password" name="password" required
                                   class="flex-1 px-3 py-2 bg-white text-gray-800 placeholder-gray-500 text-sm focus:outline-none"
                                   placeholder="Masukkan password">
                            <button type="button" onclick="togglePassword('login_password')"
                                    class="inline-flex items-center px-3 bg-white text-gray-600 hover:text-blue-600 text-sm">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Lupa Password -->
                    <div class="text-right mb-4">
                        <a href="{{ route('password.request') }}" class="text-blue-600 hover:text-blue-700 text-xs font-medium">
                            Lupa Password?
                        </a>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold py-2 rounded-full text-sm hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200">
                        Login
                    </button>
                </form>

                <hr class="my-4 border-gray-300">

                <!-- Register Link -->
                <p class="text-center text-gray-600 text-sm">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-700 font-bold">
                        Daftar
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

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Sistem Peminjaman Inventaris Fasilkom</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-8 col-lg-6">
                <div class="card border-0 shadow-lg">
                    <div class="card-header bg-dark text-white text-center py-4">
                        <div class="d-flex justify-content-center align-items-center gap-4 mb-3">
                            <img src="{{ asset('storage/images/unej.png') }}" alt="UNEJ" class="img-fluid" style="height: 30px;" onerror="this.style.display='none'">
                            <img src="{{ asset('storage/images/fasilkom.png') }}" alt="Fasilkom" class="img-fluid" style="height: 25px; filter: brightness(0) invert(1);" onerror="this.style.display='none'">
                        </div>
                        <h4 class="mb-2">Sistem Peminjaman Inventaris</h4>
                        <p class="mb-0 opacity-75">Fakultas Ilmu Komputer - Universitas Jember</p>
                    </div>

                    <div class="card-body p-4">
                        <ul class="nav nav-pills nav-justified mb-4" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-login-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-login" type="button" role="tab">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-register-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-register" type="button" role="tab">
                                    <i class="fas fa-user-plus me-2"></i>Register
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content" id="pills-tabContent">
                            <!-- Login Form -->
                            <div class="tab-pane fade show active" id="pills-login" role="tabpanel">
                                <form method="POST" action="{{ route('login.post') }}">
                                    @csrf

                                    @if($errors->any() && $errors->has('email') && !$errors->has('name'))
                                        <div class="alert alert-warning alert-dismissible fade show">
                                            <i class="fas fa-exclamation-circle me-2"></i>
                                            {{ $errors->first('email') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                        </div>
                                    @endif

                                    @if($errors->any() && $errors->has('password'))
                                        <div class="alert alert-danger alert-dismissible fade show">
                                            <i class="fas fa-lock me-2"></i>
                                            {{ $errors->first('password') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                        </div>
                                    @endif

                                    <div class="mb-3">
                                        <label for="login_email" class="form-label">Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-dark text-white">
                                                <i class="fas fa-envelope"></i>
                                            </span>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                    id="login_email" name="email" value="{{ old('email') }}" required
                                                    placeholder="email@example.com">
                                        </div>
                                        @error('email')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="login_password" class="form-label">Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-dark text-white">
                                                <i class="fas fa-lock"></i>
                                            </span>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                                    id="login_password" name="password" required
                                                    placeholder="Masukkan password">
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('login_password')">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        @error('password')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-dark btn-lg text-white">
                                            <i class="fas fa-sign-in-alt me-2"></i> Login ke Sistem
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Register Form -->
                            <div class="tab-pane fade" id="pills-register" role="tabpanel">
                                <form method="POST" action="{{ route('register') }}" id="registerForm">
                                    @csrf

                                    @if($errors->any() && ($errors->has('name') || $errors->has('nim') || $errors->has('phone') || $errors->has('email')))
                                        <div class="alert alert-danger alert-dismissible fade show">
                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                            <strong>Registrasi gagal!</strong> Periksa data yang Anda masukkan.
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                        </div>
                                    @endif

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="register_name" class="form-label">Nama Lengkap</label>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                             id="register_name" name="name" value="{{ old('name') }}" required
                                                             placeholder="Nama lengkap">
                                                @error('name')
                                                     <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="register_nim" class="form-label">NIM</label>
                                                <input type="text" class="form-control @error('nim') is-invalid @enderror"
                                                             id="register_nim" name="nim" value="{{ old('nim') }}" required
                                                             placeholder="12 digit NIM" maxlength="12">
                                                @error('nim')
                                                     <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="register_email" class="form-label">Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-dark text-white">
                                                <i class="fas fa-envelope"></i>
                                            </span>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                             id="register_email" name="email" value="{{ old('email') }}" required
                                                             placeholder="email@student.unej.ac.id">
                                        </div>
                                        @error('email')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="register_phone" class="form-label">Nomor HP</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-dark text-white">
                                                         <i class="fas fa-phone"></i>
                                                    </span>
                                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                                             id="register_phone" name="phone" value="{{ old('phone') }}" required
                                                             placeholder="08xxxxxxxxxx">
                                                </div>
                                                @error('phone')
                                                     <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="register_password" class="form-label">Password</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                                             id="register_password" name="password" required
                                                             placeholder="Minimal 6 karakter">
                                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('register_password')">
                                                         <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                                @error('password')
                                                     <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="register_password_confirmation" class="form-label">Konfirmasi Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="register_password_confirmation"
                                                     name="password_confirmation" required placeholder="Ulangi password">
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('register_password_confirmation')">
                                                 <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <small>Pastikan NIM terdiri dari 12 digit angka dan data yang dimasukkan valid.</small>
                                    </div>

                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-dark btn-lg text-white">
                                            <i class="fas fa-user-plus me-2"></i> Daftar Akun Mahasiswa
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4 text-muted">
                    <small>
                        &copy; 2025 Sistem Peminjaman Inventaris Fasilkom UNEJ.
                        All rights reserved.
                    </small>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Password toggle function
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = input.parentNode.querySelector('button i');

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

        // NIM validation (12 digit)
        document.getElementById('register_nim')?.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length > 12) {
                this.value = this.value.slice(0, 12);
            }
        });

        // Phone number validation
        document.getElementById('register_phone')?.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        // Auto switch to register tab if email not found or register errors
        document.addEventListener('DOMContentLoaded', function() {
            // Kita akan menggunakan PHP untuk menentukan apakah tab register harus aktif
            const shouldShowRegister = {!! json_encode(session('show_register') || $errors->has('name') || $errors->has('nim') || $errors->has('phone') || $errors->has('email')) !!};

            if (shouldShowRegister) {
                const registerTab = new bootstrap.Tab(document.getElementById('pills-register-tab'));
                registerTab.show();
            }

            // Show success message
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    timer: 4000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            @endif
        });

        // Form submission loading state
        document.getElementById('registerForm')?.addEventListener('submit', function() {
            const btn = this.querySelector('button[type="submit"]');
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mendaftarkan...';
            btn.disabled = true;
        });
    </script>
</body>
</html>
