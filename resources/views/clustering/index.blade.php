@extends('layouts.app')

@section('title', 'Mesin K-Means Clustering')

@section('content')
<!-- Breadcrumb Start -->
<div class="flex flex-wrap items-center justify-between gap-3 pb-6">
    <div>
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Mesin Analisis K-Means Clustering</h2>
        <p class="mt-0.5 text-theme-xs text-gray-500 dark:text-gray-400">
            Pengelompokan otomatis warga penerima prioritas bantuan sosial RT 03 Kelurahan Kedaung
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
            <li class="text-sm text-gray-800 dark:text-white/90">K-Means Clustering</li>
        </ol>
    </nav>
</div>
<!-- Breadcrumb End -->

<div class="space-y-6">
    <!-- Algorithm Concept Info Card -->
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3">
        <div class="flex flex-col gap-3 border-b border-gray-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6 sm:py-5 dark:border-gray-800">
            <div class="flex items-center gap-3">
                <span class="bg-brand-50 text-brand-500 dark:bg-brand-500/15 dark:text-brand-400 flex h-9 w-9 items-center justify-center rounded-lg text-sm font-bold">
                    &sigma;
                </span>
                <div>
                    <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                        Landasan Teori Algoritma &amp; Variabel Klasterisasi
                    </h3>
                    <p class="text-theme-xs text-gray-500 dark:text-gray-400">
                        Perhitungan jarak Euclidean Distance terhadap {{ $totalWarga }} data warga terdaftar
                    </p>
                </div>
            </div>

            <form method="POST" action="{{ route('clustering.run') }}">
                @csrf
                <button
                    type="submit"
                    class="bg-brand-500 shadow-theme-xs hover:bg-brand-600 text-theme-sm inline-flex h-10 items-center gap-2 rounded-lg px-4 py-2.5 font-medium text-white transition"
                >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Jalankan K-Means Sekarang
                </button>
            </form>
        </div>

        <div class="p-5 sm:p-6 space-y-4">
            <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
                Algoritma K-Means mengelompokkan data warga ke dalam <strong>3 Klaster Kebijakan (K=3)</strong> dengan menghitung jarak terdekat ke titik pusat (centroid) menggunakan rumus <em>Euclidean Distance</em>:
            </p>
            <div class="rounded-xl border border-gray-200 bg-gray-50 p-3.5 font-mono text-sm text-center text-gray-800 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-200">
                d(x, c) = &radic; [ (x<sub>usia</sub> - c<sub>usia</sub>)&sup2; + (x<sub>ekonomi</sub> - c<sub>ekonomi</sub>)&sup2; ]
            </div>
            <div class="grid grid-cols-1 gap-4 pt-1 sm:grid-cols-3">
                <div class="rounded-xl border border-error-200 bg-error-50/40 p-4 dark:border-error-500/30 dark:bg-error-500/10">
                    <span class="bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500 inline-flex rounded-full px-2.5 py-0.5 text-theme-xs font-medium">
                        Cluster 1: Prioritas Utama
                    </span>
                    <p class="mt-2 text-theme-xs text-gray-600 dark:text-gray-400">
                        Warga prasejahtera, berhak atas bantuan PKH, BLT, dan sembako rutin RT 03.
                    </p>
                </div>
                <div class="rounded-xl border border-warning-200 bg-warning-50/40 p-4 dark:border-warning-500/30 dark:bg-warning-500/10">
                    <span class="bg-warning-50 text-warning-600 dark:bg-warning-500/15 dark:text-orange-400 inline-flex rounded-full px-2.5 py-0.5 text-theme-xs font-medium">
                        Cluster 2: Prioritas Sedang
                    </span>
                    <p class="mt-2 text-theme-xs text-gray-600 dark:text-gray-400">
                        Warga rentan ekonomi, prioritas kupon pasar murah &amp; program padat karya RT.
                    </p>
                </div>
                <div class="rounded-xl border border-success-200 bg-success-50/40 p-4 dark:border-success-500/30 dark:bg-success-500/10">
                    <span class="bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-500 inline-flex rounded-full px-2.5 py-0.5 text-theme-xs font-medium">
                        Cluster 3: Mandiri / Mampu
                    </span>
                    <p class="mt-2 text-theme-xs text-gray-600 dark:text-gray-400">
                        Warga dengan kondisi ekonomi mapan &amp; calon donatur kegiatan sosial lingkungan.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- History of Clustering Sessions Table Card (Matching Template) -->
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3">
        <div class="flex flex-col gap-2 border-b border-gray-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6 sm:py-5 dark:border-gray-800">
            <div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    Riwayat Eksekusi Algoritma K-Means
                </h3>
                <p class="mt-0.5 text-theme-xs text-gray-500 dark:text-gray-400">
                    Seluruh riwayat sesi, iterasi per langkah, dan matriks jarak tersimpan otomatis
                </p>
            </div>
        </div>

        <div class="custom-scrollbar max-w-full overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                        <th class="px-5 py-3 text-left sm:px-6">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Kode Sesi</p>
                        </th>
                        <th class="px-5 py-3 text-left sm:px-6">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Tanggal &amp; Waktu Proses</p>
                        </th>
                        <th class="px-5 py-3 text-left sm:px-6">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Jumlah Data</p>
                        </th>
                        <th class="px-5 py-3 text-left sm:px-6">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Total Iterasi</p>
                        </th>
                        <th class="px-5 py-3 text-left sm:px-6">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Status</p>
                        </th>
                        <th class="px-5 py-3 text-left sm:px-6">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Eksekutor</p>
                        </th>
                        <th class="px-5 py-3 text-right sm:px-6">
                            <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Aksi</p>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($sessions as $session)
                    <tr class="transition hover:bg-gray-50/60 dark:hover:bg-white/[0.02]">
                        <td class="px-5 py-4 whitespace-nowrap sm:px-6">
                            <div class="flex items-center gap-3">
                                <div class="bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 flex h-10 w-10 shrink-0 items-center justify-center rounded-full text-theme-xs font-bold">
                                    C3
                                </div>
                                <div>
                                    <a href="{{ route('clustering.show', $session->id) }}" class="text-theme-sm font-mono font-medium text-gray-800 hover:text-brand-500 dark:text-white/90 dark:hover:text-brand-400">
                                        {{ $session->kode_sesi }}
                                    </a>
                                    <span class="text-theme-xs block text-gray-500 dark:text-gray-400">
                                        K={{ $session->jumlah_cluster }} Cluster
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap sm:px-6">
                            <p class="text-theme-sm text-gray-700 dark:text-gray-300">
                                {{ $session->tanggal_proses->isoFormat('D MMM Y, HH:mm') }} WIB
                            </p>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap sm:px-6">
                            <p class="text-theme-sm font-medium text-gray-800 dark:text-white/90">
                                {{ $session->total_data_warga }} Warga
                            </p>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap sm:px-6">
                            <span class="bg-brand-50 text-theme-xs text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 inline-flex rounded-full px-2.5 py-0.5 font-medium">
                                {{ $session->total_iterasi }} Iterasi
                            </span>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap sm:px-6">
                            <span class="bg-success-50 text-theme-xs text-success-600 dark:bg-success-500/15 dark:text-success-500 inline-flex items-center rounded-full px-2.5 py-0.5 font-medium">
                                Konvergen
                            </span>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap sm:px-6">
                            <p class="text-theme-sm text-gray-500 dark:text-gray-400">
                                {{ $session->user->name ?? 'Admin RT' }}
                            </p>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap text-right sm:px-6">
                            <div class="relative inline-block text-left" x-data="{ open: false }" @click.outside="open = false">
                                <button
                                    type="button"
                                    @click="open = !open"
                                    class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-gray-500 transition hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-white"
                                >
                                    <svg class="fill-current" width="20" height="20" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M5.99902 10.245C6.96552 10.245 7.74902 11.0285 7.74902 11.995V12.005C7.74902 12.9715 6.96552 13.755 5.99902 13.755C5.03253 13.755 4.24902 12.9715 4.24902 12.005V11.995C4.24902 11.0285 5.03253 10.245 5.99902 10.245ZM17.999 10.245C18.9655 10.245 19.749 11.0285 19.749 11.995V12.005C19.749 12.9715 18.9655 13.755 17.999 13.755C17.0325 13.755 16.249 12.9715 16.249 12.005V11.995C16.249 11.0285 17.0325 10.245 17.999 10.245ZM13.749 11.995C13.749 11.0285 12.9655 10.245 11.999 10.245C11.0325 10.245 10.249 11.0285 10.249 11.995V12.005C10.249 12.9715 11.0325 13.755 11.999 13.755C12.9655 13.755 13.749 12.9715 13.749 12.005V11.995Z"/>
                                    </svg>
                                </button>

                                <div
                                    x-show="open"
                                    x-transition
                                    class="shadow-theme-lg dark:bg-gray-dark absolute right-0 z-40 mt-1 w-44 space-y-1 rounded-xl border border-gray-200 bg-white p-1.5 dark:border-gray-800"
                                    x-cloak
                                >
                                    <a
                                        href="{{ route('clustering.show', $session->id) }}"
                                        class="text-theme-xs flex w-full items-center gap-2 rounded-lg px-3 py-2 text-left font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5"
                                    >
                                        <svg class="h-4 w-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Lihat Detail Hasil
                                    </a>

                                    <a
                                        href="{{ route('clustering.exportPdf', $session->id) }}"
                                        target="_blank"
                                        class="text-theme-xs flex w-full items-center gap-2 rounded-lg px-3 py-2 text-left font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5"
                                    >
                                        <svg class="h-4 w-4 text-error-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        Unduh Laporan PDF
                                    </a>

                                    <a
                                        href="{{ route('clustering.exportExcel', $session->id) }}"
                                        class="text-theme-xs flex w-full items-center gap-2 rounded-lg px-3 py-2 text-left font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5"
                                    >
                                        <svg class="h-4 w-4 text-success-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        Unduh Excel (XLSX)
                                    </a>

                                    <form method="POST" action="{{ route('clustering.destroy', $session->id) }}" onsubmit="return confirm('Hapus sesi clustering ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="text-theme-xs flex w-full items-center gap-2 rounded-lg px-3 py-2 text-left font-medium text-error-600 hover:bg-error-50 dark:text-error-400 dark:hover:bg-error-500/10"
                                        >
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Hapus Sesi
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-5 py-10 text-center sm:px-6">
                            <p class="text-theme-sm text-gray-500 dark:text-gray-400">
                                Belum ada riwayat klasterisasi. Klik tombol "Jalankan K-Means Sekarang" di atas untuk memulai analisis data warga.
                            </p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($sessions->hasPages())
        <div class="border-t border-gray-100 px-5 py-4 sm:px-6 dark:border-gray-800">
            {{ $sessions->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
