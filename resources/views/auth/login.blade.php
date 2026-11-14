<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk | SIPANDU RT 03 - Kedaung</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        (function() {
            var isDark = localStorage.getItem('darkMode') === 'true';
            if (isDark) {
                document.documentElement.classList.add('dark');
                document.documentElement.setAttribute('data-color-scheme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                document.documentElement.setAttribute('data-color-scheme', 'light');
            }
        })();
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body
    x-data="{
        darkMode: localStorage.getItem('darkMode') === 'true',
        showPassword: false,
        toggleDarkMode() {
            this.darkMode = !this.darkMode;
            localStorage.setItem('darkMode', JSON.stringify(this.darkMode));
            if (this.darkMode) {
                document.documentElement.classList.add('dark');
                document.documentElement.setAttribute('data-color-scheme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                document.documentElement.setAttribute('data-color-scheme', 'light');
            }
        },
        fillAccount(login, password) {
            document.getElementById('login').value = login;
            document.getElementById('password').value = password;
        }
    }"
    :class="{ 'dark bg-gray-900': darkMode }"
    class="font-outfit antialiased bg-white dark:bg-gray-900"
>
    <div class="relative z-1 bg-white p-6 sm:p-0 dark:bg-gray-900">
        <div class="relative flex min-h-screen w-full flex-col justify-center sm:p-0 lg:flex-row dark:bg-gray-900">
            <!-- Left Form Section (TailAdmin Signin Form Pattern) -->
            <div class="flex w-full flex-1 flex-col lg:w-1/2">
                <div class="mx-auto flex w-full max-w-md flex-1 flex-col justify-center py-10">
                    <div>
                        <div class="mb-5 sm:mb-8">
                            <div class="mb-3 inline-flex items-center gap-2.5 rounded-full bg-brand-50 px-3 py-1 text-theme-xs font-medium text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
                                <span>SIPANDU RT 03 &bull; Kelurahan Kedaung</span>
                            </div>
                            <h1 class="mb-2 text-title-sm font-semibold text-gray-800 sm:text-title-md dark:text-white/90">
                                Masuk ke Sistem
                            </h1>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Masukkan username atau email dan kata sandi Anda untuk mengakses dasbor kependudukan!
                            </p>
                        </div>

                        @if ($errors->any())
                        <div class="mb-5 rounded-xl border border-error-500 bg-error-50 p-4 dark:border-error-500/30 dark:bg-error-500/15">
                            <ul class="list-disc pl-4 text-xs text-error-600 dark:text-error-400 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="space-y-5">
                                <!-- Username / Email -->
                                <div>
                                    <label for="login" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Username atau Email <span class="text-error-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        id="login"
                                        name="login"
                                        value="{{ old('login') }}"
                                        required
                                        autofocus
                                        placeholder="Contoh: ketua_rt atau admin"
                                        class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:bg-gray-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30"
                                    />
                                </div>

                                <!-- Password -->
                                <div>
                                    <label for="password" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Kata Sandi <span class="text-error-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input
                                            :type="showPassword ? 'text' : 'password'"
                                            id="password"
                                            name="password"
                                            required
                                            placeholder="Masukkan kata sandi"
                                            class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:bg-gray-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pr-11 pl-4 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30"
                                        />
                                        <span
                                            @click="showPassword = !showPassword"
                                            class="absolute top-1/2 right-4 z-30 -translate-y-1/2 cursor-pointer text-gray-500 dark:text-gray-400"
                                        >
                                            <svg x-show="!showPassword" class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M10 4.16666C5.83333 4.16666 2.275 6.73332 0.833336 10.4167C2.275 14.1 5.83333 16.6667 10 16.6667C14.1667 16.6667 17.725 14.1 19.1667 10.4167C17.725 6.73332 14.1667 4.16666 10 4.16666ZM10 14.5833C7.7 14.5833 5.83333 12.7167 5.83333 10.4167C5.83333 8.11666 7.7 6.24999 10 6.24999C12.3 6.24999 14.1667 8.11666 14.1667 10.4167C14.1667 12.7167 12.3 14.5833 10 14.5833ZM10 7.91666C8.61667 7.91666 7.5 9.03332 7.5 10.4167C7.5 11.8 8.61667 12.9167 10 12.9167C11.3833 12.9167 12.5 11.8 12.5 10.4167C12.5 9.03332 11.3833 7.91666 10 7.91666Z" />
                                            </svg>
                                            <svg x-show="showPassword" x-cloak class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M3.08885 2.02827C2.79595 1.73538 2.32108 1.73538 2.02819 2.02827C1.73529 2.32117 1.73529 2.79604 2.02819 3.08893L4.16863 5.22938C2.66006 6.45399 1.49915 8.11495 0.833336 10.4167C2.275 14.1 5.83333 16.6667 10 16.6667C11.8421 16.6667 13.5624 16.1642 15.0286 15.2918L16.9112 17.1745C17.2041 17.4674 17.679 17.4674 17.9719 17.1745C18.2648 16.8816 18.2648 16.4067 17.9719 16.1138L3.08885 2.02827ZM10 14.5833C7.7 14.5833 5.83333 12.7167 5.83333 10.4167C5.83333 9.35473 6.23071 8.38547 6.88424 7.64998L12.7667 13.5324C12.0312 14.186 11.062 14.5833 10 14.5833ZM10 4.16666C8.55422 4.16666 7.18597 4.47676 5.95999 5.03324L7.48418 6.55743C8.23451 6.35714 9.09986 6.24999 10 6.24999C12.3 6.24999 14.1667 8.11666 14.1667 10.4167C14.1667 11.3168 14.0595 12.1822 13.8592 12.9325L16.1228 15.1961C17.4803 14.0176 18.5453 12.3937 19.1667 10.4167C17.725 6.73332 14.1667 4.16666 10 4.16666Z" />
                                            </svg>
                                        </span>
                                    </div>
                                </div>

                                <!-- Checkbox -->
                                <div class="flex items-center justify-between">
                                    <label class="flex cursor-pointer items-center text-sm font-normal text-gray-700 select-none dark:text-gray-400">
                                        <input
                                            type="checkbox"
                                            name="remember"
                                            class="mr-2.5 h-4 w-4 rounded border-gray-300 text-brand-500 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900"
                                        />
                                        Tetap masuk (Ingat Saya)
                                    </label>
                                </div>

                                <!-- Button -->
                                <div>
                                    <button
                                        type="submit"
                                        class="bg-brand-500 shadow-theme-xs hover:bg-brand-600 flex w-full items-center justify-center rounded-lg px-4 py-3 text-sm font-medium text-white transition cursor-pointer"
                                    >
                                        Masuk ke Sistem
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- Quick Access / Demo Buttons -->
                        <div class="mt-7 border-t border-gray-100 pt-6 dark:border-gray-800">
                            <p class="mb-3 text-center text-theme-xs font-medium text-gray-500 dark:text-gray-400">
                                Akses Cepat Pengujian (1-Klik Isi Otomatis)
                            </p>
                            <div class="grid grid-cols-3 gap-2.5">
                                <button
                                    type="button"
                                    @click="fillAccount('admin', 'password')"
                                    class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-center text-theme-xs font-medium text-gray-700 shadow-theme-xs hover:border-brand-300 hover:bg-brand-50 hover:text-brand-600 dark:border-gray-800 dark:bg-white/3 dark:text-gray-300 dark:hover:border-brand-500/40 dark:hover:text-brand-400 transition cursor-pointer"
                                >
                                    <span class="block font-semibold">Admin</span>
                                    <span class="text-[10px] text-gray-400">admin</span>
                                </button>
                                <button
                                    type="button"
                                    @click="fillAccount('ketua_rt', 'password')"
                                    class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-center text-theme-xs font-medium text-gray-700 shadow-theme-xs hover:border-brand-300 hover:bg-brand-50 hover:text-brand-600 dark:border-gray-800 dark:bg-white/3 dark:text-gray-300 dark:hover:border-brand-500/40 dark:hover:text-brand-400 transition cursor-pointer"
                                >
                                    <span class="block font-semibold">Ketua RT</span>
                                    <span class="text-[10px] text-gray-400">ketua_rt</span>
                                </button>
                                <button
                                    type="button"
                                    @click="fillAccount('bendahara', 'password')"
                                    class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-center text-theme-xs font-medium text-gray-700 shadow-theme-xs hover:border-brand-300 hover:bg-brand-50 hover:text-brand-600 dark:border-gray-800 dark:bg-white/3 dark:text-gray-300 dark:hover:border-brand-500/40 dark:hover:text-brand-400 transition cursor-pointer"
                                >
                                    <span class="block font-semibold">Bendahara</span>
                                    <span class="text-[10px] text-gray-400">bendahara</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Branded Panel (TailAdmin Signin Cover Pattern) -->
            <div class="bg-brand-950 relative hidden h-full min-h-screen w-full items-center lg:grid lg:w-1/2 dark:bg-white/5">
                <div class="z-1 flex items-center justify-center p-10">
                    <div class="flex max-w-md flex-col items-center text-center">
                        <div class="mb-5 flex h-16 w-16 items-center justify-center rounded-2xl bg-brand-500 text-white shadow-theme-lg">
                            <svg class="h-9 w-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <h2 class="mb-2 text-2xl font-bold text-white">
                            SIPANDU RT 03 KEDAUNG
                        </h2>
                        <p class="text-sm text-gray-300/80 leading-relaxed">
                            Sistem Informasi Pemetaan dan Administrasi Data Kependudukan RT 03 Kelurahan Kedaung terintegrasi dengan Algoritma K-Means Clustering &amp; Manajemen Ronda Malam.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Dark Mode Toggler -->
            <div class="fixed right-6 bottom-6 z-50">
                <button
                    type="button"
                    @click="toggleDarkMode()"
                    class="bg-brand-500 hover:bg-brand-600 inline-flex size-12 items-center justify-center rounded-full text-white shadow-theme-lg transition-colors cursor-pointer"
                    title="Ganti Tema Terang/Gelap"
                >
                    <svg x-show="darkMode" class="fill-current" width="20" height="20" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.99998 3.5415C10.4142 3.5415 10.75 3.20572 10.75 2.7915V2.0415C10.75 1.62729 10.4142 1.2915 9.99998 1.2915C9.58577 1.2915 9.24998 1.62729 9.24998 2.0415V2.7915C9.24998 3.20572 9.58577 3.5415 9.99998 3.5415ZM10 13.7498C12.0711 13.7498 13.75 12.0709 13.75 9.99984C13.75 7.92877 12.0711 6.24984 10 6.24984C7.92893 6.24984 6.25 7.92877 6.25 9.99984C6.25 12.0709 7.92893 13.7498 10 13.7498Z"/>
                    </svg>
                    <svg x-show="!darkMode" class="fill-current" width="20" height="20" viewBox="0 0 20 20">
                        <path d="M17.4547 11.97L18.1799 12.1611C18.265 11.8383 18.1265 11.4982 17.8409 11.3266C17.5553 11.1551 17.1885 11.1934 16.944 11.4207L17.4547 11.97ZM8.0306 2.5459L8.57989 3.05657C8.80718 2.81209 8.84554 2.4453 8.67398 2.15972C8.50243 1.87415 8.16227 1.73559 7.83948 1.82066L8.0306 2.5459ZM12.9154 13.0035C9.64678 13.0035 6.99707 10.3538 6.99707 7.08524H5.49707C5.49707 11.1823 8.81835 14.5035 12.9154 14.5035V13.0035ZM16.944 11.4207C15.8869 12.4035 14.4721 13.0035 12.9154 13.0035V14.5035C14.8657 14.5035 16.6418 13.7499 17.9654 12.5193L16.944 11.4207ZM16.7295 11.7789C15.9437 14.7607 13.2277 16.9586 10.0003 16.9586V18.4586C13.9257 18.4586 17.2249 15.7853 18.1799 12.1611L16.7295 11.7789ZM10.0003 16.9586C6.15734 16.9586 3.04199 13.8433 3.04199 10.0003H1.54199C1.54199 14.6717 5.32892 18.4586 10.0003 18.4586V16.9586ZM3.04199 10.0003C3.04199 6.77289 5.23988 4.05695 8.22173 3.27114L7.83948 1.82066C4.21532 2.77574 1.54199 6.07496 1.54199 10.0003H3.04199ZM6.99707 7.08524C6.99707 5.52854 7.5971 4.11366 8.57989 3.05657L7.48132 2.03522C6.25073 3.35885 5.49707 5.13487 5.49707 7.08524H6.99707Z"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</body>
</html>
