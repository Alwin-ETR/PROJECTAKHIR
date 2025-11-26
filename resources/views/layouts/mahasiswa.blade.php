<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Mahasiswa') - SIPINJAM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
        body { 
            font-family: 'Inter', sans-serif; 
        }
        .sidebar {
            min-height: 100vh;
            background-color: #f8f9fa;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .sidebar .nav-link {
            color: #333;
            padding: 12px 15px;
            margin: 2px 0;
            border-radius: 5px;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: #2563EB;
            color: white;
        }
        .stat-card {
            border-radius: 10px;
            transition: transform 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-3px);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar">
                <div class="position-sticky pt-3">
                    <h5 class="px-3 text-primary">
                        <i class="bi bi-person-circle"></i> Mahasiswa Panel
                    </h5>
                    <hr>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('mahasiswa.dashboard') ? 'active' : '' }}" 
                               href="{{ route('mahasiswa.dashboard') }}">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('mahasiswa.search') ? 'active' : '' }}" 
                               href="{{ route('mahasiswa.search') }}">
                                <i class="bi bi-box-seam"></i> Daftar Barang
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('mahasiswa.riwayat') ? 'active' : '' }}" 
                               href="{{ route('mahasiswa.riwayat') }}">
                                <i class="bi bi-clock-history"></i> Riwayat Peminjaman
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('mahasiswa.profile') ? 'active' : '' }}" 
                               href="{{ route('mahasiswa.profile') }}">
                                <i class="bi bi-person"></i> Profil Saya
                            </a>
                        </li>
                        <li class="nav-item mt-4">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="nav-link btn btn-link text-start w-100 text-danger">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
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
            showConfirmButton: false
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
            showConfirmButton: false
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
