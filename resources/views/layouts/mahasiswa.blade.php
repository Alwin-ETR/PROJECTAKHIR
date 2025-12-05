<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Mahasiswa') - SIPINJAM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');

        * {
            font-family: 'Inter', sans-serif;
        }

        .nav-link {
            @apply text-gray-700 px-6 py-2 rounded-lg transition-all duration-300 cursor-pointer flex items-center gap-2;
            font-weight: 500;
            position: relative;
        }

        .nav-link:hover {
            @apply bg-blue-50 text-blue-900;
        }

        /* Desktop Active Style */
        .nav-link.active {
            @apply text-blue-900 bg-blue-50;
            border-bottom: 3px solid #0d6efd;
            padding-bottom: calc(0.5rem - 3px);
        }

        /* Mobile Active Style */
        .nav-link.active-mobile {
            @apply text-blue-900 bg-blue-50 border-l-4 border-blue-600 pl-3;
        }

        .mobile-menu {
            display: none;
        }

        @media (max-width: 1024px) {
            .desktop-nav {
                display: none;
            }
            .mobile-menu {
                display: block;
            }
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-900">
    <!-- Top Navigation Header -->
    <header class="bg-white border-b-2 border-gray-200 shadow-sm sticky top-0 z-50">
        <div class="px-6 py-4">
            <div class="flex justify-between items-center">
                <!-- Logo/Left Section -->
                <div class="flex items-center gap-3">
                    <img src="{{ asset('storage/images/logo-sipinjam.png') }}" 
                        alt="Logo SIPINJAM" 
                        class="h-10 w-auto object-contain">

                    <div>
                        <h2 class="text-2xl font-bold text-blue-900 leading-tight">SIPINJAM</h2>
                        <p class="text-blue-600 text-xs hidden sm:block -mt-1">
                            Sistem Peminjaman Inventaris
                        </p>
                    </div>
                </div>

                <!-- Desktop Navigation -->
                <nav class="desktop-nav flex items-center gap-4">
                    <a href="{{ route('mahasiswa.dashboard') }}"
                        class="nav-link {{ request()->routeIs('mahasiswa.dashboard') ? 'active' : '' }}">
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('mahasiswa.katalog') }}"
                        class="nav-link {{ request()->routeIs('mahasiswa.katalog') ? 'active' : '' }}">
                        <span>Katalog</span>
                    </a>

                    <a href="{{ route('mahasiswa.riwayat') }}"
                        class="nav-link {{ request()->routeIs('mahasiswa.riwayat') ? 'active' : '' }}">
                        <span>Riwayat</span>
                    </a>

                    <a href="{{ route('mahasiswa.profile') }}"
                        class="nav-link {{ request()->routeIs('mahasiswa.profile') ? 'active' : '' }}">
                        <span>Profil</span>
                    </a>
                </nav>

                <!-- Right Section: Profile, Logout & Mobile Menu -->
                <div class="flex items-center gap-3">
                    <!-- Username & Avatar -->
                    <div class="hidden sm:flex items-center gap-3 pr-3 border-r border-gray-200">
                        <div class="text-right">
                            <p class="text-sm font-bold text-gray-900">{{ Auth::user()->name ?? 'Mahasiswa' }}</p>
                        </div>
                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'User' }}&background=random"
                            alt="Avatar" class="w-10 h-10 rounded-full border-2 border-blue-400">
                    </div>

                    <!-- Logout Button -->
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700 transition-all font-medium text-sm flex items-center gap-2">
                            <i class="fas fa-sign-out-alt"></i>
                            <span class="hidden sm:inline">Logout</span>
                        </button>
                    </form>

                    <!-- Mobile Menu Toggle -->
                    <button class="mobile-menu lg:hidden text-gray-900 hover:text-blue-900" id="mobileMenuBtn">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation Menu -->
            <nav class="mobile-menu mt-4 space-y-2 hidden" id="mobileNav">
                <a href="{{ route('mahasiswa.dashboard') }}"
                    class="nav-link {{ request()->routeIs('mahasiswa.dashboard') ? 'active-mobile' : '' }}">
                    <i class="fas fa-chart-line"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('mahasiswa.katalog') }}"
                    class="nav-link {{ request()->routeIs('mahasiswa.katalog') ? 'active-mobile' : '' }}">
                    <i class="fas fa-book"></i>
                    <span>Katalog</span>
                </a>

                <a href="{{ route('mahasiswa.riwayat') }}"
                    class="nav-link {{ request()->routeIs('mahasiswa.riwayat') ? 'active-mobile' : '' }}">
                    <i class="fas fa-history"></i>
                    <span>Riwayat</span>
                </a>

                <a href="{{ route('mahasiswa.profile') }}"
                    class="nav-link {{ request()->routeIs('mahasiswa.profile') ? 'active-mobile' : '' }}">
                    <i class="fas fa-user"></i>
                    <span>Profil</span>
                </a>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto">
        <!-- Page Content -->
        <div class="px-6 py-6 max-w-7xl mx-auto">
            @yield('content')
        </div>
    </main>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Mobile Menu Toggle Script -->
    <script>
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileNav = document.getElementById('mobileNav');

        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', function() {
                mobileNav.classList.toggle('hidden');
            });
        }
    </script>

    <!-- SweetAlert Notifications -->
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false,
            position: 'center'
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '{{ session('error') }}',
            timer: 3000,
            showConfirmButton: false,
            position: 'center'
        });
    </script>
    @endif

    <!-- Cookie Helper Functions -->
    <script>
        function setCookie(name, value, days) {
            const d = new Date();
            d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000));
            document.cookie = name + "=" + value + ";expires=" + d.toUTCString() + ";path=/";
        }

        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        }

        function simpanKeRiwayat(barangId) {
            let riwayat = JSON.parse(getCookie('barang_terakhir_dilihat') || '[]');
            riwayat = riwayat.filter(id => id != barangId);
            riwayat.unshift(barangId);
            riwayat = riwayat.slice(0, 10);
            setCookie('barang_terakhir_dilihat', JSON.stringify(riwayat), 30);
        }

        @if(request()->has('focus'))
            simpanKeRiwayat({{ request()->focus }});
        @endif
    </script>

    @stack('scripts')
</body>
</html>
