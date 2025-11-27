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
                        primary: '#ffffff',
                        secondary: '#f8f9fa',
                        accent: '#0d6efd',
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
        body { 
            font-family: 'Inter', sans-serif; 
        }
    </style>
</head>
<body class="bg-white text-gray-900">
    <!-- Navbar -->
    <nav class="bg-white border-b-2 border-gray-200 shadow-sm fixed w-full top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <img src="{{ asset('storage/images/unej.png') }}" alt="UNEJ" class="h-8 w-8 rounded-lg" onerror="this.style.display='none'">
                <span class="ml-2 flex items-center gap-3">
                    <span class="font-bold text-lg text-gray-900">SIPINJAM</span>
                </span>
            </div>
            <div class="hidden md:flex space-x-8 items-center">
                <a href="#beranda" class="text-gray-600 hover:text-accent font-medium transition-colors">Beranda</a>
                <a href="#fitur" class="text-gray-600 hover:text-accent font-medium transition-colors">Fitur</a>
                <a href="#workflow" class="text-gray-600 hover:text-accent font-medium transition-colors">Tata Cara</a>
                <a href="#faq" class="text-gray-600 hover:text-accent font-medium transition-colors">FAQ</a>
                <a href="#kontak" class="text-gray-600 hover:text-accent font-medium transition-colors">Kontak</a>
                <a href="{{ route('login') }}" class="ml-6 px-5 py-2 bg-accent text-white rounded-lg font-semibold shadow hover:bg-blue-700 hover:scale-105 transition-all">Masuk</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section dengan Background -->
    <section id="beranda" class="pt-32 pb-20 bg-cover bg-top" style="background-image: linear-gradient(rgba(255,255,255,0.9), rgba(255,255,255,0.8)), url('{{ asset('storage/images/Jember(UNEJ).jpg') }}');">
    <div class="container mx-auto px-6 flex flex-col md:flex-row items-center justify-between">
        <div class="md:w-1/2 mb-10 md:mb-0">
            <h1 class="text-4xl md:text-5xl font-bold mb-5 leading-tight text-gray-900">
                Sistem Manajemen Peminjaman Inventaris di Fasilkom
            </h1>
            <p class="text-lg mb-7 text-gray-600">
                Platform peminjaman inventaris Fakultas Ilmu Komputer Universitas Jember, memudahkan mahasiswa dan staf mengakses dan mengelola barang kampus secara efisien dan transparan.
            </p>
            <a href="{{ route('login') }}" class="bg-gradient-to-r from-accent to-blue-600 text-white inline-block px-8 py-4 rounded-lg font-bold text-lg shadow-lg hover:scale-105 hover:shadow-xl transition-all duration-200">
                Mulai Pinjam
            </a>
        </div>
        <div class="md:w-1/2 flex justify-center">
            <img src="{{ asset('storage/images/unej.png') }}" alt="Hero SIPINJAM" class="w-80 h-80 object-contain drop-shadow-2xl rounded-3xl" onerror="this.style.display='none'">
        </div>
    </div>
</section>

    <!-- Tentang & Fitur -->
    <section id="fitur" class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Tentang SIPINJAM</h2>
            <p class="mb-8 text-lg text-gray-600">
                Platform peminjaman inventaris Fakultas Ilmu Komputer Universitas Jember, memudahkan mahasiswa dan staf mengakses dan mengelola barang kampus secara efisien dan transparan.
            </p>
            <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-8">
                <div class="bg-white border border-gray-200 hover:border-accent p-7 rounded-xl text-center flex flex-col items-center transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                    <i class="fas fa-bolt text-accent text-3xl mb-3"></i>
                    <span class="font-bold mb-2 text-lg text-gray-900">Peminjaman Mudah dan Cepat</span>
                    <p class="text-sm text-gray-600">Proses peminjaman online tanpa ribet.</p>
                </div>
                <div class="bg-white border border-gray-200 hover:border-accent p-7 rounded-xl text-center flex flex-col items-center transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                    <i class="fas fa-bell text-blue-500 text-3xl mb-3"></i>
                    <span class="font-bold mb-2 text-lg text-gray-900">Notifikasi Status Real-time</span>
                    <p class="text-sm text-gray-600">Cek persetujuan atau penolakan langsung secara online.</p>
                </div>
                <div class="bg-white border border-gray-200 hover:border-accent p-7 rounded-xl text-center flex flex-col items-center transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                    <i class="fas fa-database text-green-500 text-3xl mb-3"></i>
                    <span class="font-bold mb-2 text-lg text-gray-900">Data Inventaris Lengkap</span>
                    <p class="text-sm text-gray-600">Informasi barang selalu up-to-date.</p>
                </div>
                <div class="bg-white border border-gray-200 hover:border-accent p-7 rounded-xl text-center flex flex-col items-center transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                    <i class="fas fa-history text-yellow-500 text-3xl mb-3"></i>
                    <span class="font-bold mb-2 text-lg text-gray-900">Riwayat Peminjaman Rapi</span>
                    <p class="text-sm text-gray-600">Semua peminjaman tercatat otomatis.</p>
                </div>
                <div class="bg-white border border-gray-200 hover:border-accent p-7 rounded-xl text-center flex flex-col items-center transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                    <i class="fas fa-shield-alt text-indigo-500 text-3xl mb-3"></i>
                    <span class="font-bold mb-2 text-lg text-gray-900">Proses Transparan</span>
                    <p class="text-sm text-gray-600">Menjamin keamanan & efisiensi aset kampus.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Workflow Section -->
    <section id="workflow" class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">Alur Proses Peminjaman</h2>
            <div class="grid md:grid-cols-6 gap-6 text-center">
                <div>
                    <div class="bg-accent w-14 h-14 mx-auto mb-3 rounded-full flex items-center justify-center shadow-md">
                        <i class="fas fa-sign-in-alt text-2xl text-white"></i>
                    </div>
                    <p class="font-bold mb-1 text-gray-900">Login</p>
                </div>
                <div>
                    <div class="bg-indigo-600 w-14 h-14 mx-auto mb-3 rounded-full flex items-center justify-center shadow-md">
                        <i class="fas fa-search text-2xl text-white"></i>
                    </div>
                    <p class="font-bold mb-1 text-gray-900">Cari Barang</p>
                </div>
                <div>
                    <div class="bg-green-600 w-14 h-14 mx-auto mb-3 rounded-full flex items-center justify-center shadow-md">
                        <i class="fas fa-cart-plus text-2xl text-white"></i>
                    </div>
                    <p class="font-bold mb-1 text-gray-900">Ajukan Peminjaman</p>
                </div>
                <div>
                    <div class="bg-yellow-500 w-14 h-14 mx-auto mb-3 rounded-full flex items-center justify-center shadow-md">
                        <i class="fas fa-user-shield text-2xl text-white"></i>
                    </div>
                    <p class="font-bold mb-1 text-gray-900">Verifikasi Admin</p>
                </div>
                <div>
                    <div class="bg-blue-500 w-14 h-14 mx-auto mb-3 rounded-full flex items-center justify-center shadow-md">
                        <i class="fas fa-box-open text-2xl text-white"></i>
                    </div>
                    <p class="font-bold mb-1 text-gray-900">Ambil Barang</p>
                </div>
                <div>
                    <div class="bg-gray-600 w-14 h-14 mx-auto mb-3 rounded-full flex items-center justify-center shadow-md">
                        <i class="fas fa-history text-2xl text-white"></i>
                    </div>
                    <p class="font-bold mb-1 text-gray-900">Pengembalian & Konfirmasi</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-gray-900 mb-8">FAQ</h2>
            <div class="space-y-6">
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <p class="font-bold mb-2 text-gray-900">Siapa yang bisa meminjam barang?</p>
                    <p class="text-gray-600">Mahasiswa aktif Fasilkom UNEJ yang telah memiliki akun sistem.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <p class="font-bold mb-2 text-gray-900">Bagaimana prosedur pengajuan peminjaman?</p>
                    <p class="text-gray-600">Cari barang, klik tombol "Pinjam", isi form pengajuan, kemudian tunggu proses verifikasi admin.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <p class="font-bold mb-2 text-gray-900">Kapan bisa mengambil barang?</p>
                    <p class="text-gray-600">Setelah pengajuan disetujui.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="kontak" class="bg-white py-12 border-t-2 border-gray-200">
        <div class="container mx-auto px-6 grid md:grid-cols-2 gap-10">
            <div>
                <h3 class="text-xl font-bold mb-4 flex items-center gap-2 text-gray-900">SIPINJAM</h3>
                <p class="text-gray-600">Sistem Peminjaman Inventaris Fakultas Ilmu Komputer Universitas Jember</p>
            </div>
            <div class="flex flex-col gap-2 justify-center text-gray-600">
                <span><i class="fas fa-envelope mr-2 text-accent"></i> fasilkom@unej.ac.id</span>
                <span><i class="fas fa-phone mr-2 text-accent"></i> +62 331-326911</span>
                <span><i class="fas fa-map-marker-alt mr-2 text-accent"></i> Jl. Kalimantan No.37, Kampus Tegalboto, Sumbersari, Jember</span>
            </div>
        </div>
        <div class="text-center text-gray-500 pt-7 text-sm">&copy; 2025 SIPINJAM - Fasilkom UNEJ. All rights reserved.</div>
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