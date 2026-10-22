@extends('layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard Ringkasan RT 03')

@section('content')
<div class="space-y-6">
    <!-- Top Welcome Banner TailAdmin Style -->
    <div class="rounded-2xl border border-gray-200 bg-white p-5 sm:p-6 dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1.5">
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-brand-50 px-2.5 py-0.5 text-theme-xs font-semibold text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">
                        <span class="h-1.5 w-1.5 rounded-full bg-brand-500 animate-pulse"></span>
                        Sistem Informasi Aktif &bull; RT 03 / RW 02 Kedaung
                    </span>
                    <span class="text-theme-xs text-gray-400 dark:text-gray-500 hidden sm:inline">&bull; Periode {{ date('F Y') }}</span>
                </div>
                <h2 class="text-title-xs sm:text-title-sm font-bold text-gray-800 dark:text-white/90">
                    Selamat Datang, {{ auth()->user()->name }}!
                </h2>
                <p class="mt-1 text-theme-sm text-gray-500 dark:text-gray-400 max-w-2xl">
                    Sistem Terpadu RT 03 Kelurahan Kedaung: kependudukan warga, kas transparansi, jadwal ronda malam, dan rekomendasi bansos otomatis via algoritma K-Means Clustering.
                </p>
            </div>

            <!-- Action Buttons TailAdmin Style -->
            <div class="flex flex-wrap items-center gap-2.5 sm:gap-3">
                <a
                    href="{{ route('warga.create') }}"
                    class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-theme-sm font-medium text-white shadow-theme-xs hover:bg-brand-600 transition"
                >
                    <svg class="h-4 w-4 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Warga
                </a>

                <a
                    href="{{ route('kas.index') }}"
                    class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200 transition"
                >
                    <svg class="h-4 w-4 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Iuran Kas RT
                </a>

                @if(auth()->user()->isAdmin() || auth()->user()->isKetuaRt())
                <form method="POST" action="{{ route('clustering.run') }}" class="inline-block">
                    @csrf
                    <button
                        type="submit"
                        class="inline-flex items-center gap-2 rounded-lg bg-success-500 px-4 py-2.5 text-theme-sm font-medium text-white shadow-theme-xs hover:bg-success-600 transition"
                    >
                        <svg class="h-4 w-4 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        Jalankan K-Means
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>

    <!-- 4 TAILADMIN METRIC CARDS (Exact src/partials/metric-group/metric-group-01.html structure) -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:gap-6 xl:grid-cols-4">
        <!-- Metric Item 1: Total Warga -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 dark:border-gray-800 dark:bg-white/[0.03] transition hover:border-brand-500/40">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800">
                <svg class="fill-gray-800 dark:fill-white/90" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8.80443 5.60156C7.59109 5.60156 6.60749 6.58517 6.60749 7.79851C6.60749 9.01185 7.59109 9.99545 8.80443 9.99545C10.0178 9.99545 11.0014 9.01185 11.0014 7.79851C11.0014 6.58517 10.0178 5.60156 8.80443 5.60156ZM5.10749 7.79851C5.10749 5.75674 6.76267 4.10156 8.80443 4.10156C10.8462 4.10156 12.5014 5.75674 12.5014 7.79851C12.5014 9.84027 10.8462 11.4955 8.80443 11.4955C6.76267 11.4955 5.10749 9.84027 5.10749 7.79851ZM4.86252 15.3208C4.08769 16.0881 3.70377 17.0608 3.51705 17.8611C3.48384 18.0034 3.5211 18.1175 3.60712 18.2112C3.70161 18.3141 3.86659 18.3987 4.07591 18.3987H13.4249C13.6343 18.3987 13.7992 18.3141 13.8937 18.2112C13.9797 18.1175 14.017 18.0034 13.9838 17.8611C13.7971 17.0608 13.4132 16.0881 12.6383 15.3208C11.8821 14.572 10.6899 13.955 8.75042 13.955C6.81096 13.955 5.61877 14.572 4.86252 15.3208ZM3.8071 14.2549C4.87163 13.2009 6.45602 12.455 8.75042 12.455C11.0448 12.455 12.6292 13.2009 13.6937 14.2549C14.7397 15.2906 15.2207 16.5607 15.4446 17.5202C15.7658 18.8971 14.6071 19.8987 13.4249 19.8987H4.07591C2.89369 19.8987 1.73504 18.8971 2.05628 17.5202C2.28015 16.5607 2.76117 15.2906 3.8071 14.2549Z" />
                </svg>
            </div>
            <div class="mt-5 flex items-end justify-between">
                <div>
                    <span class="text-theme-sm text-gray-500 dark:text-gray-400">Total Warga</span>
                    <h4 class="text-title-sm mt-1 font-bold text-gray-800 dark:text-white/90">
                        {{ $totalWarga }}
                    </h4>
                </div>
                <span class="bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 flex items-center gap-1 rounded-full py-0.5 px-2.5 text-theme-xs font-medium">
                    Jiwa
                </span>
            </div>
        </div>

        <!-- Metric Item 2: Kepala Keluarga -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 dark:border-gray-800 dark:bg-white/[0.03] transition hover:border-brand-500/40">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800">
                <svg class="fill-gray-800 dark:fill-white/90" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.665 3.75621C11.8762 3.65064 12.1247 3.65064 12.3358 3.75621L18.7807 6.97856L12.3358 10.2009C12.1247 10.3065 11.8762 10.3065 11.665 10.2009L5.22014 6.97856L11.665 3.75621ZM4.29297 8.19203V16.0946C4.29297 16.3787 4.45347 16.6384 4.70757 16.7654L11.25 20.0366V11.6513C11.1631 11.6205 11.0777 11.5843 10.9942 11.5426L4.29297 8.19203ZM12.75 20.037L19.2933 16.7654C19.5474 16.6384 19.7079 16.3787 19.7079 16.0946V8.19202L13.0066 11.5426C12.9229 11.5844 12.8372 11.6208 12.75 11.6516V20.037Z"/>
                </svg>
            </div>
            <div class="mt-5 flex items-end justify-between">
                <div>
                    <span class="text-theme-sm text-gray-500 dark:text-gray-400">Kepala Keluarga (KK)</span>
                    <h4 class="text-title-sm mt-1 font-bold text-gray-800 dark:text-white/90">
                        {{ $totalKk }}
                    </h4>
                </div>
                <span class="bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-500 flex items-center gap-1 rounded-full py-0.5 px-2.5 text-theme-xs font-medium">
                    KK Aktif
                </span>
            </div>
        </div>

        <!-- Metric Item 3: Belum Rekam KTP -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 dark:border-gray-800 dark:bg-white/[0.03] transition hover:border-warning-500/40">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800">
                <svg class="fill-gray-800 dark:fill-white/90" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M3 5C3 3.89543 3.89543 3 5 3H19C20.1046 3 21 3.89543 21 5V19C21 20.1046 20.1046 21 19 21H5C3.89543 21 3 20.1046 3 19V5ZM5 5H19V19H5V5ZM8 8C8 7.44772 8.44772 7 9 7H15C15.5523 7 16 7.44772 16 8C16 8.55228 15.5523 9 15 9H9C8.44772 9 8 8.55228 8 8ZM8 12C8 11.4477 8.44772 11 9 11H15C15.5523 11 16 11.4477 16 12C16 12.5523 15.5523 13 15 13H9C8.44772 13 8 12.5523 8 12ZM8 16C8 15.4477 8.44772 15 9 15H12C12.5523 15 13 15.4477 13 16C13 16.5523 12.5523 17 12 17H9C8.44772 17 8 16.5523 8 16Z"/>
                </svg>
            </div>
            <div class="mt-5 flex items-end justify-between">
                <div>
                    <span class="text-theme-sm text-gray-500 dark:text-gray-400">Belum Ber-KTP</span>
                    <h4 class="text-title-sm mt-1 font-bold {{ $wargaBelumKtp > 0 ? 'text-warning-600 dark:text-warning-400' : 'text-gray-800 dark:text-white/90' }}">
                        {{ $wargaBelumKtp }}
                    </h4>
                </div>
                <span class="{{ $wargaBelumKtp > 0 ? 'bg-warning-50 text-warning-600 dark:bg-warning-500/15 dark:text-warning-500' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400' }} flex items-center gap-1 rounded-full py-0.5 px-2.5 text-theme-xs font-medium">
                    {{ $wargaBelumKtp > 0 ? 'Perlu Bantuan' : 'Lengkap' }}
                </span>
            </div>
        </div>

        <!-- Metric Item 4: Kas RT Terkumpul -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 dark:border-gray-800 dark:bg-white/[0.03] transition hover:border-success-500/40">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800">
                <svg class="fill-gray-800 dark:fill-white/90" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2ZM13 7C13 6.44772 12.5523 6 12 6C11.4477 6 11 6.44772 11 7V7.07062C9.28913 7.28586 8 8.73699 8 10.5C8 12.433 9.567 14 11.5 14H12.5C13.3284 14 14 14.6716 14 15.5C14 16.3284 13.3284 17 12.5 17H10C9.44772 17 9 17.4477 9 18C9 18.5523 9.44772 19 10 19H11V19.9294C11 20.4817 11.4477 20.9294 12 20.9294C12.5523 20.9294 13 20.4817 13 19.9294V19.9294C14.7109 19.7141 16 18.263 16 16.5C16 14.567 14.433 13 12.5 13H11.5C10.6716 13 10 12.3284 10 11.5C10 10.6716 10.6716 10 11.5 10H14C14.5523 10 15 9.55228 15 9C15 8.44772 14.5523 8 14 8H13V7Z"/>
                </svg>
            </div>
            <div class="mt-5 flex items-end justify-between">
                <div>
                    <span class="text-theme-sm text-gray-500 dark:text-gray-400">Kas RT Terkumpul</span>
                    <h4 class="text-title-sm mt-1 font-bold text-success-600 dark:text-success-400">
                        Rp {{ number_format($totalKasTerkumpul, 0, ',', '.') }}
                    </h4>
                </div>
                <span class="bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500 flex items-center gap-1 rounded-full py-0.5 px-2.5 text-theme-xs font-medium" title="Total tunggakan kas">
                    -Rp {{ number_format($totalKasMenunggak, 0, ',', '.') }}
                </span>
            </div>
        </div>
    </div>

    <!-- MAIN TWO COLUMN: CHARTS & RONDA BANNER (12 Columns TailAdmin Layout) -->
    <div class="grid grid-cols-12 gap-4 md:gap-6">
        <!-- Left: K-Means Clustering Visualizer & Table (col-span-12 xl:col-span-7) -->
        <div class="col-span-12 space-y-6 xl:col-span-7">
            <!-- Chart Card: TailAdmin Chart 01 Style -->
            <div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between pb-4 border-b border-gray-100 dark:border-gray-800">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90 flex items-center gap-2">
                            <span class="flex h-2.5 w-2.5 rounded-full bg-brand-500"></span>
                            Proporsi Analisis K-Means Clustering
                        </h3>
                        <p class="mt-1 text-theme-xs text-gray-500 dark:text-gray-400">
                            @if($latestSession)
                                Sesi Terakhir: <strong>{{ $latestSession->kode_sesi }}</strong> ({{ $latestSession->tanggal_proses->format('d M Y, H:i') }})
                            @else
                                Belum ada sesi clustering yang dijalankan.
                            @endif
                        </p>
                    </div>
                    @if($latestSession)
                    <a
                        href="{{ route('clustering.show', $latestSession->id) }}"
                        class="text-theme-xs font-medium text-brand-500 hover:text-brand-600 dark:text-brand-400 inline-flex items-center gap-1"
                    >
                        Lihat Detail Iterasi
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                    @endif
                </div>

                <!-- Chart Canvas Container -->
                <div class="mt-6 grid grid-cols-1 md:grid-cols-12 gap-6 items-center">
                    <div class="md:col-span-5 h-56 flex items-center justify-center relative">
                        <canvas id="clusterDonutChart"></canvas>
                    </div>

                    <!-- Legend & Descriptions TailAdmin style -->
                    <div class="md:col-span-7 space-y-3">
                        <div class="rounded-xl border border-gray-100 bg-gray-50/80 p-3.5 dark:border-gray-800 dark:bg-white/[0.02]">
                            <div class="flex items-center justify-between">
                                <span class="flex items-center gap-2 text-theme-xs font-semibold text-gray-800 dark:text-white/90">
                                    <span class="h-3 w-3 rounded-full bg-[#f43f5e]"></span>
                                    Cluster 1: Prioritas Utama
                                </span>
                                <span class="text-theme-sm font-bold text-[#f43f5e]">{{ $clusterCounts['cluster_1'] }} Warga</span>
                            </div>
                            <p class="mt-1 text-theme-xs text-gray-500 dark:text-gray-400">Penerima bansos PKH, BLT, sembako rutin RT</p>
                        </div>

                        <div class="rounded-xl border border-gray-100 bg-gray-50/80 p-3.5 dark:border-gray-800 dark:bg-white/[0.02]">
                            <div class="flex items-center justify-between">
                                <span class="flex items-center gap-2 text-theme-xs font-semibold text-gray-800 dark:text-white/90">
                                    <span class="h-3 w-3 rounded-full bg-[#f59e0b]"></span>
                                    Cluster 2: Prioritas Sedang
                                </span>
                                <span class="text-theme-sm font-bold text-[#f59e0b]">{{ $clusterCounts['cluster_2'] }} Warga</span>
                            </div>
                            <p class="mt-1 text-theme-xs text-gray-500 dark:text-gray-400">Subsidi pangan pasar murah & program padat karya RT</p>
                        </div>

                        <div class="rounded-xl border border-gray-100 bg-gray-50/80 p-3.5 dark:border-gray-800 dark:bg-white/[0.02]">
                            <div class="flex items-center justify-between">
                                <span class="flex items-center gap-2 text-theme-xs font-semibold text-gray-800 dark:text-white/90">
                                    <span class="h-3 w-3 rounded-full bg-[#10b981]"></span>
                                    Cluster 3: Mandiri / Mampu
                                </span>
                                <span class="text-theme-sm font-bold text-[#10b981]">{{ $clusterCounts['cluster_3'] }} Warga</span>
                            </div>
                            <p class="mt-1 text-theme-xs text-gray-500 dark:text-gray-400">Keluarga mapan & potensi donatur sosial RT</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table Card: TailAdmin Table 01 Style -->
            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-4 pt-4 pb-3 sm:px-6 dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                            Data Warga Terbaru
                        </h3>
                        <p class="mt-0.5 text-theme-xs text-gray-500 dark:text-gray-400">Pendaftaran warga paling mutakhir di lingkungan RT 03</p>
                    </div>

                    <div class="flex items-center gap-2">
                        <a
                            href="{{ route('warga.index') }}"
                            class="text-theme-xs shadow-theme-xs inline-flex items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-3 py-2 font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"
                        >
                            Lihat Semua ({{ $totalWarga }})
                        </a>
                    </div>
                </div>

                <div class="max-w-full overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="border-b border-gray-100 dark:border-gray-800">
                            <tr>
                                <th class="py-3 pr-4 font-medium text-gray-500 text-start text-theme-xs dark:text-gray-400">Nama Lengkap & NIK</th>
                                <th class="py-3 px-4 font-medium text-gray-500 text-start text-theme-xs dark:text-gray-400">Alamat Blok</th>
                                <th class="py-3 px-4 font-medium text-gray-500 text-start text-theme-xs dark:text-gray-400">Status KTP</th>
                                <th class="py-3 px-4 font-medium text-gray-500 text-start text-theme-xs dark:text-gray-400">Status Iuran</th>
                                <th class="py-3 pl-4 font-medium text-gray-500 text-end text-theme-xs dark:text-gray-400">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @forelse($recentWargas as $warga)
                            <tr class="hover:bg-gray-50/60 dark:hover:bg-white/[0.02]">
                                <td class="py-3 pr-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-brand-50 text-brand-600 text-theme-xs font-bold dark:bg-brand-500/15 dark:text-brand-400">
                                            {{ strtoupper(substr($warga->nama_lengkap, 0, 2)) }}
                                        </div>
                                        <div>
                                            <p class="font-medium text-theme-sm text-gray-800 dark:text-white/90">{{ $warga->nama_lengkap }}</p>
                                            <p class="text-theme-xs text-gray-400">{{ $warga->nik }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-4 text-theme-sm text-gray-600 dark:text-gray-300 font-medium">{{ $warga->alamat_blok }}</td>
                                <td class="py-3 px-4">
                                    @if($warga->status_ktp === 'ada')
                                        <span class="inline-flex items-center rounded-full bg-success-50 px-2.5 py-0.5 text-theme-xs font-medium text-success-600 dark:bg-success-500/15 dark:text-success-500">Ada KTP</span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-warning-50 px-2.5 py-0.5 text-theme-xs font-medium text-warning-600 dark:bg-warning-500/15 dark:text-warning-500">Belum KTP</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    @if($warga->status_iuran === 'lancar')
                                        <span class="inline-flex items-center rounded-full bg-brand-50 px-2.5 py-0.5 text-theme-xs font-medium text-brand-600 dark:bg-brand-500/15 dark:text-brand-400">Lancar</span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-error-50 px-2.5 py-0.5 text-theme-xs font-medium text-error-600 dark:bg-error-500/15 dark:text-error-500">Menunggak</span>
                                    @endif
                                </td>
                                <td class="py-3 pl-4 text-end">
                                    <a
                                        href="{{ route('warga.show', $warga->id) }}"
                                        class="inline-flex items-center rounded-lg border border-gray-200 bg-white px-2.5 py-1 text-theme-xs font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300"
                                    >
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-6 text-center text-theme-xs text-gray-400">Belum ada data warga terdaftar.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right: Ronda Malam & Kas Stats (col-span-12 xl:col-span-5) -->
        <div class="col-span-12 space-y-6 xl:col-span-5">
            <!-- Ronda Malam Terdekat Card -->
            <div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="flex items-center justify-between pb-4 border-b border-gray-100 dark:border-gray-800">
                    <div class="flex items-center gap-2.5">
                        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800">
                            <svg class="h-5 w-5 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-theme-sm font-semibold text-gray-800 dark:text-white/90">Jadwal Ronda Terdekat</h3>
                            <p class="text-theme-xs text-gray-400">Pos Keamanan Lingkungan RT 03</p>
                        </div>
                    </div>
                    <a href="{{ route('ronda.index') }}" class="text-theme-xs font-medium text-brand-500 hover:text-brand-600 dark:text-brand-400">
                        Kelola
                    </a>
                </div>

                @if($upcomingRonda)
                <div class="mt-4 rounded-xl border border-brand-100 bg-brand-50/50 p-4 dark:border-brand-900/40 dark:bg-brand-950/20">
                    <div class="flex items-center justify-between">
                        <span class="rounded-md bg-white px-2 py-0.5 text-theme-xs font-semibold text-brand-700 shadow-theme-xs dark:bg-gray-800 dark:text-brand-400">
                            {{ $upcomingRonda->tanggal_ronda->isoFormat('dddd, D MMMM Y') }}
                        </span>
                        <span class="text-theme-xs font-medium text-gray-600 dark:text-gray-400">
                            {{ $upcomingRonda->shift_ronda }}
                        </span>
                    </div>
                    <p class="mt-2 text-theme-xs text-gray-600 dark:text-gray-300">
                        {{ $upcomingRonda->keterangan_khusus ?? 'Patroli keliling rutin lingkungan RT 03' }}
                    </p>
                </div>

                <div class="mt-4">
                    <p class="text-theme-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-2.5">
                        Petugas Piket ({{ $upcomingRonda->participants->count() }} Orang)
                    </p>
                    <div class="space-y-2">
                        @foreach($upcomingRonda->participants as $p)
                        <div class="flex items-center justify-between rounded-xl border border-gray-100 bg-gray-50/60 p-2.5 dark:border-gray-800 dark:bg-white/[0.02]">
                            <div class="flex items-center gap-2.5">
                                <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-gray-200 text-gray-700 text-theme-xs font-bold dark:bg-gray-700 dark:text-gray-200">
                                    {{ $loop->iteration }}
                                </div>
                                <div>
                                    <p class="text-theme-xs font-semibold text-gray-800 dark:text-white/90">{{ $p->warga->nama_lengkap }}</p>
                                    <p class="text-[11px] text-gray-400">{{ $p->warga->alamat_blok }}</p>
                                </div>
                            </div>
                            <span class="rounded-full px-2.5 py-0.5 text-[11px] font-medium
                                @if($p->status_kehadiran === 'hadir') bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-500
                                @elseif($p->status_kehadiran === 'izin') bg-warning-50 text-warning-600 dark:bg-warning-500/15 dark:text-warning-500
                                @elseif($p->status_kehadiran === 'digantikan') bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400
                                @else bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500 @endif">
                                {{ ucfirst($p->status_kehadiran) }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @else
                <div class="mt-4 py-8 text-center text-theme-xs text-gray-400">
                    Belum ada jadwal ronda yang dibuat.
                    <div class="mt-3">
                        <a href="{{ route('ronda.index') }}" class="rounded-lg bg-brand-500 px-3 py-1.5 text-theme-xs font-medium text-white shadow-theme-xs hover:bg-brand-600">
                            + Buat Jadwal Baru
                        </a>
                    </div>
                </div>
                @endif
            </div>

            <!-- Rekap Kas Bulanan Card -->
            <div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="flex items-center justify-between pb-4 border-b border-gray-100 dark:border-gray-800">
                    <div>
                        <h3 class="text-theme-sm font-semibold text-gray-800 dark:text-white/90">Status Kas RT Bulan Ini</h3>
                        <p class="text-theme-xs text-gray-400">Periode {{ date('F Y') }}</p>
                    </div>
                    <a href="{{ route('kas.index') }}" class="text-theme-xs font-medium text-brand-500 hover:text-brand-600 dark:text-brand-400">
                        Buka Kas
                    </a>
                </div>

                <div class="mt-4 grid grid-cols-2 gap-3">
                    <div class="rounded-xl border border-success-100 bg-success-50/50 p-4 dark:border-success-900/30 dark:bg-success-500/10">
                        <p class="text-theme-xs font-semibold text-success-700 dark:text-success-400">Lunas</p>
                        <p class="mt-1 text-title-xs font-bold text-success-700 dark:text-success-300">Rp {{ number_format($kasBulanIniLunas, 0, ',', '.') }}</p>
                    </div>
                    <div class="rounded-xl border border-error-100 bg-error-50/50 p-4 dark:border-error-900/30 dark:bg-error-500/10">
                        <p class="text-theme-xs font-semibold text-error-700 dark:text-error-400">Belum Lunas</p>
                        <p class="mt-1 text-title-xs font-bold text-error-700 dark:text-error-300">Rp {{ number_format($kasBulanIniBelum, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('clusterDonutChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Prioritas Utama (C1)', 'Prioritas Sedang (C2)', 'Mandiri / Mampu (C3)'],
                    datasets: [{
                        data: [
                            {{ $clusterCounts['cluster_1'] }},
                            {{ $clusterCounts['cluster_2'] }},
                            {{ $clusterCounts['cluster_3'] }}
                        ],
                        backgroundColor: [
                            '#f43f5e', // rose-500 / error
                            '#f59e0b', // amber-500 / warning
                            '#10b981'  // emerald-500 / success
                        ],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    cutout: '72%'
                }
            });
        }
    });
</script>
@endpush
