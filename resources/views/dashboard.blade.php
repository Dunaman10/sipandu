@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-12 gap-4 md:gap-6">
    <!-- Top Row: 4 Metric Cards (PRD Modul 2: Total Warga, KK, Warga Belum Punya KTP, Prioritas Bansos) -->
    <div class="col-span-12 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 md:gap-6">
        <!-- Metric Item 1: Total Warga -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 dark:border-gray-800 dark:bg-white/3">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800">
                <svg class="fill-gray-800 dark:fill-white/90" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8.80443 5.60156C7.59109 5.60156 6.60749 6.58517 6.60749 7.79851C6.60749 9.01185 7.59109 9.99545 8.80443 9.99545C10.0178 9.99545 11.0014 9.01185 11.0014 7.79851C11.0014 6.58517 10.0178 5.60156 8.80443 5.60156ZM5.10749 7.79851C5.10749 5.75674 6.76267 4.10156 8.80443 4.10156C10.8462 4.10156 12.5014 5.75674 12.5014 7.79851C12.5014 9.84027 10.8462 11.4955 8.80443 11.4955C6.76267 11.4955 5.10749 9.84027 5.10749 7.79851ZM4.86252 15.3208C4.08769 16.0881 3.70377 17.0608 3.51705 17.8611C3.48384 18.0034 3.5211 18.1175 3.60712 18.2112C3.70161 18.3141 3.86659 18.3987 4.07591 18.3987H13.4249C13.6343 18.3987 13.7992 18.3141 13.8937 18.2112C13.9797 18.1175 14.017 18.0034 13.9838 17.8611C13.7971 17.0608 13.4132 16.0881 12.6383 15.3208C11.8821 14.572 10.6899 13.955 8.75042 13.955C6.81096 13.955 5.61877 14.572 4.86252 15.3208ZM3.8071 14.2549C4.87163 13.2009 6.45602 12.455 8.75042 12.455C11.0448 12.455 12.6292 13.2009 13.6937 14.2549C14.7397 15.2906 15.2207 16.5607 15.4446 17.5202C15.7658 18.8971 14.6071 19.8987 13.4249 19.8987H4.07591C2.89369 19.8987 1.73504 18.8971 2.05628 17.5202C2.28015 16.5607 2.76117 15.2906 3.8071 14.2549ZM15.3042 11.4955C14.4702 11.4955 13.7006 11.2193 13.0821 10.7533C13.3742 10.3314 13.6054 9.86419 13.7632 9.36432C14.1597 9.75463 14.7039 9.99545 15.3042 9.99545C16.5176 9.99545 17.5012 9.01185 17.5012 7.79851C17.5012 6.58517 16.5176 5.60156 15.3042 5.60156C14.7039 5.60156 14.1597 5.84239 13.7632 6.23271C13.6054 5.73284 13.3741 5.26561 13.082 4.84371C13.7006 4.37777 14.4702 4.10156 15.3042 4.10156C17.346 4.10156 19.0012 5.75674 19.0012 7.79851C19.0012 9.84027 17.346 11.4955 15.3042 11.4955ZM19.9248 19.8987H16.3901C16.7014 19.4736 16.9159 18.969 16.9827 18.3987H19.9248C20.1341 18.3987 20.2991 18.3141 20.3936 18.2112C20.4796 18.1175 20.5169 18.0034 20.4837 17.861C20.2969 17.0607 19.913 16.088 19.1382 15.3208C18.4047 14.5945 17.261 13.9921 15.4231 13.9566C15.2232 13.6945 14.9995 13.437 14.7491 13.1891C14.5144 12.9566 14.262 12.7384 13.9916 12.5362C14.3853 12.4831 14.8044 12.4549 15.2503 12.4549C17.5447 12.4549 19.1291 13.2008 20.1936 14.2549C21.2395 15.2906 21.7206 16.5607 21.9444 17.5202C22.2657 18.8971 21.107 19.8987 19.9248 19.8987Z" fill=""/>
                </svg>
            </div>

            <div class="mt-5 flex items-end justify-between">
                <div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Total Warga RT 03</span>
                    <h4 class="text-title-sm mt-2 font-bold text-gray-800 dark:text-white/90">{{ number_format($totalWarga) }}</h4>
                </div>

                <span class="bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-500 flex items-center gap-1 rounded-full py-0.5 pr-2.5 pl-2 text-xs font-semibold">
                    {{ $wargaAdaKtp }} Ber-KTP
                </span>
            </div>
        </div>

        <!-- Metric Item 2: Kepala Keluarga (KK) -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 dark:border-gray-800 dark:bg-white/3">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800">
                <svg class="fill-gray-800 dark:fill-white/90" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.665 3.75621C11.8762 3.65064 12.1247 3.65064 12.3358 3.75621L18.7807 6.97856L12.3358 10.2009C12.1247 10.3065 11.8762 10.3065 11.665 10.2009L5.22014 6.97856L11.665 3.75621ZM4.29297 8.19203V16.0946C4.29297 16.3787 4.45347 16.6384 4.70757 16.7654L11.25 20.0366V11.6513C11.1631 11.6205 11.0777 11.5843 10.9942 11.5426L4.29297 8.19203ZM12.75 20.037L19.2933 16.7654C19.5474 16.6384 19.7079 16.3787 19.7079 16.0946V8.19202L13.0066 11.5426C12.9229 11.5844 12.8372 11.6208 12.75 11.6516V20.037ZM13.0066 2.41456C12.3732 2.09786 11.6277 2.09786 10.9942 2.41456L4.03676 5.89319C3.27449 6.27432 2.79297 7.05342 2.79297 7.90566V16.0946C2.79297 16.9469 3.27448 17.726 4.03676 18.1071L10.9942 21.5857L11.3296 20.9149L10.9942 21.5857C11.6277 21.9024 12.3732 21.9024 13.0066 21.5857L19.9641 18.1071C20.7264 17.726 21.2079 16.9469 21.2079 16.0946V7.90566C21.2079 7.05342 20.7264 6.27432 19.9641 5.89319L13.0066 2.41456Z" fill=""/>
                </svg>
            </div>

            <div class="mt-5 flex items-end justify-between">
                <div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Kepala Keluarga (KK)</span>
                    <h4 class="text-title-sm mt-2 font-bold text-gray-800 dark:text-white/90">{{ number_format($totalKk) }}</h4>
                </div>

                <span class="bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 flex items-center gap-1 rounded-full py-0.5 pr-2.5 pl-2 text-xs font-semibold">
                    KK Terdaftar
                </span>
            </div>
        </div>

        <!-- Metric Item 3: Warga Belum Punya KTP (PRD Modul 2) -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 dark:border-gray-800 dark:bg-white/3">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 dark:bg-amber-950/40">
                <svg class="text-amber-600 dark:text-amber-400 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>

            <div class="mt-5 flex items-end justify-between">
                <div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Belum Ber-KTP</span>
                    <h4 class="text-title-sm mt-2 font-bold text-gray-800 dark:text-white/90">{{ number_format($wargaBelumKtp) }}</h4>
                </div>

                <span class="bg-warning-50 text-warning-600 dark:bg-warning-500/15 dark:text-warning-400 flex items-center gap-1 rounded-full py-0.5 pr-2.5 pl-2 text-xs font-semibold">
                    Perlu KTP
                </span>
            </div>
        </div>

        <!-- Metric Item 4: Warga Prioritas Bantuan Sosial (Hasil K-Means Cluster 1) -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 dark:border-gray-800 dark:bg-white/3">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-rose-50 dark:bg-rose-950/40">
                <svg class="text-rose-600 dark:text-rose-400 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            </div>

            <div class="mt-5 flex items-end justify-between">
                <div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Prioritas Bansos</span>
                    <h4 class="text-title-sm mt-2 font-bold text-gray-800 dark:text-white/90">{{ number_format($clusterCounts['cluster_1']) }}</h4>
                </div>

                <span class="bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500 flex items-center gap-1 rounded-full py-0.5 pr-2.5 pl-2 text-xs font-semibold">
                    Cluster 1
                </span>
            </div>
        </div>
    </div>

    <!-- Left Column: Sebaran Kelompok Usia Warga (col-span-12 xl:col-span-7) -->
    <div class="col-span-12 space-y-6 xl:col-span-7">

        <!-- Chart One: Sebaran Kelompok Usia Warga RT 03 (TailAdmin Bar Chart) -->
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-5 pt-5 sm:px-6 sm:pt-6 dark:border-gray-800 dark:bg-white/3">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                        Sebaran Kelompok Usia Warga
                    </h3>
                    <p class="text-theme-xs text-gray-500 dark:text-gray-400 mt-0.5">
                        Jumlah warga RT 03 berdasarkan rentang usia (tahun)
                    </p>
                </div>

                <div x-data="{openDropDown: false}" class="relative h-fit">
                    <button
                        @click="openDropDown = !openDropDown"
                        :class="openDropDown ? 'text-gray-700 dark:text-white' : 'text-gray-400 hover:text-gray-700 dark:hover:text-white'"
                        class="cursor-pointer"
                    >
                        <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M10.2441 6C10.2441 5.0335 11.0276 4.25 11.9941 4.25H12.0041C12.9706 4.25 13.7541 5.0335 13.7541 6C13.7541 6.9665 12.9706 7.75 12.0041 7.75H11.9941C11.0276 7.75 10.2441 6.9665 10.2441 6ZM10.2441 18C10.2441 17.0335 11.0276 16.25 11.9941 16.25H12.0041C12.9706 16.25 13.7541 17.0335 13.7541 18C13.7541 18.9665 12.9706 19.75 12.0041 19.75H11.9941C11.0276 19.75 10.2441 18.9665 10.2441 18ZM11.9941 10.25C11.0276 10.25 10.2441 11.0335 10.2441 12C10.2441 12.9665 11.0276 13.75 11.9941 13.75H12.0041C12.9706 13.75 13.7541 12.9665 13.7541 12C13.7541 11.0335 12.9706 10.25 12.0041 10.25H11.9941Z" fill=""/>
                        </svg>
                    </button>
                    <div
                        x-show="openDropDown"
                        @click.outside="openDropDown = false"
                        class="shadow-theme-lg dark:bg-gray-dark absolute top-full right-0 z-40 w-48 space-y-1 rounded-2xl border border-gray-200 bg-white p-2 dark:border-gray-800"
                        x-cloak
                    >
                        <a href="{{ route('warga.index') }}" class="text-theme-xs flex w-full rounded-lg px-3 py-2 text-left font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5">
                            Lihat Data Warga
                        </a>
                        <a href="{{ route('warga.exportPdf') }}" target="_blank" class="text-theme-xs flex w-full rounded-lg px-3 py-2 text-left font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5">
                            Cetak Laporan Warga (PDF)
                        </a>
                    </div>
                </div>
            </div>

            <div class="custom-scrollbar max-w-full overflow-x-auto">
                <div id="chartOne" class="-ml-5 h-full min-w-172.5 pl-2 xl:min-w-full"></div>
            </div>
        </div>
    </div>

    <!-- Right Column: Kelengkapan KTP Warga (TailAdmin Radial Gauge) -->
    <div class="col-span-12 xl:col-span-5">
        <div class="rounded-2xl border border-gray-200 bg-gray-100 dark:border-gray-800 dark:bg-white/3">
            <div class="shadow-default rounded-2xl bg-white px-5 pt-5 pb-11 sm:px-6 sm:pt-6 dark:bg-gray-900">
                <div class="flex justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                            Kelengkapan KTP Warga
                        </h3>
                        <p class="text-theme-sm mt-1 text-gray-500 dark:text-gray-400">
                            Persentase warga ber-KTP &bull; RT 03 Kedaung
                        </p>
                    </div>
                </div>

                <!-- Radial Bar Gauge Chart Container -->
                <div class="relative max-h-48.75">
                    <div id="chartTwo" class="h-full"></div>
                    <span class="bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-500 absolute top-[85%] left-1/2 -translate-x-1/2 translate-y-[-85%] rounded-full px-3 py-1 text-xs font-medium">
                        {{ $persentaseKtp }}%
                    </span>
                </div>

                <p class="mx-auto mt-1.5 w-full max-w-95 text-center text-sm text-gray-500 sm:text-base dark:text-gray-400">
                    {{ $wargaAdaKtp }} dari {{ $totalWarga }} warga sudah memiliki KTP.
                </p>
            </div>

            <!-- Bottom Stats with Dividers -->
            <div class="flex items-center justify-center gap-5 px-6 py-3.5 sm:gap-8 sm:py-5">
                <div>
                    <p class="text-theme-xs mb-1 text-center text-gray-500 sm:text-sm dark:text-gray-400">
                        Total Warga
                    </p>
                    <p class="text-center text-base font-semibold text-gray-800 sm:text-lg dark:text-white/90">
                        {{ $totalWarga }}
                    </p>
                </div>

                <div class="h-7 w-px bg-gray-200 dark:bg-gray-800"></div>

                <div>
                    <p class="text-theme-xs mb-1 text-center text-gray-500 sm:text-sm dark:text-gray-400">
                        Ada KTP
                    </p>
                    <p class="text-center text-base font-semibold text-success-600 sm:text-lg dark:text-success-400">
                        {{ $wargaAdaKtp }}
                    </p>
                </div>

                <div class="h-7 w-px bg-gray-200 dark:bg-gray-800"></div>

                <div>
                    <p class="text-theme-xs mb-1 text-center text-gray-500 sm:text-sm dark:text-gray-400">
                        Belum KTP
                    </p>
                    <p class="text-center text-base font-semibold text-error-600 sm:text-lg dark:text-error-400">
                        {{ $wargaBelumKtp }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Three: Evaluasi Partisipasi & Keaktifan Warga (PRD Modul 2, 4, 6 & TailAdmin Area Chart) -->
    <div class="col-span-12">
        <div class="rounded-2xl border border-gray-200 bg-white px-5 pt-5 pb-5 sm:px-6 sm:pt-6 dark:border-gray-800 dark:bg-white/3">
            <div class="mb-6 flex flex-col gap-5 sm:flex-row sm:justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                        Evaluasi Partisipasi Warga RT 03
                    </h3>
                    <p class="text-theme-sm mt-1 text-gray-500 dark:text-gray-400">
                        Perkembangan jumlah warga dan tingkat partisipasi ronda malam
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    <div class="relative">
                        <input
                            class="datepicker text-theme-sm shadow-theme-xs h-10 w-full rounded-lg border border-gray-200 bg-white py-2.5 pr-4 pl-9 font-medium text-gray-700 focus:ring-0 focus:outline-hidden dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 cursor-pointer"
                            readonly="readonly"
                        />
                        <div class="pointer-events-none absolute inset-0 right-auto left-3 flex items-center">
                            <svg class="fill-gray-700 dark:fill-gray-400" width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M6.66683 1.54199C7.08104 1.54199 7.41683 1.87778 7.41683 2.29199V3.00033H12.5835V2.29199C12.5835 1.87778 12.9193 1.54199 13.3335 1.54199C13.7477 1.54199 14.0835 1.87778 14.0835 2.29199V3.00033L15.4168 3.00033C16.5214 3.00033 17.4168 3.89576 17.4168 5.00033V7.50033V15.8337C17.4168 16.9382 16.5214 17.8337 15.4168 17.8337H4.5835C3.47893 17.8337 2.5835 16.9382 2.5835 15.8337V7.50033V5.00033C2.5835 3.89576 3.47893 3.00033 4.5835 3.00033L5.91683 3.00033V2.29199C5.91683 1.87778 6.25262 1.54199 6.66683 1.54199ZM6.66683 4.50033H4.5835C4.30735 4.50033 4.0835 4.72418 4.0835 5.00033V6.75033H15.9168V5.00033C15.9168 4.72418 15.693 4.50033 15.4168 4.50033H13.3335H6.66683ZM15.9168 8.25033H4.0835V15.8337C4.0835 16.1098 4.30735 16.3337 4.5835 16.3337H15.4168C15.693 16.3337 15.9168 16.1098 15.9168 15.8337V8.25033Z" fill=""/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="custom-scrollbar max-w-full overflow-x-auto">
                <div id="chartThree" class="-ml-4 min-w-175 pl-2 xl:min-w-full"></div>
            </div>
        </div>
    </div>

    <!-- Modul 4: Hasil K-Means Clustering Bansos (PRD Modul 4) -->
    <div class="col-span-12 xl:col-span-6">
        <div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 dark:border-gray-800 dark:bg-white/3">
            <div class="flex items-center justify-between pb-4 border-b border-gray-100 dark:border-gray-800">
                <div>
                    <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">
                        Hasil K-Means Clustering Bantuan Sosial
                    </h3>
                    <p class="text-theme-xs text-gray-400">
                        @if($latestSession)
                            Sesi: {{ $latestSession->kode_sesi }} &bull; {{ $latestSession->tanggal_proses->format('d M Y') }}
                        @else
                            Belum ada sesi clustering yang dijalankan
                        @endif
                    </p>
                </div>

                @if(auth()->user()->isAdmin() || auth()->user()->isKetuaRt())
                <form method="POST" action="{{ route('clustering.run') }}">
                    @csrf
                    <button type="submit" class="text-theme-xs inline-flex items-center gap-1.5 rounded-lg bg-brand-500 px-3 py-1.5 font-medium text-white shadow-theme-xs hover:bg-brand-600 transition cursor-pointer">
                        ⚡ Jalankan K-Means
                    </button>
                </form>
                @endif
            </div>

            <div class="mt-4 space-y-3">
                <!-- Cluster 1: Prioritas Utama -->
                <div class="flex items-center justify-between rounded-xl border border-rose-100 bg-rose-50/40 p-3.5 dark:border-rose-900/30 dark:bg-rose-500/10">
                    <div>
                        <span class="inline-flex items-center gap-1.5 text-theme-xs font-bold text-rose-700 dark:text-rose-400">
                            <span class="h-2 w-2 rounded-full bg-rose-500"></span>
                            Cluster 1: Prioritas Utama
                        </span>
                        <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5">Penerima bansos sembako rutin &amp; BLT RT</p>
                    </div>
                    <span class="text-title-xs font-bold text-rose-600 dark:text-rose-400">{{ $clusterCounts['cluster_1'] }} <span class="text-xs font-medium">Warga</span></span>
                </div>

                <!-- Cluster 2: Prioritas Sedang -->
                <div class="flex items-center justify-between rounded-xl border border-amber-100 bg-amber-50/40 p-3.5 dark:border-amber-900/30 dark:bg-amber-500/10">
                    <div>
                        <span class="inline-flex items-center gap-1.5 text-theme-xs font-bold text-amber-700 dark:text-amber-400">
                            <span class="h-2 w-2 rounded-full bg-amber-500"></span>
                            Cluster 2: Prioritas Sedang
                        </span>
                        <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5">Subsidi pasar pangan murah RT</p>
                    </div>
                    <span class="text-title-xs font-bold text-amber-600 dark:text-amber-400">{{ $clusterCounts['cluster_2'] }} <span class="text-xs font-medium">Warga</span></span>
                </div>

                <!-- Cluster 3: Mandiri / Mampu -->
                <div class="flex items-center justify-between rounded-xl border border-emerald-100 bg-emerald-50/40 p-3.5 dark:border-emerald-900/30 dark:bg-emerald-500/10">
                    <div>
                        <span class="inline-flex items-center gap-1.5 text-theme-xs font-bold text-emerald-700 dark:text-emerald-400">
                            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                            Cluster 3: Mandiri / Mampu
                        </span>
                        <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5">Keluarga mandiri &amp; calon donatur sosial</p>
                    </div>
                    <span class="text-title-xs font-bold text-emerald-600 dark:text-emerald-400">{{ $clusterCounts['cluster_3'] }} <span class="text-xs font-medium">Warga</span></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Modul 6: Jadwal Ronda Malam Terdekat (PRD Modul 6) -->
    <div class="col-span-12 xl:col-span-6">
        <div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 dark:border-gray-800 dark:bg-white/3">
            <div class="flex items-center justify-between pb-4 border-b border-gray-100 dark:border-gray-800">
                <div>
                    <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">Jadwal Ronda Malam Terdekat</h3>
                    <p class="text-theme-xs text-gray-400">Pos Keamanan Lingkungan RT 03 Kedaung</p>
                </div>
                <a href="{{ route('ronda.index') }}" class="text-theme-xs font-medium text-brand-500 hover:text-brand-600 dark:text-brand-400">
                    Kelola Jadwal &rarr;
                </a>
            </div>

            @if($upcomingRonda)
            <div class="mt-4 rounded-xl border border-brand-100 bg-brand-50/40 p-4 dark:border-brand-900/40 dark:bg-brand-950/20">
                <div class="flex items-center justify-between">
                    <span class="rounded-md bg-white px-2 py-0.5 text-theme-xs font-semibold text-brand-700 shadow-theme-xs dark:bg-gray-800 dark:text-brand-400">
                        {{ $upcomingRonda->tanggal_ronda->isoFormat('dddd, D MMMM Y') }}
                    </span>
                    <span class="text-theme-xs font-medium text-gray-600 dark:text-gray-400">
                        Shift: {{ $upcomingRonda->shift_ronda }}
                    </span>
                </div>
                <p class="mt-2 text-theme-xs text-gray-600 dark:text-gray-300">
                    {{ $upcomingRonda->keterangan_khusus ?? 'Patroli keliling malam rutin lingkungan RT 03' }}
                </p>
            </div>

            <div class="mt-4 space-y-2">
                <p class="text-theme-xs font-semibold uppercase tracking-wider text-gray-400">
                    Petugas Piket ({{ $upcomingRonda->participants->count() }} Orang):
                </p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                    @foreach($upcomingRonda->participants->take(4) as $p)
                    <div class="flex items-center justify-between rounded-lg border border-gray-100 bg-gray-50/70 p-2 dark:border-gray-800 dark:bg-white/[0.02]">
                        <span class="text-theme-xs font-semibold text-gray-800 dark:text-white/90 truncate">{{ $p->warga->nama_lengkap }}</span>
                        <span class="text-[10px] text-gray-400 font-medium">
                            {{ $p->warga->alamat_blok }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
            @else
            <div class="mt-4 py-8 text-center text-theme-xs text-gray-400">
                Belum ada jadwal ronda yang dibuat.
            </div>
            @endif
        </div>
    </div>

    <!-- Modul 3: Tabel Data Warga Terbaru (PRD Modul 3 & TailAdmin Table One Style) -->
    <div class="col-span-12">
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-4 pt-4 pb-3 sm:px-6 dark:border-gray-800 dark:bg-white/3">
            <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                        Pendaftaran Data Warga Terbaru
                    </h3>
                    <p class="text-theme-xs text-gray-500 dark:text-gray-400">Data kependudukan terbaru di lingkungan RT 03 Kelurahan Kedaung</p>
                </div>

                <div class="flex items-center gap-2">
                    @if(auth()->user()->isAdmin() || auth()->user()->isKetuaRt())
                    <a
                        href="{{ route('warga.create') }}"
                        class="text-theme-xs inline-flex items-center gap-1.5 rounded-lg bg-brand-500 px-3 py-2 font-medium text-white shadow-theme-xs hover:bg-brand-600 transition cursor-pointer"
                    >
                        + Tambah Warga
                    </a>
                    @endif
                    <a
                        href="{{ route('warga.index') }}"
                        class="text-theme-xs shadow-theme-xs inline-flex items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-3 py-2 font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/5"
                    >
                        Lihat Semua ({{ $totalWarga }})
                    </a>
                </div>
            </div>

            <div class="max-w-full overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="border-b border-gray-100 dark:border-gray-800">
                        <tr>
                            <th class="py-3 pr-4 font-medium text-gray-500 text-start text-theme-xs dark:text-gray-400">Nama &amp; NIK</th>
                            <th class="py-3 px-4 font-medium text-gray-500 text-start text-theme-xs dark:text-gray-400">Alamat Blok</th>
                            <th class="py-3 px-4 font-medium text-gray-500 text-start text-theme-xs dark:text-gray-400">Status KTP</th>
                            <th class="py-3 px-4 font-medium text-gray-500 text-start text-theme-xs dark:text-gray-400">Pekerjaan</th>
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
                            <td class="py-3 px-4 text-theme-sm text-gray-600 dark:text-gray-300">{{ $warga->pekerjaan ?? '-' }}</td>
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
</div>

@push('scripts')
<script>
    window.usiaLabels = @json($usiaLabels);
    window.usiaData = @json($usiaData);
    window.ktpPercent = {{ $persentaseKtp }};
</script>
@endpush
@endsection
