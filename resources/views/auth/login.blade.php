<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Portal - Seleksi OSIS SMK Hijau Muda</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="h-full bg-slate-50 text-slate-800 antialiased flex items-center justify-center p-6 selection:bg-emerald-600 selection:text-white">

    <!-- Background Glow Effect -->
    <div class="absolute inset-0 -z-10 overflow-hidden">
        <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-emerald-100/60 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <div class="w-full max-w-md">
        
        <!-- Card Login Utama -->
        <div class="bg-white p-8 md:p-10 rounded-3xl shadow-xl shadow-slate-200/60 border border-slate-200/80 space-y-6">
            
            <!-- Logo & Header -->
            <div class="text-center space-y-3">
                <div class="inline-flex justify-center mb-1">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo SMK Hijau Muda" class="h-14 w-auto object-contain">
                </div>
                <div>
                    <h1 class="text-xl font-black text-slate-900 tracking-tight">PORTAL SELEKSI OSIS</h1>
                    <p class="text-xs font-bold text-emerald-600 uppercase tracking-wider mt-0.5">SMK Hijau Muda</p>
                </div>
                <p class="text-xs text-slate-500 font-medium pt-1">Masukkan kredensial akun Anda untuk mengakses sistem ujian CAT.</p>
            </div>

            <!-- Error Notification -->
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 p-4 rounded-2xl text-xs font-semibold flex items-center space-x-3 shadow-xs">
                    <span>⚠️</span>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <!-- Form Login -->
            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf
                
                <div>
                    <label class="block text-slate-700 text-xs font-extrabold uppercase tracking-wider mb-2">Username / NIS</label>
                    <input type="text" name="username" value="{{ old('username') }}" placeholder="Contoh: 20261001" class="w-full px-4 py-3.5 border border-slate-300 rounded-2xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600 bg-slate-50/50 transition" required>
                </div>

                <div>
                    <label class="block text-slate-700 text-xs font-extrabold uppercase tracking-wider mb-2">Password</label>
                    <input type="password" name="password" placeholder="••••••••" class="w-full px-4 py-3.5 border border-slate-300 rounded-2xl text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600 bg-slate-50/50 transition" required>
                </div>

                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold py-4 px-4 rounded-2xl text-sm transition duration-200 shadow-lg shadow-emerald-600/25 flex items-center justify-center space-x-2 mt-2">
                    <span>Masuk ke Sistem</span>
                    <span>🚀</span>
                </button>
            </form>

        </div>

        <!-- Footer / Bantuan Kecil -->
        <div class="text-center mt-6 space-y-2">
            <p class="text-xs text-slate-400 font-medium">
                Mengalami kendala login? Hubungi panitia seleksi OSIS.
            </p>
            <p class="text-[11px] text-slate-400 font-semibold">
                Developed by <a href="https://web-portofolio-me.netlify.app" target="_blank" class="text-emerald-600 hover:underline">Muhammad Andika Anjas Syaputra, S.Kom.</a>
            </p>
        </div>

    </div>

</body>
</html>