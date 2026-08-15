<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menunggu Persetujuan Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-stone-50 flex items-center justify-center min-h-screen p-4">
    <div class="max-w-[28rem] w-full bg-white rounded-2xl shadow-xl p-8 text-center border border-stone-200">
        <!-- Icon section -->
        <div class="w-24 h-24 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-12 h-12 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        
        <!-- Text content -->
        <h1 class="text-2xl font-bold text-stone-800 mb-3">Pendaftaran Berhasil!</h1>
        <p class="text-stone-600 mb-8 leading-relaxed">
            Akun Anda saat ini sedang <span class="font-semibold text-amber-600">menunggu persetujuan</span> dari Superadmin. Anda baru dapat mengakses dasbor setelah akun Anda diaktifkan.
        </p>

        <!-- Logout button (Sign In logic) -->
        <form action="{{ route('custom.logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full bg-[#8C5A35] hover:bg-[#70482a] text-white font-medium py-3 px-4 rounded-xl transition-all duration-200 shadow-lg shadow-[#8C5A35]/30 flex justify-center items-center gap-2 transform hover:scale-[1.02]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                </svg>
                Kembali ke Halaman Login
            </button>
        </form>
    </div>
</body>
</html>
