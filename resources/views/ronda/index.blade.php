@extends('layouts.app')

@section('title', 'Jadwal Ronda Malam')
@section('page_title', 'Jadwal Ronda Malam')

@section('content')
<!-- Breadcrumb Start -->
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h2 class="text-title-md2 font-semibold text-gray-800 dark:text-white/90">
            Jadwal Ronda Malam
        </h2>
        <p class="mt-1 text-theme-xs text-gray-500 dark:text-gray-400">
            Generate jadwal ronda bergilir warga RT 03, unduh PDF untuk cetak/mading, atau bagikan file ke grup WhatsApp warga
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
            <li class="text-sm font-medium text-gray-800 dark:text-white/90">Jadwal Ronda Malam</li>
        </ol>
    </nav>
</div>
<!-- Breadcrumb End -->

<div
    class="space-y-6"
    x-data="{
        showModalCreate: false,
        showModalGenerate: false,
        viewMode: 'table',
        searchSchedule: '',
        wargaSearch: '',
        matchesSearch(text) {
            if (!this.searchSchedule) return true;
            return text.toLowerCase().includes(this.searchSchedule.toLowerCase());
        }
    }"
>
    <!-- TailAdmin Data Table Card Start -->
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3">
        <!-- Card Header: Title, Search, Date Filter & Action Buttons -->
        <div class="flex flex-col gap-4 border-b border-gray-100 px-5 py-4 sm:px-6 sm:py-5 dark:border-gray-800">
            <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex items-center gap-3">
                    <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">
                        Daftar Jadwal Ronda Malam RT 03
                    </h3>
                    <span class="inline-flex items-center rounded-full bg-brand-50 px-2.5 py-0.5 text-theme-xs font-medium text-brand-500 dark:bg-brand-500/15 dark:text-brand-400">
                        {{ $schedules->total() }} Jadwal
                    </span>
                </div>

                <!-- Action Buttons Toolbar -->
                <div class="flex flex-wrap items-center gap-2">
                    <!-- View Mode Switcher -->
                    <div class="inline-flex items-center rounded-lg border border-gray-200 bg-gray-50 p-1 dark:border-gray-800 dark:bg-gray-900">
                        <button
                            type="button"
                            @click="viewMode = 'table'"
                            :class="viewMode === 'table' ? 'bg-white text-gray-800 shadow-theme-xs dark:bg-gray-800 dark:text-white' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400'"
                            class="inline-flex items-center gap-1.5 rounded-md px-2.5 py-1.5 text-theme-xs font-medium transition cursor-pointer"
                        >
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                            Tabel
                        </button>
                        <button
                            type="button"
                            @click="viewMode = 'grid'"
                            :class="viewMode === 'grid' ? 'bg-white text-gray-800 shadow-theme-xs dark:bg-gray-800 dark:text-white' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400'"
                            class="inline-flex items-center gap-1.5 rounded-md px-2.5 py-1.5 text-theme-xs font-medium transition cursor-pointer"
                        >
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                            </svg>
                            Kartu
                        </button>
                    </div>

                    <a
                        href="{{ route('ronda.exportPdf', request()->all()) }}"
                        target="_blank"
                        class="inline-flex h-10 items-center gap-2 rounded-lg border border-gray-300 bg-white px-3.5 py-2 text-theme-xs font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/3 transition"
                        title="Cetak PDF untuk mading atau share WhatsApp"
                    >
                        <svg class="h-4 w-4 text-error-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        PDF Mading / WA
                    </a>

                    <a
                        href="{{ route('ronda.exportExcel', request()->all()) }}"
                        class="inline-flex h-10 items-center gap-2 rounded-lg border border-gray-300 bg-white px-3.5 py-2 text-theme-xs font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/3 transition"
                    >
                        <svg class="h-4 w-4 text-success-600 dark:text-success-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Excel (XLSX)
                    </a>

                    @if(auth()->user()->isAdmin() || auth()->user()->isKetuaRt())
                    <button
                        type="button"
                        @click="showModalGenerate = true"
                        class="inline-flex h-10 items-center gap-2 rounded-lg border border-brand-200 bg-brand-50 px-3.5 py-2 text-theme-xs font-medium text-brand-600 shadow-theme-xs hover:bg-brand-100 dark:border-brand-500/30 dark:bg-brand-500/15 dark:text-brand-300 transition cursor-pointer"
                    >
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Generate Bergilir
                    </button>

                    <button
                        type="button"
                        @click="showModalCreate = true"
                        class="inline-flex h-10 items-center gap-2 rounded-lg bg-brand-500 px-4 py-2 text-theme-xs font-medium text-white shadow-theme-xs hover:bg-brand-600 transition cursor-pointer"
                    >
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Buat Jadwal Manual
                    </button>
                    @endif
                </div>
            </div>

            <!-- Integrated Search & Date Range Filter Bar (Matching Reference Template) -->
            <form method="GET" action="{{ route('ronda.index') }}" class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between pt-2">
                <!-- Search Input -->
                <div class="relative flex-1 sm:max-w-xs">
                    <span class="pointer-events-none absolute top-1/2 left-3.5 -translate-y-1/2 text-gray-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </span>
                    <input
                        type="text"
                        x-model="searchSchedule"
                        placeholder="Cari petugas, tanggal, atau shift..."
                        class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:bg-gray-900 h-10 w-full rounded-lg border border-gray-300 bg-transparent py-2 pr-4 pl-10 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30"
                    >
                </div>

                <!-- Date Range Filter -->
                <div class="flex flex-wrap items-center gap-2">
                    <div class="relative">
                        <input
                            type="date"
                            name="start_date"
                            value="{{ request('start_date') }}"
                            onclick="this.showPicker && this.showPicker()"
                            title="Dari Tanggal"
                            class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:bg-gray-900 h-10 rounded-lg border border-gray-300 bg-transparent px-3.5 py-2 pr-9 text-theme-xs font-medium text-gray-700 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-gray-300"
                        >
                        <span class="pointer-events-none absolute top-1/2 right-3 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                            <svg class="fill-current" width="16" height="16" viewBox="0 0 20 20" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M6.66659 1.5415C7.0808 1.5415 7.41658 1.87729 7.41658 2.2915V2.99984H12.5833V2.2915C12.5833 1.87729 12.919 1.5415 13.3333 1.5415C13.7475 1.5415 14.0833 1.87729 14.0833 2.2915V2.99984L15.4166 2.99984C16.5212 2.99984 17.4166 3.89527 17.4166 4.99984V7.49984V15.8332C17.4166 16.9377 16.5212 17.8332 15.4166 17.8332H4.58325C3.47868 17.8332 2.58325 16.9377 2.58325 15.8332V7.49984V4.99984C2.58325 3.89527 3.47868 2.99984 4.58325 2.99984L5.91659 2.99984V2.2915C5.91659 1.87729 6.25237 1.5415 6.66659 1.5415ZM6.66659 4.49984H4.58325C4.30711 4.49984 4.08325 4.7237 4.08325 4.99984V6.74984H15.9166V4.99984C15.9166 4.7237 15.6927 4.49984 15.4166 4.49984H13.3333H6.66659ZM15.9166 8.24984H4.08325V15.8332C4.08325 16.1093 4.30711 16.3332 4.58325 16.3332H15.4166C15.6927 16.3332 15.9166 16.1093 15.9166 15.8332V8.24984Z" />
                            </svg>
                        </span>
                    </div>

                    <span class="text-theme-xs text-gray-400">s/d</span>

                    <div class="relative">
                        <input
                            type="date"
                            name="end_date"
                            value="{{ request('end_date') }}"
                            onclick="this.showPicker && this.showPicker()"
                            title="Sampai Tanggal"
                            class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:bg-gray-900 h-10 rounded-lg border border-gray-300 bg-transparent px-3.5 py-2 pr-9 text-theme-xs font-medium text-gray-700 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-gray-300"
                        >
                        <span class="pointer-events-none absolute top-1/2 right-3 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                            <svg class="fill-current" width="16" height="16" viewBox="0 0 20 20" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M6.66659 1.5415C7.0808 1.5415 7.41658 1.87729 7.41658 2.2915V2.99984H12.5833V2.2915C12.5833 1.87729 12.919 1.5415 13.3333 1.5415C13.7475 1.5415 14.0833 1.87729 14.0833 2.2915V2.99984L15.4166 2.99984C16.5212 2.99984 17.4166 3.89527 17.4166 4.99984V7.49984V15.8332C17.4166 16.9377 16.5212 17.8332 15.4166 17.8332H4.58325C3.47868 17.8332 2.58325 16.9377 2.58325 15.8332V7.49984V4.99984C2.58325 3.89527 3.47868 2.99984 4.58325 2.99984L5.91659 2.99984V2.2915C5.91659 1.87729 6.25237 1.5415 6.66659 1.5415ZM6.66659 4.49984H4.58325C4.30711 4.49984 4.08325 4.7237 4.08325 4.99984V6.74984H15.9166V4.99984C15.9166 4.7237 15.6927 4.49984 15.4166 4.49984H13.3333H6.66659ZM15.9166 8.24984H4.08325V15.8332C4.08325 16.1093 4.30711 16.3332 4.58325 16.3332H15.4166C15.6927 16.3332 15.9166 16.1093 15.9166 15.8332V8.24984Z" />
                            </svg>
                        </span>
                    </div>

                    <button
                        type="submit"
                        class="inline-flex h-10 items-center justify-center rounded-lg border border-gray-300 bg-white px-3.5 py-2 text-theme-xs font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/3 transition cursor-pointer"
                    >
                        Filter Tanggal
                    </button>

                    @if(request()->filled('start_date') || request()->filled('end_date'))
                    <a
                        href="{{ route('ronda.index') }}"
                        class="inline-flex h-10 items-center justify-center rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-theme-xs font-medium text-gray-600 hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 transition"
                    >
                        Reset
                    </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- VIEW 1: TailAdmin Data Table -->
        <div x-show="viewMode === 'table'" class="max-w-full overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                        <th class="px-5 py-3 sm:px-6 text-left">
                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Hari &amp; Tanggal Ronda</p>
                        </th>
                        <th class="px-5 py-3 sm:px-6 text-left">
                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Shift Jam</p>
                        </th>
                        <th class="px-5 py-3 sm:px-6 text-left">
                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Petugas Piket</p>
                        </th>
                        <th class="px-5 py-3 sm:px-6 text-left">
                            <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Instruksi / Keterangan</p>
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
                    @forelse($schedules as $sched)
                    @php
                        $searchableText = $sched->tanggal_ronda->isoFormat('dddd, D MMMM Y') . ' ' . $sched->shift_ronda . ' ' . ($sched->keterangan_khusus ?? '') . ' ' . $sched->participants->pluck('warga.nama_lengkap')->join(' ');
                    @endphp
                    <tr
                        x-show="matchesSearch(@js($searchableText))"
                        class="hover:bg-gray-50/60 dark:hover:bg-white/[0.02] transition"
                    >
                        <!-- Hari & Tanggal -->
                        <td class="px-5 py-4 sm:px-6">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 shrink-0 flex-col items-center justify-center rounded-full bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
                                    <span class="text-[10px] font-semibold uppercase leading-none">{{ $sched->tanggal_ronda->isoFormat('MMM') }}</span>
                                    <span class="text-xs font-bold leading-tight">{{ $sched->tanggal_ronda->format('d') }}</span>
                                </div>
                                <div>
                                    <span class="block font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                        {{ $sched->tanggal_ronda->isoFormat('dddd, D MMMM Y') }}
                                    </span>
                                    <span class="block text-gray-500 text-theme-xs dark:text-gray-400">
                                        Oleh {{ $sched->createdBy->name ?? 'Ketua RT' }} &bull; {{ $sched->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        </td>

                        <!-- Shift Ronda -->
                        <td class="px-5 py-4 sm:px-6">
                            <p class="text-gray-600 text-theme-sm dark:text-gray-300 font-medium">
                                {{ $sched->shift_ronda }}
                            </p>
                        </td>

                        <!-- Petugas Piket -->
                        <td class="px-5 py-4 sm:px-6">
                            <div class="flex flex-wrap items-center gap-1.5 max-w-md">
                                @foreach($sched->participants as $participant)
                                <span class="inline-flex items-center gap-1.5 rounded-full border border-gray-200 bg-gray-50 px-2.5 py-1 text-theme-xs font-medium text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">
                                    <span class="flex h-4 w-4 items-center justify-center rounded-full bg-brand-500 text-[9px] font-bold text-white">
                                        {{ strtoupper(substr($participant->warga->nama_lengkap, 0, 1)) }}
                                    </span>
                                    {{ $participant->warga->nama_lengkap }}
                                    <span class="text-[10px] text-gray-400">({{ $participant->warga->alamat_blok }})</span>
                                </span>
                                @endforeach
                            </div>
                        </td>

                        <!-- Keterangan -->
                        <td class="px-5 py-4 sm:px-6">
                            <p class="text-gray-500 text-theme-sm dark:text-gray-400 max-w-xs truncate" title="{{ $sched->keterangan_khusus }}">
                                {{ $sched->keterangan_khusus ?: 'Patroli rutin lingkungan RT 03' }}
                            </p>
                        </td>

                        <!-- Status -->
                        <td class="px-5 py-4 sm:px-6">
                            @if($sched->tanggal_ronda->isToday())
                                <span class="inline-flex items-center rounded-full bg-success-50 px-2.5 py-0.5 text-theme-xs font-medium text-success-600 dark:bg-success-500/15 dark:text-success-500">
                                    Malam Ini
                                </span>
                            @elseif($sched->tanggal_ronda->isFuture())
                                <span class="inline-flex items-center rounded-full bg-warning-50 px-2.5 py-0.5 text-theme-xs font-medium text-warning-600 dark:bg-warning-500/15 dark:text-warning-400">
                                    Terjadwal ({{ $sched->participants->count() }} Warga)
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-theme-xs font-medium text-gray-600 dark:bg-white/5 dark:text-gray-400">
                                    Selesai
                                </span>
                            @endif
                        </td>

                        <!-- Action Three-Dots Dropdown -->
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
                                        href="{{ route('ronda.exportPdf', ['start_date' => $sched->tanggal_ronda->format('Y-m-d'), 'end_date' => $sched->tanggal_ronda->format('Y-m-d')]) }}"
                                        target="_blank"
                                        class="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-left text-theme-xs font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5"
                                    >
                                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                        </svg>
                                        Cetak Jadwal Ini
                                    </a>

                                    @if(auth()->user()->isAdmin() || auth()->user()->isKetuaRt())
                                    <form method="POST" action="{{ route('ronda.destroy', $sched->id) }}" onsubmit="return confirm('Hapus jadwal ronda tanggal {{ $sched->tanggal_ronda->format('d/m/Y') }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-left text-theme-xs font-medium text-error-600 hover:bg-error-50 dark:text-error-400 dark:hover:bg-error-500/10 cursor-pointer"
                                        >
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Hapus Jadwal
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-14 text-center">
                            <div class="mx-auto max-w-sm">
                                <svg class="mx-auto h-12 w-12 text-gray-300 dark:text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="mt-3 text-sm font-semibold text-gray-700 dark:text-gray-300">Belum ada jadwal ronda yang dibuat</p>
                                <p class="mt-1 text-theme-xs text-gray-500 dark:text-gray-400">Gunakan tombol "Generate Bergilir" atau "Buat Jadwal Manual" untuk menerbitkan jadwal pos ronda.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- VIEW 2: Grid Cards Mode -->
        <div x-show="viewMode === 'grid'" x-cloak class="p-5 sm:p-6">
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                @forelse($schedules as $sched)
                <div class="flex flex-col justify-between rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/3">
                    <div>
                        <div class="flex items-start justify-between border-b border-gray-100 pb-4 dark:border-gray-800">
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="rounded-full bg-brand-50 px-3 py-1 text-theme-xs font-medium text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
                                        {{ $sched->tanggal_ronda->isoFormat('dddd, D MMMM Y') }}
                                    </span>
                                    @if($sched->tanggal_ronda->isToday())
                                        <span class="rounded-full bg-success-50 px-2.5 py-0.5 text-theme-xs font-medium text-success-600 dark:bg-success-500/15 dark:text-success-400">Malam Ini</span>
                                    @endif
                                </div>
                                <p class="mt-1.5 text-theme-xs font-medium text-gray-500 dark:text-gray-400">Shift: {{ $sched->shift_ronda }}</p>
                            </div>

                            @if(auth()->user()->isAdmin() || auth()->user()->isKetuaRt())
                            <form method="POST" action="{{ route('ronda.destroy', $sched->id) }}" onsubmit="return confirm('Hapus jadwal ronda tanggal {{ $sched->tanggal_ronda->format('d/m/Y') }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-lg p-1.5 text-gray-400 hover:bg-error-50 hover:text-error-600 dark:hover:bg-error-500/10 transition cursor-pointer" title="Hapus Jadwal">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                            @endif
                        </div>

                        @if($sched->keterangan_khusus)
                        <p class="mt-3 rounded-xl border border-warning-200 bg-warning-50/60 p-3 text-theme-xs text-gray-700 italic dark:border-warning-500/20 dark:bg-warning-500/10 dark:text-gray-300">
                            &ldquo;{{ $sched->keterangan_khusus }}&rdquo;
                        </p>
                        @endif

                        <div class="mt-4 space-y-2">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">
                                Petugas Piket ({{ $sched->participants->count() }} Warga)
                            </p>
                            @foreach($sched->participants as $participant)
                            <div class="flex items-center justify-between rounded-xl border border-gray-100 bg-gray-50/70 px-3.5 py-2.5 dark:border-gray-800 dark:bg-gray-900/60">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-brand-50 text-theme-xs font-semibold text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
                                        {{ $loop->iteration }}
                                    </div>
                                    <div>
                                        <p class="text-theme-sm font-medium text-gray-800 dark:text-white/90">{{ $participant->warga->nama_lengkap }}</p>
                                        <p class="text-theme-xs text-gray-500 dark:text-gray-400">{{ $participant->warga->alamat_blok }} &bull; {{ $participant->warga->pekerjaan }}</p>
                                    </div>
                                </div>
                                <span class="rounded-full bg-success-50 px-2.5 py-0.5 text-theme-xs font-medium text-success-600 dark:bg-success-500/15 dark:text-success-400">
                                    Terdaftar
                                </span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-4 flex justify-between border-t border-gray-100 pt-3 text-theme-xs text-gray-400 dark:border-gray-800">
                        <span>Dibuat oleh: {{ $sched->createdBy->name ?? 'Ketua RT' }}</span>
                        <span>{{ $sched->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-12 text-center text-theme-sm text-gray-400">
                    Belum ada jadwal ronda yang dibuat.
                </div>
                @endforelse
            </div>
        </div>

        <!-- Pagination Footer -->
        @if($schedules->hasPages())
        <div class="border-t border-gray-100 px-5 py-4 sm:px-6 dark:border-gray-800">
            {{ $schedules->links() }}
        </div>
        @endif
    </div>
    <!-- TailAdmin Data Table Card End -->

    <!-- MODAL 1: Form Buat Jadwal Manual (TailAdmin Modal Style) -->
    <div
        x-show="showModalCreate"
        class="fixed inset-0 z-99999 flex items-center justify-center overflow-y-auto p-5"
        x-cloak
    >
        <div
            @click="showModalCreate = false"
            class="fixed inset-0 h-full w-full bg-gray-400/50 backdrop-blur-[32px]"
        ></div>

        <div
            @click.outside="showModalCreate = false"
            class="relative w-full max-w-[600px] rounded-3xl bg-white p-6 shadow-theme-lg lg:p-10 dark:bg-gray-900 border border-gray-200 dark:border-gray-800 max-h-[90vh] overflow-y-auto"
        >
            <!-- Close Button -->
            <button
                type="button"
                @click="showModalCreate = false"
                class="absolute top-5 right-5 z-999 flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 text-gray-400 transition-colors hover:bg-gray-200 hover:text-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200 cursor-pointer"
            >
                <svg class="fill-current" width="20" height="20" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M6.04289 16.5418C5.65237 16.9323 5.65237 17.5655 6.04289 17.956C6.43342 18.3465 7.06658 18.3465 7.45711 17.956L11.9987 13.4144L16.5408 17.9565C16.9313 18.347 17.5645 18.347 17.955 17.9565C18.3455 17.566 18.3455 16.9328 17.955 16.5423L13.4129 12.0002L17.955 7.45808C18.3455 7.06756 18.3455 6.43439 17.955 6.04387C17.5645 5.65335 16.9313 5.65335 16.5408 6.04387L11.9987 10.586L7.45711 6.04439C7.06658 5.65386 6.43342 5.65386 6.04289 6.04439C5.65237 6.43491 5.65237 7.06808 6.04289 7.4586L10.5845 12.0002L6.04289 16.5418Z"/>
                </svg>
            </button>

            <div class="pr-10">
                <h4 class="mb-1 text-xl font-semibold text-gray-800 dark:text-white/90">
                    Buat Jadwal Ronda Manual
                </h4>
                <p class="mb-6 text-sm text-gray-500 dark:text-gray-400">
                    Tentukan tanggal ronda dan pilih warga yang bertugas malam di pos ronda RT 03.
                </p>
            </div>

            <form action="{{ route('ronda.store') }}" method="POST" class="space-y-5">
                @csrf
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Tanggal Ronda <span class="text-error-500">*</span>
                        </label>
                        <div class="relative">
                            <input
                                type="date"
                                name="tanggal_ronda"
                                required
                                value="{{ date('Y-m-d') }}"
                                onclick="this.showPicker && this.showPicker()"
                                class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:bg-gray-900 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pr-11 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-white/90"
                            >
                            <span class="pointer-events-none absolute top-1/2 right-3.5 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                                <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M6.66659 1.5415C7.0808 1.5415 7.41658 1.87729 7.41658 2.2915V2.99984H12.5833V2.2915C12.5833 1.87729 12.919 1.5415 13.3333 1.5415C13.7475 1.5415 14.0833 1.87729 14.0833 2.2915V2.99984L15.4166 2.99984C16.5212 2.99984 17.4166 3.89527 17.4166 4.99984V7.49984V15.8332C17.4166 16.9377 16.5212 17.8332 15.4166 17.8332H4.58325C3.47868 17.8332 2.58325 16.9377 2.58325 15.8332V7.49984V4.99984C2.58325 3.89527 3.47868 2.99984 4.58325 2.99984L5.91659 2.99984V2.2915C5.91659 1.87729 6.25237 1.5415 6.66659 1.5415ZM6.66659 4.49984H4.58325C4.30711 4.49984 4.08325 4.7237 4.08325 4.99984V6.74984H15.9166V4.99984C15.9166 4.7237 15.6927 4.49984 15.4166 4.49984H13.3333H6.66659ZM15.9166 8.24984H4.08325V15.8332C4.08325 16.1093 4.30711 16.3332 4.58325 16.3332H15.4166C15.6927 16.3332 15.9166 16.1093 15.9166 15.8332V8.24984Z" />
                                </svg>
                            </span>
                        </div>
                    </div>

                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Shift Ronda <span class="text-error-500">*</span>
                        </label>
                        <div class="relative z-20 bg-transparent">
                            <select
                                name="shift_ronda"
                                required
                                class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:bg-gray-900 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-white/90"
                            >
                                <option value="Malam (22:00 - 04:00)" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">Malam (22:00 - 04:00)</option>
                                <option value="Shift 1 (21:00 - 01:00)" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">Shift 1 (21:00 - 01:00)</option>
                                <option value="Shift 2 (01:00 - 05:00)" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">Shift 2 (01:00 - 05:00)</option>
                            </select>
                            <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                                <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Pesan / Instruksi Pos Ronda (Opsional)
                    </label>
                    <input
                        type="text"
                        name="keterangan_khusus"
                        placeholder="Contoh: Fokus patroli gerbang depan & waspada hujan"
                        class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:bg-gray-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30"
                    >
                </div>

                <div>
                    <div class="mb-2 flex items-center justify-between">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Pilih Petugas Ronda <span class="text-error-500">*</span>
                        </label>
                        <span class="text-theme-xs text-gray-400">Centang warga yang bertugas</span>
                    </div>

                    <input
                        type="text"
                        x-model="wargaSearch"
                        placeholder="Cari nama warga atau blok..."
                        class="mb-2.5 h-10 w-full rounded-lg border border-gray-300 bg-transparent px-3.5 py-2 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                    >

                    <div class="max-h-52 space-y-1 overflow-y-auto rounded-xl border border-gray-200 p-2.5 dark:border-gray-800 dark:bg-gray-800/40">
                        @foreach($wargas as $w)
                        <label
                            x-show="!wargaSearch || @js(strtolower($w->nama_lengkap . ' ' . $w->alamat_blok)).includes(wargaSearch.toLowerCase())"
                            class="flex cursor-pointer items-center justify-between rounded-lg px-3 py-2 text-sm hover:bg-gray-50 dark:hover:bg-white/5"
                        >
                            <div class="flex items-center gap-3">
                                <input
                                    type="checkbox"
                                    name="warga_ids[]"
                                    value="{{ $w->id }}"
                                    class="h-4 w-4 rounded border-gray-300 text-brand-500 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-900"
                                >
                                <span class="font-medium text-gray-800 dark:text-white/90">{{ $w->nama_lengkap }}</span>
                            </div>
                            <span class="text-theme-xs text-gray-500 dark:text-gray-400">{{ $w->alamat_blok }} &bull; {{ $w->jenis_kelamin }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-800">
                    <button
                        type="button"
                        @click="showModalCreate = false"
                        class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/3 cursor-pointer"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600 cursor-pointer"
                    >
                        Simpan Jadwal Ronda
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 2: Generate Jadwal Bergilir Otomatis (TailAdmin Modal Style) -->
    <div
        x-show="showModalGenerate"
        class="fixed inset-0 z-99999 flex items-center justify-center overflow-y-auto p-5"
        x-cloak
    >
        <div
            @click="showModalGenerate = false"
            class="fixed inset-0 h-full w-full bg-gray-400/50 backdrop-blur-[32px]"
        ></div>

        <div
            @click.outside="showModalGenerate = false"
            class="relative w-full max-w-[520px] rounded-3xl bg-white p-6 shadow-theme-lg lg:p-10 dark:bg-gray-900 border border-gray-200 dark:border-gray-800"
        >
            <!-- Close Button -->
            <button
                type="button"
                @click="showModalGenerate = false"
                class="absolute top-5 right-5 z-999 flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 text-gray-400 transition-colors hover:bg-gray-200 hover:text-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200 cursor-pointer"
            >
                <svg class="fill-current" width="20" height="20" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M6.04289 16.5418C5.65237 16.9323 5.65237 17.5655 6.04289 17.956C6.43342 18.3465 7.06658 18.3465 7.45711 17.956L11.9987 13.4144L16.5408 17.9565C16.9313 18.347 17.5645 18.347 17.955 17.9565C18.3455 17.566 18.3455 16.9328 17.955 16.5423L13.4129 12.0002L17.955 7.45808C18.3455 7.06756 18.3455 6.43439 17.955 6.04387C17.5645 5.65335 16.9313 5.65335 16.5408 6.04387L11.9987 10.586L7.45711 6.04439C7.06658 5.65386 6.43342 5.65386 6.04289 6.04439C5.65237 6.43491 5.65237 7.06808 6.04289 7.4586L10.5845 12.0002L6.04289 16.5418Z"/>
                </svg>
            </button>

            <div class="pr-10">
                <h4 class="mb-1 text-xl font-semibold text-gray-800 dark:text-white/90">
                    Generate Jadwal Ronda Bergilir
                </h4>
                <p class="mb-6 text-sm text-gray-500 dark:text-gray-400">
                    Sistem akan membagi warga RT 03 secara acak dan bergilir per malam, lalu jadwal langsung siap dicetak (PDF) untuk ditempel di mading atau dibagikan ke WhatsApp warga.
                </p>
            </div>

            <form action="{{ route('ronda.generateOtomatis') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Mulai Dari Tanggal <span class="text-error-500">*</span>
                    </label>
                    <div class="relative">
                        <input
                            type="date"
                            name="tanggal_mulai"
                            required
                            value="{{ date('Y-m-d') }}"
                            onclick="this.showPicker && this.showPicker()"
                            class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:bg-gray-900 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pr-11 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-white/90"
                        >
                        <span class="pointer-events-none absolute top-1/2 right-3.5 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                            <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M6.66659 1.5415C7.0808 1.5415 7.41658 1.87729 7.41658 2.2915V2.99984H12.5833V2.2915C12.5833 1.87729 12.919 1.5415 13.3333 1.5415C13.7475 1.5415 14.0833 1.87729 14.0833 2.2915V2.99984L15.4166 2.99984C16.5212 2.99984 17.4166 3.89527 17.4166 4.99984V7.49984V15.8332C17.4166 16.9377 16.5212 17.8332 15.4166 17.8332H4.58325C3.47868 17.8332 2.58325 16.9377 2.58325 15.8332V7.49984V4.99984C2.58325 3.89527 3.47868 2.99984 4.58325 2.99984L5.91659 2.99984V2.2915C5.91659 1.87729 6.25237 1.5415 6.66659 1.5415ZM6.66659 4.49984H4.58325C4.30711 4.49984 4.08325 4.7237 4.08325 4.99984V6.74984H15.9166V4.99984C15.9166 4.7237 15.6927 4.49984 15.4166 4.49984H13.3333H6.66659ZM15.9166 8.24984H4.08325V15.8332C4.08325 16.1093 4.30711 16.3332 4.58325 16.3332H15.4166C15.6927 16.3332 15.9166 16.1093 15.9166 15.8332V8.24984Z" />
                            </svg>
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Berapa Hari Ke Depan? <span class="text-error-500">*</span>
                        </label>
                        <input
                            type="number"
                            name="jumlah_hari"
                            min="1"
                            max="30"
                            value="7"
                            required
                            class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:bg-gray-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-white/90"
                        >
                    </div>

                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Petugas / Malam <span class="text-error-500">*</span>
                        </label>
                        <input
                            type="number"
                            name="petugas_per_malam"
                            min="2"
                            max="10"
                            value="4"
                            required
                            class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:bg-gray-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-white/90"
                        >
                    </div>
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Shift Jam Ronda <span class="text-error-500">*</span>
                    </label>
                    <div class="relative z-20 bg-transparent">
                        <select
                            name="shift_ronda"
                            required
                            class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:bg-gray-900 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-white/90"
                        >
                            <option value="Malam (22:00 - 04:00)" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">Malam (22:00 - 04:00)</option>
                            <option value="Shift 1 (21:00 - 01:00)" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">Shift 1 (21:00 - 01:00)</option>
                            <option value="Shift 2 (01:00 - 05:00)" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">Shift 2 (01:00 - 05:00)</option>
                        </select>
                        <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                            <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-800">
                    <button
                        type="button"
                        @click="showModalGenerate = false"
                        class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/3 cursor-pointer"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600 cursor-pointer"
                    >
                        Generate Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
