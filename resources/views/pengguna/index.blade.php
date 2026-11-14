@extends('layouts.app')

@section('title', 'Manajemen Pengguna')
@section('page_title', 'Manajemen Akun Pengguna')

@section('content')
<!-- Breadcrumb Start -->
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h2 class="text-title-md2 font-semibold text-gray-800 dark:text-white/90">
            Manajemen Akun Pengguna
        </h2>
        <p class="mt-1 text-theme-xs text-gray-500 dark:text-gray-400">
            Pengelolaan hak akses sistem SIPANDU RT 03 untuk Admin, Ketua RT, dan Bendahara
        </p>
    </div>

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
            <li class="text-sm font-medium text-gray-800 dark:text-white/90">Manajemen Pengguna</li>
        </ol>
    </nav>
</div>
<!-- Breadcrumb End -->

<!-- TailAdmin Data Table Card Start -->
<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3">
    <!-- Card Header with Integrated Search, Filter & Action Button -->
    <div class="flex flex-col gap-4 border-b border-gray-100 px-5 py-4 sm:px-6 sm:py-5 lg:flex-row lg:items-center lg:justify-between dark:border-gray-800">
        <div class="flex items-center gap-3">
            <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">
                Daftar Akun Pengguna
            </h3>
            <span class="inline-flex items-center rounded-full bg-brand-50 px-2.5 py-0.5 text-theme-xs font-medium text-brand-500 dark:bg-brand-500/15 dark:text-brand-400">
                {{ $users->total() }} Akun
            </span>
        </div>

        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
            <!-- Search & Role Filter Form -->
            <form method="GET" action="{{ route('pengguna.index') }}" class="flex flex-col gap-2.5 sm:flex-row sm:items-center">
                <div class="relative">
                    <span class="pointer-events-none absolute top-1/2 left-3.5 -translate-y-1/2 text-gray-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </span>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama, username, email..."
                        class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:bg-gray-900 h-10 w-full sm:w-64 rounded-lg border border-gray-300 bg-transparent py-2 pr-4 pl-10 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30"
                    >
                </div>

                <div class="relative z-20 bg-transparent">
                    <select
                        name="role"
                        onchange="this.form.submit()"
                        class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:bg-gray-900 h-10 w-full sm:w-44 appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-3.5 py-2 pr-9 text-theme-xs font-medium text-gray-700 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-gray-300"
                    >
                        <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">Semua Hak Akses</option>
                        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }} class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">Administrator</option>
                        <option value="ketua_rt" {{ request('role') === 'ketua_rt' ? 'selected' : '' }} class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">Ketua RT</option>
                        <option value="bendahara" {{ request('role') === 'bendahara' ? 'selected' : '' }} class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">Bendahara</option>
                    </select>
                    <span class="pointer-events-none absolute top-1/2 right-3 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                        <svg class="stroke-current" width="16" height="16" viewBox="0 0 20 20" fill="none">
                            <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                </div>

                @if(request()->filled('search') || request()->filled('role'))
                <a
                    href="{{ route('pengguna.index') }}"
                    class="inline-flex h-10 items-center justify-center rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-theme-xs font-medium text-gray-600 hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 transition"
                >
                    Reset
                </a>
                @endif
            </form>

            <a
                href="{{ route('pengguna.create') }}"
                class="inline-flex h-10 items-center justify-center gap-2 rounded-lg bg-brand-500 px-4 py-2 text-theme-xs font-medium text-white shadow-theme-xs hover:bg-brand-600 transition"
            >
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Pengguna
            </a>
        </div>
    </div>

    <!-- Table Body -->
    <div class="max-w-full overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr class="border-b border-gray-100 dark:border-gray-800">
                    <th class="px-5 py-3 sm:px-6 text-left">
                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Nama Pengguna</p>
                    </th>
                    <th class="px-5 py-3 sm:px-6 text-left">
                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Username</p>
                    </th>
                    <th class="px-5 py-3 sm:px-6 text-left">
                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">No. HP / WhatsApp</p>
                    </th>
                    <th class="px-5 py-3 sm:px-6 text-left">
                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Hak Akses (Role)</p>
                    </th>
                    <th class="px-5 py-3 sm:px-6 text-left">
                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Status</p>
                    </th>
                    <th class="px-5 py-3 sm:px-6 text-right">
                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400"></p>
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50/60 dark:hover:bg-white/[0.02] transition">
                    <td class="px-5 py-4 sm:px-6">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-brand-50 text-theme-xs font-bold text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>
                            <div>
                                <span class="block font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                    {{ $user->name }}
                                </span>
                                <span class="block text-gray-500 text-theme-xs dark:text-gray-400">
                                    {{ $user->email }}
                                </span>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-4 sm:px-6">
                        <span class="font-mono text-theme-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ '@' . $user->username }}
                        </span>
                    </td>
                    <td class="px-5 py-4 sm:px-6">
                        <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                            {{ $user->no_hp ?? '-' }}
                        </p>
                    </td>
                    <td class="px-5 py-4 sm:px-6">
                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-theme-xs font-medium
                            @if($user->role === 'admin') bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400
                            @elseif($user->role === 'ketua_rt') bg-warning-50 text-warning-600 dark:bg-warning-500/15 dark:text-warning-400
                            @else bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-500 @endif">
                            {{ $user->role_label }}
                        </span>
                    </td>
                    <td class="px-5 py-4 sm:px-6">
                        @if($user->is_active)
                            <span class="inline-flex items-center rounded-full bg-success-50 px-2.5 py-0.5 text-theme-xs font-medium text-success-600 dark:bg-success-500/15 dark:text-success-500">
                                Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center rounded-full bg-error-50 px-2.5 py-0.5 text-theme-xs font-medium text-error-600 dark:bg-error-500/15 dark:text-error-500">
                                Nonaktif
                            </span>
                        @endif
                    </td>
                    <td class="px-5 py-4 sm:px-6 text-right">
                        <div class="relative inline-block text-left" x-data="{ open: false }">
                            <button
                                type="button"
                                @click="open = !open"
                                @click.outside="open = false"
                                class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-gray-400 hover:bg-gray-100 hover:text-gray-700 dark:hover:bg-white/5 dark:hover:text-gray-200 transition cursor-pointer"
                            >
                                <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                                    <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"/>
                                </svg>
                            </button>

                            <div
                                x-show="open"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-cloak
                                class="absolute right-0 z-30 mt-1 w-44 origin-top-right rounded-xl border border-gray-200 bg-white p-1.5 shadow-theme-lg dark:border-gray-800 dark:bg-gray-900"
                            >
                                <a
                                    href="{{ route('pengguna.edit', $user->id) }}"
                                    class="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-left text-theme-xs font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5"
                                >
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Ubah Pengguna
                                </a>

                                @if($user->id !== auth()->id())
                                <form method="POST" action="{{ route('pengguna.destroy', $user->id) }}" onsubmit="return confirm('Hapus pengguna {{ $user->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-left text-theme-xs font-medium text-error-600 hover:bg-error-50 dark:text-error-400 dark:hover:bg-error-500/10 cursor-pointer"
                                    >
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Hapus Pengguna
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-theme-sm text-gray-400">
                        Belum ada data pengguna yang sesuai pencarian.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Footer -->
    @if($users->hasPages())
    <div class="border-t border-gray-100 px-5 py-4 sm:px-6 dark:border-gray-800">
        {{ $users->links() }}
    </div>
    @endif
</div>
<!-- TailAdmin Data Table Card End -->
@endsection
