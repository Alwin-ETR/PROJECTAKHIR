<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - SIPINJAM</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        :root {
            --primary: #2563eb;      /* biru utama SIPINJAM */
            --secondary: #1e40af;    /* biru gelap */
            --accent: #60a5fa;       /* biru lembut */
        }

        .bg-primary { background-color: var(--primary); }
        .text-primary { color: var(--primary); }
        .hover\:bg-primary:hover { background-color: var(--primary); }
        .focus\:ring-primary:focus { --tw-ring-color: var(--primary); }
    </style>
</head>

<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex items-center justify-center px-4">

    <div class="w-full max-w-md bg-white shadow-xl rounded-2xl p-8 border border-blue-100">
        
        <!-- LOGO -->
        <div class="text-center mb-6">
            <img src="/assets/logo-sipinjam.png" alt="SIPINJAM Logo" class="mx-auto h-20">
            <h2 class="text-2xl font-bold text-gray-800 mt-4">Lupa Password</h2>
            <p class="text-gray-600 text-sm mt-1">Masukkan email Anda untuk mengatur ulang password</p>
        </div>

        <!-- STATUS (untuk notifikasi sukses kirim email) -->
        @if (session('status'))
            <div class="p-3 mb-4 bg-green-100 text-green-700 text-sm rounded-lg">
                {{ session('status') }}
            </div>
        @endif

        <!-- FORM KIRIM LINK RESET -->
        <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" required autofocus
                    class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary"
                    placeholder="Masukkan email yang terdaftar"
                    value="{{ old('email') }}">

                @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-full py-3 bg-primary text-white font-semibold rounded-lg hover:bg-blue-700 transition-all">
                Kirim Link Reset Password
            </button>
        </form>

        <!-- KEMBALI LOGIN -->
        <div class="text-center mt-6">
            <a href="{{ route('login') }}" class="text-sm text-primary hover:underline">
                ← Kembali ke halaman login
            </a>
        </div>
    </div>

</body>
</html>
