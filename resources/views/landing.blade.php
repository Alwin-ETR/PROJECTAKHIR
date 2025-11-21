<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPINJAM - Sistem Peminjaman Inventaris Fasilkom</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#212529',
                        secondary: '#343a40',
                        accent: '#0d6efd',
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; background: #212529; }
    </style>
</head>
<body class="bg-primary text-gray-100">
    <!-- Navbar -->
    <nav class="bg-linear-to-r from-primary to-gray-800 border-b-2 border-accent shadow-lg fixed w-full top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <img src="{{ asset('storage/images/unej.png') }}" alt="UNEJ" class="h-8 w-8 rounded-lg" onerror="this.style.display='none'">
                <span class="ml-2 flex items-center gap-3">
                    <i class="fas fa-boxes text-white text-xl"></i>
                    <span class="font-bold text-lg text-white">SIPINJAM</span>
                </span>
            </div>
            <div class="hidden md:flex space-x-8 items-center">
                <a href="#beranda" class="text-gray-300 hover:text-accent font-medium">Beranda</a>
                <a href="#fitur" class="text-gray-300 hover:text-accent font-medium">Fitur</a>
                <a href="#workflow" class="text-gray-300 hover:text-accent font-medium">Tata Cara</a>
                <a href="#faq" class="text-gray-300 hover:text-accent font-medium">FAQ</a>
                <a href="#kontak" class="text-gray-300 hover:text-accent font-medium">Kontak</a>
                <a href="{{ route('login') }}" class="ml-6 px-5 py-2 bg-linear-to-r from-accent to-blue-600 text-white rounded-lg font-semibold shadow hover:scale-105 transition-all">Masuk</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="beranda" class="pt-32 pb-20 class="bg-linear-to-r from-gray-900 via-gray-800 to-gray-900">
        <div class="container mx-auto px-6 flex flex-col md:flex-row items-center justify-between">
            <div class="md:w-1/2 mb-10 md:mb-0">
                <h1 class="text-4xl md:text-5xl font-bold mb-5 leading-tight text-white">
                    Sistem Manajemen Peminjaman Inventaris di Fasilkom
                </h1>
                <p class="text-lg mb-7 text-gray-200">
                    Platform peminjaman inventaris Fakultas Ilmu Komputer Universitas Jember, memudahkan mahasiswa dan staf mengakses dan mengelola barang kampus secara efisien dan transparan.
                </p>
                <a href="{{ route('login') }}" class="bg-linear-to-r from-accent to-blue-600 text-white inline-block px-8 py-4 rounded-lg font-bold text-lg shadow hover:scale-105 hover:from-blue-700 hover:to-blue-800 transition-all duration-200">
                    Mulai Pinjam
                </a>
            </div>
            <div class="md:w-1/2 flex justify-center">
                <img src="{{ asset('storage/images/hero-image.png') }}" alt="Hero SIPINJAM" class="w-80 h-80 object-contain drop-shadow-2xl rounded-3xl bg-white" onerror="this.style.display='none'">
                <!-- Fallback SVG jika hero-image.png tidak ada -->
                <svg class="w-96 h-96" viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <ellipse cx="200" cy="200" rx="150" ry="150" fill="rgba(13,110,253,0.06)"/>
                    <rect x="130" y="120" width="140" height="100" rx="10" fill="white" opacity="0.9"/>
                    <circle cx="200" cy="170" r="25" fill="#21808D"/>
                    <path d="M160 240 L200 280 L240 240" stroke="white" stroke-width="8"/>
                    <rect x="150" y="300" width="100" height="60" rx="8" fill="white" opacity="0.8"/>
                </svg>
            </div>
        </div>
    </section>

    <!-- Tentang & Fitur -->
    <section id="fitur" class="py-16 bg-secondary">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-white mb-4">Tentang SIPINJAM</h2>
            <p class="mb-8 text-lg text-gray-300">
                Platform peminjaman inventaris Fakultas Ilmu Komputer Universitas Jember, memudahkan mahasiswa dan staf mengakses dan mengelola barang kampus secara efisien dan transparan.
            </p>
            <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-8">
                <div class="dark-card p-7 rounded-xl text-center flex flex-col items-center card-hover">
                    <i class="fas fa-bolt text-accent text-3xl mb-3"></i>
                    <span class="font-bold mb-2 text-lg">Peminjaman Mudah dan Cepat</span>
                    <p class="text-sm text-gray-300">Proses peminjaman online tanpa ribet.</p>
                </div>
                <div class="dark-card p-7 rounded-xl text-center flex flex-col items-center card-hover">
                    <i class="fas fa-bell text-blue-400 text-3xl mb-3"></i>
                    <span class="font-bold mb-2 text-lg">Notifikasi Status Real-time</span>
                    <p class="text-sm text-gray-300">Cek persetujuan atau penolakan langsung secara online.</p>
                </div>
                <div class="dark-card p-7 rounded-xl text-center flex flex-col items-center card-hover">
                    <i class="fas fa-database text-green-400 text-3xl mb-3"></i>
                    <span class="font-bold mb-2 text-lg">Data Inventaris Lengkap</span>
                    <p class="text-sm text-gray-300">Informasi barang selalu up-to-date.</p>
                </div>
                <div class="dark-card p-7 rounded-xl text-center flex flex-col items-center card-hover">
                    <i class="fas fa-history text-yellow-400 text-3xl mb-3"></i>
                    <span class="font-bold mb-2 text-lg">Riwayat Peminjaman Rapi</span>
                    <p class="text-sm text-gray-300">Semua peminjaman tercatat otomatis.</p>
                </div>
                <div class="dark-card p-7 rounded-xl text-center flex flex-col items-center card-hover">
                    <i class="fas fa-shield-alt text-indigo-400 text-3xl mb-3"></i>
                    <span class="font-bold mb-2 text-lg">Proses Transparan</span>
                    <p class="text-sm text-gray-300">Menjamin keamanan & efisiensi aset kampus.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Workflow Section -->
    <section id="workflow" class="py-16 bg-secondary">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-white mb-6">Alur Proses Peminjaman</h2>
            <div class="grid md:grid-cols-6 gap-6 text-center">
                <div>
                    <div class="bg-accent w-14 h-14 mx-auto mb-3 rounded-full flex items-center justify-center">
                        <i class="fas fa-sign-in-alt text-2xl text-white"></i>
                    </div>
                    <p class="font-bold mb-1">Login</p>
                </div>
                <div>
                    <div class="bg-indigo-600 w-14 h-14 mx-auto mb-3 rounded-full flex items-center justify-center">
                        <i class="fas fa-search text-2xl text-white"></i>
                    </div>
                    <p class="font-bold mb-1">Cari Barang</p>
                </div>
                <div>
                    <div class="bg-green-600 w-14 h-14 mx-auto mb-3 rounded-full flex items-center justify-center">
                        <i class="fas fa-cart-plus text-2xl text-white"></i>
                    </div>
                    <p class="font-bold mb-1">Ajukan Peminjaman</p>
                </div>
                <div>
                    <div class="bg-yellow-400 w-14 h-14 mx-auto mb-3 rounded-full flex items-center justify-center">
                        <i class="fas fa-user-shield text-2xl text-white"></i>
                    </div>
                    <p class="font-bold mb-1">Verifikasi Admin</p>
                </div>
                <div>
                    <div class="bg-blue-500 w-14 h-14 mx-auto mb-3 rounded-full flex items-center justify-center">
                        <i class="fas fa-box-open text-2xl text-white"></i>
                    </div>
                    <p class="font-bold mb-1">Ambil Barang</p>
                </div>
                <div>
                    <div class="bg-gray-600 w-14 h-14 mx-auto mb-3 rounded-full flex items-center justify-center">
                        <i class="fas fa-history text-2xl text-white"></i>
                    </div>
                    <p class="font-bold mb-1">Pengembalian & Konfirmasi</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="py-16 bg-gray-900">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-white mb-8">FAQ</h2>
            <div class="space-y-6">
                <div>
                    <p class="font-bold mb-2">Siapa yang bisa meminjam barang?</p>
                    <p class="text-gray-300">Mahasiswa aktif Fasilkom UNEJ yang telah memiliki akun sistem.</p>
                </div>
                <div>
                    <p class="font-bold mb-2">Bagaimana prosedur pengajuan peminjaman?</p>
                    <p class="text-gray-300">Cari barang, klik tombol "Pinjam", isi form pengajuan, kemudian tunggu proses verifikasi admin.</p>
                </div>
                <div>
                    <p class="font-bold mb-2">Kapan bisa mengambil barang?</p>
                    <p class="text-gray-300">Setelah pengajuan disetujui.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="kontak" class="bg-linear-to-r from-primary to-secondary py-12 border-t-2 border-accent">
        <div class="container mx-auto px-6 grid md:grid-cols-2 gap-10">
            <div>
                <h3 class="text-xl font-bold mb-4 flex items-center gap-2">
                    <i class="fas fa-boxes mr-2"></i>SIPINJAM
                </h3>
                <p class="text-gray-300">Sistem Peminjaman Inventaris Fakultas Ilmu Komputer Universitas Jember</p>
                <div class="flex items-center gap-4 mt-5">
                    <img src="{{ asset('storage/images/unej.png') }}" alt="UNEJ" class="h-8" onerror="this.style.display='none'">
                    <img src="{{ asset('storage/images/fasilkom.png') }}" alt="Fasilkom" class="h-7 brightness-0 invert" onerror="this.style.display='none'">
                </div>
            </div>
            <div class="flex flex-col gap-2 justify-center text-gray-300">
                <span><i class="fas fa-envelope mr-2"></i> fasilkom@unej.ac.id</span>
                <span><i class="fas fa-phone mr-2"></i> +62 331-326911</span>
                <span><i class="fas fa-map-marker-alt mr-2"></i> Jl. Kalimantan No.37, Kampus Tegalboto, Sumbersari, Jember</span>
            </div>
        </div>
        <div class="text-center text-gray-400 pt-7 text-sm">&copy; 2025 SIPINJAM - Fasilkom UNEJ. All rights reserved.</div>
    </footer>

    <script>
        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    </script>
</body>
</html>
