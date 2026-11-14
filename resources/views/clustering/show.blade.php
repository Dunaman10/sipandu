@extends('layouts.app')

@section('title', 'Hasil K-Means: ' . $session->kode_sesi)

@section('content')
<!-- Breadcrumb Start -->
<div class="flex flex-wrap items-center justify-between gap-3 pb-6">
    <div>
        <div class="flex items-center gap-2.5">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">{{ $session->kode_sesi }}</h2>
            <span class="bg-success-50 text-theme-xs text-success-600 dark:bg-success-500/15 dark:text-success-500 inline-flex items-center rounded-full px-2.5 py-0.5 font-medium">
                Konvergen
            </span>
        </div>
        <p class="mt-0.5 text-theme-xs text-gray-500 dark:text-gray-400">
            Diproses pada {{ $session->tanggal_proses->isoFormat('D MMMM Y, HH:mm') }} WIB &bull; Total: <strong class="font-medium text-gray-700 dark:text-gray-200">{{ $session->total_data_warga }}</strong> warga &bull; <strong class="font-medium text-gray-700 dark:text-gray-200">{{ $session->total_iterasi }}</strong> Iterasi
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
            <li>
                <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" href="{{ route('clustering.index') }}">
                    K-Means Clustering
                    <svg class="stroke-current" width="17" height="16" viewBox="0 0 17 16" fill="none">
                        <path d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </li>
            <li class="text-sm text-gray-800 dark:text-white/90">Detail Sesi</li>
        </ol>
    </nav>
</div>
<!-- Breadcrumb End -->

<div class="space-y-6" x-data="{ activeTab: 'hasil', searchQuery: '', clusterFilter: '' }">
    <!-- Cluster Breakdown Metric Cards (TailAdmin Style) -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3 md:gap-6">
        <div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 dark:border-gray-800 dark:bg-white/3">
            <div class="flex items-center justify-between">
                <span class="bg-error-50 text-theme-xs text-error-600 dark:bg-error-500/15 dark:text-error-500 rounded-full px-2.5 py-0.5 font-medium">
                    Cluster 1 &bull; Prioritas Utama
                </span>
                <span class="text-title-xs font-bold text-error-600 dark:text-error-400">{{ $cluster1Count }} Warga</span>
            </div>
            <p class="mt-3 text-sm font-semibold text-gray-800 dark:text-white/90">Prioritas Bantuan Sosial Utama</p>
            <p class="mt-1 text-theme-xs text-gray-500 dark:text-gray-400">Warga prasejahtera / ekonomi rendah. Layak menerima PKH, BLT RT, dan bantuan sembako.</p>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 dark:border-gray-800 dark:bg-white/3">
            <div class="flex items-center justify-between">
                <span class="bg-warning-50 text-theme-xs text-warning-600 dark:bg-warning-500/15 dark:text-orange-400 rounded-full px-2.5 py-0.5 font-medium">
                    Cluster 2 &bull; Prioritas Sedang
                </span>
                <span class="text-title-xs font-bold text-warning-600 dark:text-orange-400">{{ $cluster2Count }} Warga</span>
            </div>
            <p class="mt-3 text-sm font-semibold text-gray-800 dark:text-white/90">Prioritas Bantuan Sosial Pendukung</p>
            <p class="mt-1 text-theme-xs text-gray-500 dark:text-gray-400">Warga ekonomi menengah-bawah. Diprioritaskan untuk subsidi pangan murah &amp; program padat karya RT.</p>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 dark:border-gray-800 dark:bg-white/3">
            <div class="flex items-center justify-between">
                <span class="bg-success-50 text-theme-xs text-success-600 dark:bg-success-500/15 dark:text-success-500 rounded-full px-2.5 py-0.5 font-medium">
                    Cluster 3 &bull; Mandiri
                </span>
                <span class="text-title-xs font-bold text-success-600 dark:text-success-400">{{ $cluster3Count }} Warga</span>
            </div>
            <p class="mt-3 text-sm font-semibold text-gray-800 dark:text-white/90">Keluarga Mandiri / Mampu</p>
            <p class="mt-1 text-theme-xs text-gray-500 dark:text-gray-400">Warga dengan ekonomi mapan. Direkomendasikan sebagai motor gotong royong dan calon donatur RT.</p>
        </div>
    </div>

    <!-- Centroid Initialization & Final Centroid Comparison -->
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3">
        <div class="flex flex-col gap-3 border-b border-gray-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6 sm:py-5 dark:border-gray-800">
            <div>
                <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                    Perbandingan Titik Pusat (Centroid) Awal vs. Centroid Akhir
                </h3>
                <p class="text-theme-xs text-gray-500 dark:text-gray-400">
                    Pergeseran nilai titik pusat klaster dari inisialisasi awal hingga mencapai konvergensi
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-2.5">
                <a
                    href="{{ route('clustering.exportPdf', $session->id) }}"
                    target="_blank"
                    class="text-theme-sm shadow-theme-xs inline-flex h-10 items-center gap-2 rounded-lg border border-gray-300 bg-white px-3.5 py-2 font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/5"
                >
                    <svg class="h-4 w-4 text-error-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    PDF
                </a>

                <a
                    href="{{ route('clustering.exportExcel', $session->id) }}"
                    class="text-theme-sm shadow-theme-xs inline-flex h-10 items-center gap-2 rounded-lg border border-gray-300 bg-white px-3.5 py-2 font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/5"
                >
                    <svg class="h-4 w-4 text-success-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Excel (XLSX)
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 p-5 md:grid-cols-2 sm:p-6">
            <!-- Centroid Awal -->
            <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-gray-800">
                <div class="border-b border-gray-100 bg-gray-50/70 px-4 py-3 dark:border-gray-800 dark:bg-white/[0.02]">
                    <p class="flex items-center gap-2 text-sm font-medium text-gray-800 dark:text-white/90">
                        <span class="h-2 w-2 rounded-full bg-brand-500"></span>
                        Centroid Awal (Inisialisasi t=0)
                    </p>
                </div>
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-800">
                            <th class="px-4 py-2.5 text-left text-theme-xs font-medium text-gray-500 dark:text-gray-400">Centroid</th>
                            <th class="px-4 py-2.5 text-left text-theme-xs font-medium text-gray-500 dark:text-gray-400">Usia</th>
                            <th class="px-4 py-2.5 text-left text-theme-xs font-medium text-gray-500 dark:text-gray-400">Skor Ekonomi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 font-mono text-sm dark:divide-gray-800">
                        @foreach($session->centroid_awal_json as $idx => $cAwal)
                        <tr>
                            <td class="px-4 py-2.5 font-semibold text-brand-600 dark:text-brand-400">C{{ $idx + 1 }}</td>
                            <td class="px-4 py-2.5 text-gray-700 dark:text-gray-300">{{ $cAwal['usia'] }}</td>
                            <td class="px-4 py-2.5 text-gray-700 dark:text-gray-300">{{ $cAwal['skor_ekonomi'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Centroid Akhir -->
            <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-gray-800">
                <div class="border-b border-gray-100 bg-success-50/50 px-4 py-3 dark:border-gray-800 dark:bg-success-500/10">
                    <p class="flex items-center gap-2 text-sm font-medium text-gray-800 dark:text-white/90">
                        <span class="h-2 w-2 rounded-full bg-success-500"></span>
                        Centroid Akhir (Konvergen t={{ $session->total_iterasi }})
                    </p>
                </div>
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-800">
                            <th class="px-4 py-2.5 text-left text-theme-xs font-medium text-gray-500 dark:text-gray-400">Centroid</th>
                            <th class="px-4 py-2.5 text-left text-theme-xs font-medium text-gray-500 dark:text-gray-400">Usia</th>
                            <th class="px-4 py-2.5 text-left text-theme-xs font-medium text-gray-500 dark:text-gray-400">Skor Ekonomi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 font-mono text-sm dark:divide-gray-800">
                        @foreach($session->centroid_akhir_json as $idx => $cAkhir)
                        <tr>
                            <td class="px-4 py-2.5 font-semibold text-success-600 dark:text-success-400">C{{ $idx + 1 }}</td>
                            <td class="px-4 py-2.5 font-medium text-gray-800 dark:text-white/90">{{ $cAkhir['usia'] }}</td>
                            <td class="px-4 py-2.5 font-medium text-gray-800 dark:text-white/90">{{ $cAkhir['skor_ekonomi'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="flex flex-wrap items-center gap-2 border-b border-gray-200 pb-3 dark:border-gray-800">
        <button
            type="button"
            @click="activeTab = 'hasil'"
            :class="activeTab === 'hasil' ? 'bg-brand-500 text-white shadow-theme-xs' : 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300'"
            class="rounded-lg px-4 py-2.5 text-sm font-medium transition"
        >
            Tabel Rekomendasi Bantuan Warga ({{ $session->results->count() }})
        </button>
        <button
            type="button"
            @click="activeTab = 'iterasi'"
            :class="activeTab === 'iterasi' ? 'bg-brand-500 text-white shadow-theme-xs' : 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300'"
            class="inline-flex items-center gap-2 rounded-lg px-4 py-2.5 text-sm font-medium transition"
        >
            <span>Langkah &amp; Matriks Jarak Iterasi</span>
            <span class="rounded-full bg-black/15 px-2 py-0.5 text-xs">{{ $session->total_iterasi }} Step</span>
        </button>
    </div>

    <!-- TAB 1: Hasil Rekomendasi Pengelompokan Warga (Template Table Style) -->
    <div x-show="activeTab === 'hasil'" class="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3">
        <!-- Header with Search & Filter -->
        <div class="flex flex-col gap-4 border-b border-gray-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6 sm:py-5 dark:border-gray-800">
            <div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    Hasil Klasifikasi Warga Berdasarkan K-Means
                </h3>
                <p class="mt-0.5 text-theme-xs text-gray-500 dark:text-gray-400">
                    Jarak Euclidean terdekat dan rekomendasi kebijakan bantuan sosial RT 03
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2.5">
                <!-- Search Input -->
                <div class="relative w-full sm:w-64">
                    <span class="pointer-events-none absolute top-1/2 left-3.5 -translate-y-1/2 text-gray-400">
                        <svg class="fill-current" width="18" height="18" viewBox="0 0 20 20" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M3.04175 9.37363C3.04175 5.87693 5.87711 3.04199 9.37508 3.04199C12.8731 3.04199 15.7084 5.87693 15.7084 9.37363C15.7084 12.8703 12.8731 15.7053 9.37508 15.7053C5.87711 15.7053 3.04175 12.8703 3.04175 9.37363ZM9.37508 1.54199C5.04902 1.54199 1.54175 5.04817 1.54175 9.37363C1.54175 13.6991 5.04902 17.2053 9.37508 17.2053C11.2674 17.2053 13.003 16.5344 14.357 15.4176L17.177 18.238C17.4699 18.5309 17.9448 18.5309 18.2377 18.238C18.5306 17.9451 18.5306 17.4703 18.2377 17.1774L15.418 14.3573C16.5365 13.0033 17.2084 11.2669 17.2084 9.37363C17.2084 5.04817 13.7011 1.54199 9.37508 1.54199Z"/>
                        </svg>
                    </span>
                    <input
                        type="text"
                        x-model="searchQuery"
                        placeholder="Cari nama atau NIK..."
                        class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-10 w-full rounded-lg border border-gray-300 bg-transparent py-2 pr-4 pl-10 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                    />
                </div>

                <!-- Filter Cluster -->
                <div class="relative z-20 bg-transparent">
                    <select
                        x-model="clusterFilter"
                        class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-10 appearance-none rounded-lg border border-gray-300 bg-transparent bg-none py-2 pr-9 pl-3.5 text-sm text-gray-700 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                    >
                        <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">Semua Cluster</option>
                        <option value="cluster_1" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">Cluster 1 (Prioritas Utama)</option>
                        <option value="cluster_2" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">Cluster 2 (Prioritas Sedang)</option>
                        <option value="cluster_3" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">Cluster 3 (Mandiri)</option>
                    </select>
                    <span class="pointer-events-none absolute top-1/2 right-3 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                        <svg class="stroke-current" width="16" height="16" viewBox="0 0 20 20" fill="none">
                            <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                </div>
            </div>
        </div>

        <div class="custom-scrollbar max-w-full overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                        <th class="px-5 py-3 text-left sm:px-6">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Nama Lengkap &amp; NIK</p>
                        </th>
                        <th class="px-5 py-3 text-left sm:px-6">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Alamat Blok</p>
                        </th>
                        <th class="px-5 py-3 text-center sm:px-6">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Usia / Skor</p>
                        </th>
                        <th class="px-5 py-3 text-center sm:px-6">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Jarak C1</p>
                        </th>
                        <th class="px-5 py-3 text-center sm:px-6">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Jarak C2</p>
                        </th>
                        <th class="px-5 py-3 text-center sm:px-6">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Jarak C3</p>
                        </th>
                        <th class="px-5 py-3 text-center sm:px-6">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Jarak Min</p>
                        </th>
                        <th class="px-5 py-3 text-left sm:px-6">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Cluster</p>
                        </th>
                        <th class="px-5 py-3 text-left sm:px-6">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Rekomendasi Kebijakan</p>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @foreach($session->results as $res)
                    <tr
                        x-show="(clusterFilter === '' || clusterFilter === '{{ $res->cluster_terpilih }}') && (searchQuery === '' || '{{ strtolower($res->warga->nama_lengkap . ' ' . $res->warga->nik . ' ' . $res->warga->alamat_blok) }}'.includes(searchQuery.toLowerCase()))"
                        class="transition hover:bg-gray-50/60 dark:hover:bg-white/[0.02]"
                    >
                        <td class="px-5 py-4 whitespace-nowrap sm:px-6">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-brand-50 text-brand-600 text-theme-xs font-semibold dark:bg-brand-500/15 dark:text-brand-400">
                                    {{ strtoupper(substr($res->warga->nama_lengkap, 0, 2)) }}
                                </div>
                                <div>
                                    <a href="{{ route('warga.show', $res->warga_id) }}" class="text-theme-sm block font-medium text-gray-800 hover:text-brand-500 dark:text-white/90 dark:hover:text-brand-400">
                                        {{ $res->warga->nama_lengkap }}
                                    </a>
                                    <span class="text-theme-xs block text-gray-500 dark:text-gray-400">
                                        {{ $res->warga->nik }}
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap sm:px-6">
                            <p class="text-theme-sm text-gray-500 dark:text-gray-400">{{ $res->warga->alamat_blok }}</p>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap text-center font-mono text-theme-sm text-gray-700 dark:text-gray-300 sm:px-6">
                            {{ $res->warga->usia }} / {{ $res->warga->skor_ekonomi }}
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap text-center font-mono text-theme-sm sm:px-6 {{ $res->cluster_terpilih === 'cluster_1' ? 'font-semibold text-error-600 dark:text-error-400' : 'text-gray-500 dark:text-gray-400' }}">
                            {{ $res->jarak_c1 }}
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap text-center font-mono text-theme-sm sm:px-6 {{ $res->cluster_terpilih === 'cluster_2' ? 'font-semibold text-warning-600 dark:text-orange-400' : 'text-gray-500 dark:text-gray-400' }}">
                            {{ $res->jarak_c2 }}
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap text-center font-mono text-theme-sm sm:px-6 {{ $res->cluster_terpilih === 'cluster_3' ? 'font-semibold text-success-600 dark:text-success-400' : 'text-gray-500 dark:text-gray-400' }}">
                            {{ $res->jarak_c3 }}
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap text-center font-mono text-theme-sm font-semibold text-gray-800 dark:text-white/90 sm:px-6">
                            {{ $res->jarak_terdekat }}
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap sm:px-6">
                            @if($res->cluster_terpilih === 'cluster_1')
                                <span class="bg-error-50 text-theme-xs text-error-600 dark:bg-error-500/15 dark:text-error-500 inline-flex items-center rounded-full px-2.5 py-0.5 font-medium">
                                    Cluster 1
                                </span>
                            @elseif($res->cluster_terpilih === 'cluster_2')
                                <span class="bg-warning-50 text-theme-xs text-warning-600 dark:bg-warning-500/15 dark:text-orange-400 inline-flex items-center rounded-full px-2.5 py-0.5 font-medium">
                                    Cluster 2
                                </span>
                            @else
                                <span class="bg-success-50 text-theme-xs text-success-600 dark:bg-success-500/15 dark:text-success-500 inline-flex items-center rounded-full px-2.5 py-0.5 font-medium">
                                    Cluster 3
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-4 sm:px-6">
                            <p class="text-theme-sm font-medium text-gray-800 dark:text-white/90">{{ $res->rekomendasi_kebijakan }}</p>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- TAB 2: Jejak Langkah Iterasi K-Means -->
    <div x-show="activeTab === 'iterasi'" class="space-y-6" x-cloak>
        @foreach($session->iterations as $iteration)
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3">
            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-gray-100 px-5 py-4 sm:px-6 sm:py-5 dark:border-gray-800">
                <div class="flex items-center gap-3">
                    <span class="bg-brand-500 flex h-8 w-8 items-center justify-center rounded-lg text-xs font-bold text-white">
                        t={{ $iteration->iterasi_ke }}
                    </span>
                    <h4 class="text-base font-semibold text-gray-800 dark:text-white/90">Iterasi Ke-{{ $iteration->iterasi_ke }}</h4>
                </div>
                <div>
                    @if($iteration->is_konvergen)
                        <span class="bg-success-50 text-theme-xs text-success-600 dark:bg-success-500/15 dark:text-success-500 inline-flex items-center rounded-full px-3 py-1 font-medium">
                            &check; Centroid Konvergen (Stabil)
                        </span>
                    @else
                        <span class="bg-warning-50 text-theme-xs text-warning-600 dark:bg-warning-500/15 dark:text-orange-400 inline-flex items-center rounded-full px-3 py-1 font-medium">
                            Masih Berubah &rarr; Lanjut ke Iterasi {{ $iteration->iterasi_ke + 1 }}
                        </span>
                    @endif
                </div>
            </div>

            <div class="p-5 sm:p-6 space-y-5">
                <!-- Centroid pada iterasi ini -->
                <div>
                    <p class="mb-3 text-theme-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                        Nilai Titik Centroid Iterasi {{ $iteration->iterasi_ke }}
                    </p>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                        @foreach($iteration->centroid_iterasi_json as $cIdx => $cVal)
                        <div class="rounded-xl border border-gray-200 bg-gray-50/60 p-4 dark:border-gray-800 dark:bg-white/[0.02]">
                            <span class="text-sm font-semibold text-brand-600 dark:text-brand-400">Centroid {{ $cIdx + 1 }}</span>
                            <div class="mt-1.5 font-mono text-theme-xs text-gray-600 dark:text-gray-300 space-y-1">
                                <div>Usia: <strong class="text-gray-800 dark:text-white">{{ $cVal['usia'] }}</strong></div>
                                <div>Skor Ekonomi: <strong class="text-gray-800 dark:text-white">{{ $cVal['skor_ekonomi'] }}</strong></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Matriks Jarak -->
                <div>
                    <p class="mb-3 text-theme-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                        Matriks Jarak Euclidean Iterasi {{ $iteration->iterasi_ke }}
                    </p>
                    <div class="custom-scrollbar overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-800">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b border-gray-100 bg-gray-50/70 dark:border-gray-800 dark:bg-white/[0.02]">
                                    <th class="px-5 py-3 text-left text-theme-xs font-medium text-gray-500 dark:text-gray-400">Nama Warga</th>
                                    <th class="px-5 py-3 text-center text-theme-xs font-medium text-gray-500 dark:text-gray-400">Jarak ke C1</th>
                                    <th class="px-5 py-3 text-center text-theme-xs font-medium text-gray-500 dark:text-gray-400">Jarak ke C2</th>
                                    <th class="px-5 py-3 text-center text-theme-xs font-medium text-gray-500 dark:text-gray-400">Jarak ke C3</th>
                                    <th class="px-5 py-3 text-center text-theme-xs font-medium text-gray-500 dark:text-gray-400">Jarak Min</th>
                                    <th class="px-5 py-3 text-center text-theme-xs font-medium text-gray-500 dark:text-gray-400">Cluster Ditugaskan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                @foreach($iteration->matriks_jarak_json as $row)
                                <tr class="transition hover:bg-gray-50/60 dark:hover:bg-white/[0.02]">
                                    <td class="px-5 py-3 text-theme-sm font-medium text-gray-800 dark:text-white/90">{{ $row['nama'] }}</td>
                                    <td class="px-5 py-3 text-center font-mono text-theme-sm text-gray-500 dark:text-gray-400">{{ $row['jarak_c1'] }}</td>
                                    <td class="px-5 py-3 text-center font-mono text-theme-sm text-gray-500 dark:text-gray-400">{{ $row['jarak_c2'] }}</td>
                                    <td class="px-5 py-3 text-center font-mono text-theme-sm text-gray-500 dark:text-gray-400">{{ $row['jarak_c3'] }}</td>
                                    <td class="px-5 py-3 text-center font-mono text-theme-sm font-semibold text-brand-600 dark:text-brand-400">{{ $row['jarak_terdekat'] }}</td>
                                    <td class="px-5 py-3 text-center">
                                        <span class="bg-brand-50 text-theme-xs text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 inline-flex rounded-full px-2.5 py-0.5 font-medium">
                                            Cluster {{ $row['cluster'] }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
