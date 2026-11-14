@extends('layouts.app')

@section('title', 'Data Master Warga')

@section('content')
<!-- Breadcrumb Start -->
<div class="flex flex-wrap items-center justify-between gap-3 pb-6">
    <div>
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Data Kependudukan Warga RT 03</h2>
        <p class="mt-0.5 text-theme-xs text-gray-500 dark:text-gray-400">
            Total terdata: <strong class="font-medium text-gray-700 dark:text-gray-200">{{ $wargas->total() }}</strong> warga di lingkungan RT 03 Kelurahan Kedaung
        </p>
    </div>
    <nav>
        <ol class="flex items-center gap-1.5">
            <li>
                <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" href="{{ route('dashboard') }}">
                    Dashboard
                    <svg class="stroke-current" width="17" height="16" viewBox="0 0 17 16" fill="none">
                        <path d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </li>
            <li class="text-sm text-gray-800 dark:text-white/90">Data Warga RT</li>
        </ol>
    </nav>
</div>
<!-- Breadcrumb End -->

<div class="space-y-5 sm:space-y-6">
    <!-- Data Table Card (Matching TailAdmin Template) -->
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3">
        <!-- Card Header: Title + Integrated Search, Filter & Action Toolbar -->
        <div class="flex flex-col gap-4 border-b border-gray-100 px-5 py-4 sm:px-6 sm:py-5 dark:border-gray-800">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                        Daftar Master Warga RT 03
                    </h3>
                    <p class="mt-0.5 text-theme-xs text-gray-500 dark:text-gray-400">
                        Kelola biodata warga, status KTP, dan indikator ekonomi keluarga
                    </p>
                </div>

                <!-- Export & Add Actions -->
                <div class="flex flex-wrap items-center gap-2.5">
                    <a
                        href="{{ route('warga.exportPdf', request()->all()) }}"
                        target="_blank"
                        class="text-theme-sm shadow-theme-xs inline-flex h-10 items-center gap-2 rounded-lg border border-gray-300 bg-white px-3.5 py-2 font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/3 dark:hover:text-gray-200"
                    >
                        <svg class="h-4 w-4 text-error-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        PDF
                    </a>

                    <a
                        href="{{ route('warga.exportExcel', request()->all()) }}"
                        class="text-theme-sm shadow-theme-xs inline-flex h-10 items-center gap-2 rounded-lg border border-gray-300 bg-white px-3.5 py-2 font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/3 dark:hover:text-gray-200"
                    >
                        <svg class="h-4 w-4 text-success-600 dark:text-success-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Excel
                    </a>

                    @if(auth()->user()->isAdmin() || auth()->user()->isKetuaRt())
                    <a
                        href="{{ route('warga.create') }}"
                        class="bg-brand-500 shadow-theme-xs hover:bg-brand-600 text-theme-sm inline-flex h-10 items-center gap-2 rounded-lg px-4 py-2 font-medium text-white transition"
                    >
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Warga
                    </a>
                    @endif
                </div>
            </div>

            <!-- Filter & Search Form Inside Card Header -->
            <form method="GET" action="{{ route('warga.index') }}" class="flex flex-col gap-3 pt-1 lg:flex-row lg:items-center lg:justify-between">
                <!-- Search Input -->
                <div class="relative flex-1 lg:max-w-md">
                    <span class="pointer-events-none absolute top-1/2 left-4 -translate-y-1/2 text-gray-400">
                        <svg class="fill-current" width="18" height="18" viewBox="0 0 20 20" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M3.04175 9.37363C3.04175 5.87693 5.87711 3.04199 9.37508 3.04199C12.8731 3.04199 15.7084 5.87693 15.7084 9.37363C15.7084 12.8703 12.8731 15.7053 9.37508 15.7053C5.87711 15.7053 3.04175 12.8703 3.04175 9.37363ZM9.37508 1.54199C5.04902 1.54199 1.54175 5.04817 1.54175 9.37363C1.54175 13.6991 5.04902 17.2053 9.37508 17.2053C11.2674 17.2053 13.003 16.5344 14.357 15.4176L17.177 18.238C17.4699 18.5309 17.9448 18.5309 18.2377 18.238C18.5306 17.9451 18.5306 17.4703 18.2377 17.1774L15.418 14.3573C16.5365 13.0033 17.2084 11.2669 17.2084 9.37363C17.2084 5.04817 13.7011 1.54199 9.37508 1.54199Z"/>
                        </svg>
                    </span>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari Nama, NIK, No. KK, atau Blok..."
                        class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-10 w-full rounded-lg border border-gray-300 bg-transparent py-2 pr-4 pl-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                    />
                </div>

                <!-- Dropdown Filters -->
                <div class="flex flex-wrap items-center gap-2.5">
                    <!-- Status KTP -->
                    <div class="relative z-20 bg-transparent">
                        <select
                            name="status_ktp"
                            class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-10 appearance-none rounded-lg border border-gray-300 bg-transparent bg-none py-2 pr-9 pl-3.5 text-sm text-gray-700 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                        >
                            <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">Semua Status KTP</option>
                            <option value="ada" {{ request('status_ktp') == 'ada' ? 'selected' : '' }} class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">Ada KTP</option>
                            <option value="belum" {{ request('status_ktp') == 'belum' ? 'selected' : '' }} class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">Belum Ber-KTP</option>
                        </select>
                        <span class="pointer-events-none absolute top-1/2 right-3 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                            <svg class="stroke-current" width="16" height="16" viewBox="0 0 20 20" fill="none">
                                <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                    </div>

                    <!-- Agama -->
                    <div class="relative z-20 bg-transparent">
                        <select
                            name="agama"
                            class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-10 appearance-none rounded-lg border border-gray-300 bg-transparent bg-none py-2 pr-9 pl-3.5 text-sm text-gray-700 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                        >
                            <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">Semua Agama</option>
                            @foreach(['Islam', 'Kristen Protestan', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agamaOption)
                                <option value="{{ $agamaOption }}" {{ request('agama') == $agamaOption ? 'selected' : '' }} class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">{{ $agamaOption }}</option>
                            @endforeach
                        </select>
                        <span class="pointer-events-none absolute top-1/2 right-3 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                            <svg class="stroke-current" width="16" height="16" viewBox="0 0 20 20" fill="none">
                                <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                    </div>

                    <button
                        type="submit"
                        class="text-theme-sm shadow-theme-xs inline-flex h-10 items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/5"
                    >
                        <svg class="stroke-current" width="18" height="18" viewBox="0 0 20 20" fill="none">
                            <path d="M2.29004 5.90393H17.7067" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M17.7075 14.0961H2.29085" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12.0826 3.33331C13.5024 3.33331 14.6534 4.48431 14.6534 5.90414C14.6534 7.32398 13.5024 8.47498 12.0826 8.47498C10.6627 8.47498 9.51172 7.32398 9.51172 5.90415C9.51172 4.48432 10.6627 3.33331 12.0826 3.33331Z" stroke-width="1.5"/>
                            <path d="M7.91745 11.525C6.49762 11.525 5.34662 12.676 5.34662 14.0959C5.34661 15.5157 6.49762 16.6667 7.91745 16.6667C9.33728 16.6667 10.4883 15.5157 10.4883 14.0959C10.4883 12.676 9.33728 11.525 7.91745 11.525Z" stroke-width="1.5"/>
                        </svg>
                        Filter
                    </button>

                    @if(request()->anyFilled(['search', 'status_ktp', 'jenis_kelamin', 'agama']))
                    <a
                        href="{{ route('warga.index') }}"
                        class="text-theme-sm inline-flex h-10 items-center rounded-lg px-3 py-2 font-medium text-error-600 transition hover:bg-error-50 dark:text-error-400 dark:hover:bg-error-500/10"
                    >
                        Reset
                    </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Table Content -->
        <div class="custom-scrollbar max-w-full overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                        <th class="px-5 py-3 text-left sm:px-6">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Nama Warga</p>
                        </th>
                        <th class="px-5 py-3 text-left sm:px-6">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">No. KK &amp; Agama</p>
                        </th>
                        <th class="px-5 py-3 text-left sm:px-6">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Alamat Blok</p>
                        </th>
                        <th class="px-5 py-3 text-left sm:px-6">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Pekerjaan</p>
                        </th>
                        <th class="px-5 py-3 text-left sm:px-6">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Penghasilan</p>
                        </th>
                        <th class="px-5 py-3 text-left sm:px-6">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Rumah</p>
                        </th>
                        <th class="px-5 py-3 text-left sm:px-6">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Status KTP</p>
                        </th>
                        <th class="px-5 py-3 text-right sm:px-6">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Aksi</p>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($wargas as $warga)
                    <tr class="transition hover:bg-gray-50/60 dark:hover:bg-white/[0.02]">
                        <td class="px-5 py-4 whitespace-nowrap sm:px-6">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full {{ $warga->jenis_kelamin === 'L' ? 'bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400' : 'bg-theme-pink-500/10 text-theme-pink-500' }} text-theme-xs font-semibold">
                                    {{ strtoupper(substr($warga->nama_lengkap, 0, 2)) }}
                                </div>
                                <div>
                                    <a href="{{ route('warga.show', $warga->id) }}" class="text-theme-sm block font-medium text-gray-800 hover:text-brand-500 dark:text-white/90 dark:hover:text-brand-400">
                                        {{ $warga->nama_lengkap }}
                                    </a>
                                    <span class="text-theme-xs block text-gray-500 dark:text-gray-400">
                                        NIK: {{ $warga->nik }} &bull; {{ $warga->jenis_kelamin_label }}, {{ $warga->usia }} thn
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap sm:px-6">
                            <p class="text-theme-sm font-mono text-gray-700 dark:text-gray-300">{{ $warga->no_kk }}</p>
                            <span class="text-theme-xs text-gray-500 dark:text-gray-400">{{ $warga->agama ?? 'Islam' }}</span>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap sm:px-6">
                            <p class="text-theme-sm font-medium text-gray-800 dark:text-white/90">{{ $warga->alamat_blok }}</p>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap sm:px-6">
                            <p class="text-theme-sm text-gray-500 dark:text-gray-400">{{ $warga->pekerjaan }}</p>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap sm:px-6">
                            <p class="text-theme-sm font-medium text-gray-800 dark:text-white/90">{{ $warga->formatted_penghasilan }}</p>
                            <span class="text-theme-xs text-gray-500 dark:text-gray-400">Skor Ekonomi: {{ $warga->skor_ekonomi }}/5</span>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap sm:px-6">
                            <p class="text-theme-sm text-gray-500 dark:text-gray-400">{{ ucwords(str_replace('_', ' ', $warga->status_kepemilikan_rumah)) }}</p>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap sm:px-6">
                            @if($warga->status_ktp === 'ada')
                                <span class="bg-success-50 text-theme-xs text-success-600 dark:bg-success-500/15 dark:text-success-500 inline-flex items-center rounded-full px-2.5 py-0.5 font-medium">
                                    Ada KTP
                                </span>
                            @else
                                <span class="bg-error-50 text-theme-xs text-error-600 dark:bg-error-500/15 dark:text-error-500 inline-flex items-center rounded-full px-2.5 py-0.5 font-medium">
                                    Belum KTP
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap text-right sm:px-6">
                            <div class="relative inline-block text-left" x-data="{ open: false }" @click.outside="open = false">
                                <button
                                    type="button"
                                    @click="open = !open"
                                    class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-gray-500 transition hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-white"
                                    title="Menu Aksi"
                                >
                                    <svg class="fill-current" width="20" height="20" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M5.99902 10.245C6.96552 10.245 7.74902 11.0285 7.74902 11.995V12.005C7.74902 12.9715 6.96552 13.755 5.99902 13.755C5.03253 13.755 4.24902 12.9715 4.24902 12.005V11.995C4.24902 11.0285 5.03253 10.245 5.99902 10.245ZM17.999 10.245C18.9655 10.245 19.749 11.0285 19.749 11.995V12.005C19.749 12.9715 18.9655 13.755 17.999 13.755C17.0325 13.755 16.249 12.9715 16.249 12.005V11.995C16.249 11.0285 17.0325 10.245 17.999 10.245ZM13.749 11.995C13.749 11.0285 12.9655 10.245 11.999 10.245C11.0325 10.245 10.249 11.0285 10.249 11.995V12.005C10.249 12.9715 11.0325 13.755 11.999 13.755C12.9655 13.755 13.749 12.9715 13.749 12.005V11.995Z"/>
                                    </svg>
                                </button>

                                <div
                                    x-show="open"
                                    x-transition
                                    class="shadow-theme-lg dark:bg-gray-dark absolute right-0 z-40 mt-1 w-40 space-y-1 rounded-xl border border-gray-200 bg-white p-1.5 dark:border-gray-800"
                                    x-cloak
                                >
                                    <a
                                        href="{{ route('warga.show', $warga->id) }}"
                                        class="text-theme-xs flex w-full items-center gap-2 rounded-lg px-3 py-2 text-left font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5"
                                    >
                                        <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Lihat Detail
                                    </a>

                                    @if(auth()->user()->isAdmin() || auth()->user()->isKetuaRt())
                                    <a
                                        href="{{ route('warga.edit', $warga->id) }}"
                                        class="text-theme-xs flex w-full items-center gap-2 rounded-lg px-3 py-2 text-left font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5"
                                    >
                                        <svg class="h-4 w-4 text-warning-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Ubah Data
                                    </a>

                                    <form method="POST" action="{{ route('warga.destroy', $warga->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data warga ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="text-theme-xs flex w-full items-center gap-2 rounded-lg px-3 py-2 text-left font-medium text-error-600 hover:bg-error-50 dark:text-error-400 dark:hover:bg-error-500/10"
                                        >
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Hapus Data
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-5 py-10 text-center sm:px-6">
                            <p class="text-theme-sm text-gray-500 dark:text-gray-400">
                                Tidak ditemukan data warga yang sesuai dengan kriteria pencarian.
                            </p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($wargas->hasPages())
        <div class="border-t border-gray-100 px-5 py-4 sm:px-6 dark:border-gray-800">
            {{ $wargas->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
