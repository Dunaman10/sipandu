<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk | SIPANDU RT 03 - Kedaung</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body
    x-data="{
        darkMode: localStorage.getItem('darkMode') === 'true',
        fillAccount(login, password) {
            document.getElementById('login').value = login;
            document.getElementById('password').value = password;
        }
    }"
    :class="{ 'dark bg-gray-950 text-gray-100': darkMode, 'bg-gray-50 text-gray-800': !darkMode }"
    class="font-outfit antialiased min-h-screen flex items-center justify-center p-4 sm:p-6"
>
    <div class="w-full max-w-md">
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <div class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-tr from-brand-600 to-brand-400 text-white shadow-xl shadow-brand-500/25 mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">
                SIPANDU RT 03
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">
                Sistem Informasi Pemetaan dan Administrasi Data Kependudukan RT 03 Kelurahan Kedaung
            </p>
        </div>

        <!-- Login Card -->
        <div class="rounded-3xl border border-gray-200/80 bg-white p-6 sm:p-8 shadow-xl shadow-gray-200/50 dark:border-gray-800 dark:bg-gray-900 dark:shadow-none">
            <div class="mb-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">Selamat Datang</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400">Silakan masukkan username/email dan password Anda</p>
            </div>

            @if ($errors->any())
            <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-3.5 text-xs text-red-700 dark:border-red-900/60 dark:bg-red-950/40 dark:text-red-300">
                <ul class="list-disc pl-4 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="login" class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                        Username atau Email
                    </label>
                    <input
                        type="text"
                        name="login"
                        id="login"
                        value="{{ old('login') }}"
                        required
                        autofocus
                        placeholder="Contoh: ketua_rt atau admin"
                        class="w-full rounded-xl border border-gray-300 bg-white px-3.5 py-2.5 text-sm text-gray-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/20 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
                    >
                </div>

                <div>
                    <label for="password" class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                        Kata Sandi
                    </label>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        required
                        placeholder="••••••••"
                        class="w-full rounded-xl border border-gray-300 bg-white px-3.5 py-2.5 text-sm text-gray-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/20 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
                    >
                </div>

                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input
                            type="checkbox"
                            name="remember"
                            class="h-4 w-4 rounded border-gray-300 text-brand-600 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800"
                        >
                        <span class="text-xs text-gray-600 dark:text-gray-400">Ingat Saya</span>
                    </label>
                </div>

                <button
                    type="submit"
                    class="w-full rounded-xl bg-brand-500 py-3 text-sm font-semibold text-white shadow-md shadow-brand-500/30 hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-brand-500/50 transition duration-200"
                >
                    Masuk ke Sistem
                </button>
            </form>

            <!-- Quick Access / Demo Buttons -->
            <div class="mt-8 pt-6 border-t border-gray-100 dark:border-gray-800">
                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-center mb-3">
                    Akses Cepat Pengujian (1-Klik)
                </p>
                <div class="grid grid-cols-3 gap-2">
                    <button
                        type="button"
                        @click="fillAccount('admin', 'password')"
                        class="rounded-xl border border-gray-200 bg-gray-50/70 p-2 text-center text-xs font-medium text-gray-700 hover:bg-brand-50 hover:border-brand-300 hover:text-brand-600 dark:border-gray-800 dark:bg-gray-800/60 dark:text-gray-300 dark:hover:bg-brand-950/40 dark:hover:text-brand-300 transition"
                    >
                        <span class="block font-bold">Admin</span>
                        <span class="text-[10px] text-gray-400">admin</span>
                    </button>
                    <button
                        type="button"
                        @click="fillAccount('ketua_rt', 'password')"
                        class="rounded-xl border border-gray-200 bg-gray-50/70 p-2 text-center text-xs font-medium text-gray-700 hover:bg-brand-50 hover:border-brand-300 hover:text-brand-600 dark:border-gray-800 dark:bg-gray-800/60 dark:text-gray-300 dark:hover:bg-brand-950/40 dark:hover:text-brand-300 transition"
                    >
                        <span class="block font-bold">Ketua RT</span>
                        <span class="text-[10px] text-gray-400">ketua_rt</span>
                    </button>
                    <button
                        type="button"
                        @click="fillAccount('bendahara', 'password')"
                        class="rounded-xl border border-gray-200 bg-gray-50/70 p-2 text-center text-xs font-medium text-gray-700 hover:bg-brand-50 hover:border-brand-300 hover:text-brand-600 dark:border-gray-800 dark:bg-gray-800/60 dark:text-gray-300 dark:hover:bg-brand-950/40 dark:hover:text-brand-300 transition"
                    >
                        <span class="block font-bold">Bendahara</span>
                        <span class="text-[10px] text-gray-400">bendahara</span>
                    </button>
                </div>
            </div>
        </div>

        <p class="text-center text-xs text-gray-400 dark:text-gray-600 mt-6">
            &copy; {{ date('Y') }} SIPANDU RT 03 — Kelurahan Kedaung. Hak Cipta Dilindungi.
        </p>
    </div>
</body>
</html>
