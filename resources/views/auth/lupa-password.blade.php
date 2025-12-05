<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - SIPINJAM</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-600 via-blue-700 to-blue-800 flex items-center justify-center px-4 py-8 relative overflow-hidden">

    {{-- Dekorasi background blur --}}
    <div class="pointer-events-none absolute inset-0">
        <div class="absolute -top-32 -left-24 w-56 h-56 bg-blue-400/40 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-36 -right-16 w-64 h-64 bg-indigo-500/40 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 -right-24 w-52 h-52 bg-cyan-400/30 rounded-full blur-3xl"></div>
    </div>

    <div class="w-full max-w-3xl bg-white rounded-2xl shadow-2xl overflow-hidden relative z-10">
        <div class="flex flex-col md:flex-row">
            {{-- KIRI: logo & teks center --}}
            <div class="md:w-5/12 bg-gray-900 text-white p-6 md:p-7 flex flex-col items-center justify-center text-center">
                <div>
                    <div class="flex justify-center items-center gap-4 mb-6">
                        <img src="{{ asset('storage/images/unej.png') }}" alt="UNEJ" class="h-9" onerror="this.style.display='none'">
                        <img src="{{ asset('storage/images/fasilkom.png') }}" alt="Fasilkom" class="h-8 invert" onerror="this.style.display='none'">
                    </div>
                    <h4 class="text-xl font-semibold mb-2">SIPINJAM</h4>
                    <p class="text-sm text-gray-200 leading-relaxed">
                        Sistem Peminjaman Inventaris<br>
                        Fakultas Ilmu Komputer<br>
                        Universitas Jember
                    </p>
                </div>

                {{-- <p class="mt-8 text-[11px] text-gray-400">
                    &copy; 2025 Sistem Peminjaman Inventaris Fasilkom UNEJ.
                </p> --}}
            </div>

            {{-- KANAN: form lupa password --}}
            <div class="md:w-7/12 p-6 md:p-7">
                <h2 class="text-lg font-semibold text-gray-800 mb-1 text-center md:text-left">
                    Lupa Password
                </h2>
                <p class="text-sm text-gray-600 mb-5 text-center md:text-left">
                    Masukkan email Anda untuk mengatur ulang password.
                </p>

                @if (session('status'))
                    <div class="p-3 mb-4 bg-green-100 text-green-700 text-sm rounded-lg">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input
                            type="email"
                            name="email"
                            required
                            autofocus
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Masukkan email yang terdaftar"
                            value="{{ old('email') }}">

                        @error('email')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button
                        type="submit"
                        class="w-full py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white text-sm font-semibold rounded-full hover:shadow-lg hover:-translate-y-0.5 transition transform">
                        Kirim Link Reset Password
                    </button>
                </form>

                <div class="text-center mt-6">
                    <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                        ← Kembali ke halaman login
                    </a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
