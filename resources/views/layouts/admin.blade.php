<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Mahasiswa') - SIPINJAM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');

        * {
            font-family: 'Inter', sans-serif;
        }

        .sidebar-menu-item {
            @apply text-gray-100 px-4 py-3 rounded-lg mb-2 transition-all duration-300 cursor-pointer flex items-center gap-3;
            font-weight: 500;
        }

        .sidebar-menu-item:hover {
            @apply bg-white/10 text-white translate-x-1;
        }

        .sidebar-menu-item.active {
            @apply bg-white/20 text-white border-l-4 border-white;
        }

        .stat-card {
            @apply transition-transform duration-200 hover:shadow-lg hover:-translate-y-1;
        }
    </style>
</head>
<body class="bg-white text-gray-900">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gradient-to-b from-blue-900 to-blue-800 text-white min-h-screen overflow-y-auto flex-shrink-0 hidden lg:flex lg:flex-col">
            <!-- Top Content -->
            <div class="p-6 flex-1 overflow-y-auto">
                <!-- Logo -->
                <div class="mb-8 flex items-center gap-3">
                    <img src="{{ asset('storage/images/logo-sipinjam.png') }}" 
                        alt="Logo SIPINJAM" 
                        class="w-12 h-12 object-contain drop-shadow-md">
                    <h2 class="text-2xl font-bold">
                        ADMIN
                    </h2>
                </div>

                <hr class="border-blue-700 mb-6">

                <!-- Navigation Menu -->
                <nav class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-white/20 border-l-4 border-white text-white' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                        <i class="fas fa-chart-line w-5"></i>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('admin.barang.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.barang.*') ? 'bg-white/20 border-l-4 border-white text-white' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                        <i class="fas fa-boxes-stacked w-5"></i>
                        <span>Inventaris</span>
                    </a>

                    <a href="{{ route('admin.mahasiswa.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.mahasiswa.*') ? 'bg-white/20 border-l-4 border-white text-white' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                        <i class="fas fa-user-graduate w-5"></i>
                        <span>Mahasiswa</span>
                    </a>

                    <a href="{{ route('admin.peminjaman.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.peminjaman.*') ? 'bg-white/20 border-l-4 border-white text-white' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                        <i class="fas fa-clipboard-check w-5"></i>
                        <span>Peminjaman</span>
                    </a>
                </nav>
            </div>

            <!-- Logout Button -->
            <div class="p-6 border-t border-blue-700">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-3 px-4 py-3 rounded-lg bg-red-600 text-white hover:bg-red-700 transition-all font-medium">
                        <i class="fas fa-sign-out-alt w-5"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">

            <!-- Top Header -->
            <header class="bg-white border-b-2 border-gray-200 shadow-sm sticky top-0 z-40">
                <div class="flex justify-between items-center px-8 py-4">
                    <!-- Left: Empty -->
                    <div></div>

                    <!-- Right: Profile Only -->
                    <div class="flex items-center gap-3">
                        <div class="text-right">
                            <p class="text-sm font-bold text-gray-900">{{ Auth::user()->name ?? 'Mahasiswa' }}</p>
                        </div>
                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'User' }}&background=random"
                            alt="Avatar" class="w-10 h-10 rounded-full border-2 border-blue-400">
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="px-8 py-6">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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

        // Simpan barang yang dilihat ke cookie
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
