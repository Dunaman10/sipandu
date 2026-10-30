@extends('layouts.app')

@section('title', 'Tambah Pengguna Baru')
@section('page_title', 'Tambah Pengguna Baru')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-extrabold text-gray-900 dark:text-white">Tambah Pengguna Baru</h2>
            <p class="text-xs text-gray-500 dark:text-gray-400">Buat akun untuk Admin, Ketua RT, atau Bendahara</p>
        </div>
        <a href="{{ route('pengguna.index') }}" class="rounded-xl border border-gray-300 px-3.5 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-100 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800 transition">
            &larr; Kembali
        </a>
    </div>

    @if($errors->any())
    <div class="rounded-2xl border border-red-200 bg-red-50 p-4 text-xs text-red-700 dark:border-red-900/60 dark:bg-red-950/40 dark:text-red-300">
        <ul class="list-disc pl-4 space-y-1">
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="rounded-3xl border border-gray-200/80 bg-white p-6 sm:p-8 shadow-xs dark:border-gray-800 dark:bg-gray-900">
        <form method="POST" action="{{ route('pengguna.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Nama Lengkap & Gelar <span class="text-red-500">*</span></label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    placeholder="Contoh: H. Bambang Sutrisno (Ketua RT 03)"
                    class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-xs text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
                >
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Username Login <span class="text-red-500">*</span></label>
                    <input
                        type="text"
                        name="username"
                        value="{{ old('username') }}"
                        required
                        placeholder="Contoh: ketuart03"
                        class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-xs text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
                    >
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Alamat Email <span class="text-red-500">*</span></label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        placeholder="email@sipandu.test"
                        class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-xs text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
                    >
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Kata Sandi (Password) <span class="text-red-500">*</span></label>
                    <input
                        type="password"
                        name="password"
                        required
                        placeholder="Minimal 6 karakter"
                        class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-xs text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
                    >
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Nomor WhatsApp / HP</label>
                    <input
                        type="text"
                        name="no_hp"
                        value="{{ old('no_hp') }}"
                        placeholder="08xxxxxxxxxx"
                        class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-xs text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
                    >
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Peran / Hak Akses (Role) <span class="text-red-500">*</span></label>
                <select
                    name="role"
                    required
                    class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-xs text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
                >
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrator (Kelola User & Konfigurasi Sistem)</option>
                    <option value="ketua_rt" {{ old('role') === 'ketua_rt' ? 'selected' : '' }}>Ketua RT (Data Warga, K-Means Clustering, Ronda Malam)</option>
                    <option value="bendahara" {{ old('role') === 'bendahara' ? 'selected' : '' }}>Bendahara (Lihat Data Warga & Cetak Laporan)</option>
                </select>
            </div>

            <div>
                <label class="flex items-center gap-2 cursor-pointer pt-2">
                    <input
                        type="checkbox"
                        name="is_active"
                        value="1"
                        {{ old('is_active', true) ? 'checked' : '' }}
                        class="h-4 w-4 rounded border-gray-300 text-brand-600 focus:ring-brand-500"
                    >
                    <span class="text-xs font-semibold text-gray-700 dark:text-gray-300">Akun Pengguna Aktif</span>
                </label>
            </div>

            <div class="flex items-center justify-end gap-2 pt-4 border-t border-gray-100 dark:border-gray-800">
                <a href="{{ route('pengguna.index') }}" class="rounded-xl border border-gray-300 px-4 py-2 text-xs font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-700 dark:text-gray-300">
                    Batal
                </a>
                <button type="submit" class="rounded-xl bg-brand-500 px-5 py-2 text-xs font-bold text-white hover:bg-brand-600">
                    Simpan Pengguna
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
