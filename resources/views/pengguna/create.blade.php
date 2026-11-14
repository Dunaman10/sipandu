@extends('layouts.app')

@section('title', 'Tambah Pengguna Baru')
@section('page_title', 'Tambah Pengguna Baru')

@section('content')
<!-- Breadcrumb Start -->
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="text-title-md2 font-semibold text-gray-800 dark:text-white/90">
        Tambah Pengguna Baru
    </h2>

    <nav>
        <ol class="flex items-center gap-1.5">
            <li>
                <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400 hover:text-brand-500" href="{{ route('dashboard') }}">
                    Beranda
                    <svg class="stroke-current" width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366" stroke="" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
            </li>
            <li>
                <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400 hover:text-brand-500" href="{{ route('pengguna.index') }}">
                    Manajemen Pengguna
                    <svg class="stroke-current" width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366" stroke="" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
            </li>
            <li class="text-sm font-medium text-gray-800 dark:text-white/90">Tambah Pengguna</li>
        </ol>
    </nav>
</div>
<!-- Breadcrumb End -->

<div class="mx-auto max-w-3xl space-y-6">
    @if($errors->any())
    <div class="rounded-xl border border-error-500 bg-error-50 p-4 dark:border-error-500/30 dark:bg-error-500/15">
        <div class="flex items-start gap-3">
            <div class="-mt-0.5 text-error-500">
                <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 3.75C7.44365 3.75 3.75 7.44365 3.75 12C3.75 16.5563 7.44365 20.25 12 20.25C16.5563 20.25 20.25 16.5563 20.25 12C20.25 7.44365 16.5563 3.75 12 3.75ZM2.25 12C2.25 6.61522 6.61522 2.25 12 2.25C17.3848 2.25 21.75 6.61522 21.75 12C21.75 17.3848 17.3848 21.75 12 21.75C6.61522 21.75 2.25 17.3848 2.25 12ZM13 16C13 16.5523 12.5523 17 12 17C11.4477 17 11 16.5523 11 16C11 15.4477 11.4477 15 12 15C12.5523 15 13 15.4477 13 16ZM11.25 8C11.25 7.58579 11.5858 7.25 12 7.25C12.4142 7.25 12.75 7.58579 12.75 8V12.5C12.75 12.9142 12.4142 13.25 12 13.25C11.5858 13.25 11.25 12.9142 11.25 12.5V8Z" />
                </svg>
            </div>
            <div>
                <h4 class="mb-1 text-sm font-semibold text-gray-800 dark:text-white/90">Terdapat kesalahan pada input formulir:</h4>
                <ul class="list-disc pl-4 text-xs text-gray-600 dark:text-gray-300 space-y-1">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3">
        <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4 sm:px-6 sm:py-5 dark:border-gray-800">
            <div>
                <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                    Formulir Akun Pengguna Baru
                </h3>
                <p class="mt-0.5 text-theme-xs text-gray-500 dark:text-gray-400">
                    Buat akun baru untuk Administrator, Ketua RT, atau Bendahara
                </p>
            </div>
            <a
                href="{{ route('pengguna.index') }}"
                class="inline-flex items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-3.5 py-2 text-theme-xs font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/3 transition"
            >
                &larr; Kembali
            </a>
        </div>

        <form method="POST" action="{{ route('pengguna.store') }}" class="p-5 sm:p-6 space-y-6">
            @csrf

            <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Nama Lengkap &amp; Gelar <span class="text-error-500">*</span>
                </label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    placeholder="Contoh: H. Bambang Sutrisno (Ketua RT 03)"
                    class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:bg-gray-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30"
                >
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Username Login <span class="text-error-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="username"
                        value="{{ old('username') }}"
                        required
                        placeholder="Contoh: ketuart03"
                        class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:bg-gray-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30"
                    >
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Alamat Email <span class="text-error-500">*</span>
                    </label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        placeholder="email@sipandu.test"
                        class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:bg-gray-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30"
                    >
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div x-data="{ showPassword: false }">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Kata Sandi (Password) <span class="text-error-500">*</span>
                    </label>
                    <div class="relative">
                        <input
                            :type="showPassword ? 'text' : 'password'"
                            name="password"
                            required
                            placeholder="Minimal 6 karakter"
                            class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:bg-gray-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pr-11 pl-4 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30"
                        >
                        <button
                            type="button"
                            @click="showPassword = !showPassword"
                            class="absolute top-1/2 right-3.5 -translate-y-1/2 text-gray-500 dark:text-gray-400 cursor-pointer"
                        >
                            <svg x-show="!showPassword" class="fill-current" width="20" height="20" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M10 4.16666C5.83333 4.16666 2.275 6.73332 0.833336 10.4167C2.275 14.1 5.83333 16.6667 10 16.6667C14.1667 16.6667 17.725 14.1 19.1667 10.4167C17.725 6.73332 14.1667 4.16666 10 4.16666ZM10 14.5833C7.7 14.5833 5.83333 12.7167 5.83333 10.4167C5.83333 8.11666 7.7 6.24999 10 6.24999C12.3 6.24999 14.1667 8.11666 14.1667 10.4167C14.1667 12.7167 12.3 14.5833 10 14.5833ZM10 7.91666C8.61667 7.91666 7.5 9.03332 7.5 10.4167C7.5 11.8 8.61667 12.9167 10 12.9167C11.3833 12.9167 12.5 11.8 12.5 10.4167C12.5 9.03332 11.3833 7.91666 10 7.91666Z"/>
                            </svg>
                            <svg x-show="showPassword" x-cloak class="fill-current" width="20" height="20" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M3.08885 2.02827C2.79595 1.73538 2.32108 1.73538 2.02819 2.02827C1.73529 2.32117 1.73529 2.79604 2.02819 3.08893L4.16863 5.22938C2.66006 6.45399 1.49915 8.11495 0.833336 10.4167C2.275 14.1 5.83333 16.6667 10 16.6667C11.8421 16.6667 13.5624 16.1642 15.0286 15.2918L16.9112 17.1745C17.2041 17.4674 17.679 17.4674 17.9719 17.1745C18.2648 16.8816 18.2648 16.4067 17.9719 16.1138L3.08885 2.02827ZM10 14.5833C7.7 14.5833 5.83333 12.7167 5.83333 10.4167C5.83333 9.35473 6.23071 8.38547 6.88424 7.64998L12.7667 13.5324C12.0312 14.186 11.062 14.5833 10 14.5833ZM10 4.16666C8.55422 4.16666 7.18597 4.47676 5.95999 5.03324L7.48418 6.55743C8.23451 6.35714 9.09986 6.24999 10 6.24999C12.3 6.24999 14.1667 8.11666 14.1667 10.4167C14.1667 11.3168 14.0595 12.1822 13.8592 12.9325L16.1228 15.1961C17.4803 14.0176 18.5453 12.3937 19.1667 10.4167C17.725 6.73332 14.1667 4.16666 10 4.16666Z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Nomor WhatsApp / HP
                    </label>
                    <input
                        type="text"
                        name="no_hp"
                        value="{{ old('no_hp') }}"
                        placeholder="08xxxxxxxxxx"
                        class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:bg-gray-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30"
                    >
                </div>
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Peran / Hak Akses (Role) <span class="text-error-500">*</span>
                </label>
                <div class="relative z-20 bg-transparent">
                    <select
                        name="role"
                        required
                        class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:bg-gray-900 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-white/90"
                    >
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }} class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">Administrator (Kelola User &amp; Konfigurasi Sistem)</option>
                        <option value="ketua_rt" {{ old('role') === 'ketua_rt' ? 'selected' : '' }} class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">Ketua RT (Data Warga, K-Means Clustering, Ronda Malam)</option>
                        <option value="bendahara" {{ old('role') === 'bendahara' ? 'selected' : '' }} class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">Bendahara (Lihat Data Warga &amp; Cetak Laporan)</option>
                    </select>
                    <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                        <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                </div>
            </div>

            <div>
                <label class="flex cursor-pointer items-center gap-3 select-none">
                    <input
                        type="checkbox"
                        name="is_active"
                        value="1"
                        {{ old('is_active', true) ? 'checked' : '' }}
                        class="h-5 w-5 rounded-md border-gray-300 text-brand-500 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900"
                    >
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-400">
                        Aktifkan akun pengguna ini agar dapat langsung masuk ke sistem
                    </span>
                </label>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-800">
                <a
                    href="{{ route('pengguna.index') }}"
                    class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/3 transition"
                >
                    Batal
                </a>
                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600 transition cursor-pointer"
                >
                    Simpan Pengguna
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
