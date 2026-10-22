@extends('layouts.app')

@section('title', 'Manajemen Pengguna')
@section('page_title', 'Manajemen Akun Pengguna')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-gray-900 dark:text-white">Manajemen Akun Pengguna</h2>
            <p class="text-xs text-gray-500 dark:text-gray-400">Pengelolaan hak akses sistem SIPANDU RT 03 untuk Admin, Ketua RT, dan Bendahara</p>
        </div>

        <a
            href="{{ route('pengguna.create') }}"
            class="inline-flex items-center gap-2 rounded-xl bg-brand-500 px-4 py-2.5 text-xs font-bold text-white shadow-md shadow-brand-500/25 hover:bg-brand-600 transition"
        >
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            + Tambah Pengguna Baru
        </a>
    </div>

    <div class="rounded-3xl border border-gray-200/80 bg-white shadow-xs dark:border-gray-800 dark:bg-gray-900 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="border-b border-gray-200 bg-gray-50/70 text-gray-500 dark:border-gray-800 dark:bg-gray-800/50 uppercase tracking-wider font-semibold">
                    <tr>
                        <th class="py-3.5 px-4">No</th>
                        <th class="py-3.5 px-4">Nama Lengkap</th>
                        <th class="py-3.5 px-4">Username</th>
                        <th class="py-3.5 px-4">Email</th>
                        <th class="py-3.5 px-4">No. HP / WhatsApp</th>
                        <th class="py-3.5 px-4">Hak Akses (Role)</th>
                        <th class="py-3.5 px-4">Status Akun</th>
                        <th class="py-3.5 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-gray-700 dark:text-gray-300">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50/70 dark:hover:bg-gray-800/40 transition">
                        <td class="py-3.5 px-4 text-gray-400 font-medium">{{ $loop->iteration }}</td>
                        <td class="py-3.5 px-4 font-bold text-gray-900 dark:text-white">{{ $user->name }}</td>
                        <td class="py-3.5 px-4 font-mono font-semibold text-brand-600 dark:text-brand-400">{{ $user->username }}</td>
                        <td class="py-3.5 px-4 text-gray-500">{{ $user->email }}</td>
                        <td class="py-3.5 px-4 text-gray-600 dark:text-gray-400">{{ $user->no_hp ?? '-' }}</td>
                        <td class="py-3.5 px-4">
                            <span class="rounded-md px-2.5 py-1 text-[10px] font-bold
                                @if($user->role === 'admin') bg-purple-100 text-purple-800 dark:bg-purple-950/70 dark:text-purple-300
                                @elseif($user->role === 'ketua_rt') bg-brand-100 text-brand-800 dark:bg-brand-950/70 dark:text-brand-300
                                @else bg-emerald-100 text-emerald-800 dark:bg-emerald-950/70 dark:text-emerald-300 @endif">
                                {{ $user->role_label }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4">
                            @if($user->is_active)
                                <span class="rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-bold text-emerald-800 dark:bg-emerald-950/70 dark:text-emerald-300">&check; Aktif</span>
                            @else
                                <span class="rounded-full bg-rose-100 px-2 py-0.5 text-[10px] font-bold text-rose-800 dark:bg-rose-950/70 dark:text-rose-300">Nonaktif</span>
                            @endif
                        </td>
                        <td class="py-3.5 px-4 text-center">
                            <div class="flex items-center justify-center gap-1.5">
                                <a href="{{ route('pengguna.edit', $user->id) }}" class="p-1 text-gray-400 hover:text-amber-600" title="Ubah Pengguna">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                @if($user->id !== auth()->id())
                                <form method="POST" action="{{ route('pengguna.destroy', $user->id) }}" onsubmit="return confirm('Hapus pengguna ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1 text-gray-400 hover:text-rose-600" title="Hapus Pengguna">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="py-8 text-center text-gray-400">Belum ada pengguna.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
