@extends('layouts.app')

@section('title', 'Mesin K-Means Clustering')
@section('page_title', 'Mesin Algoritma K-Means Clustering')

@section('content')
<div class="space-y-6">
    <!-- Header with Action -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-gray-900 dark:text-white">Mesin Analisis K-Means Clustering</h2>
            <p class="text-xs text-gray-500 dark:text-gray-400">Pengelompokan otomatis warga penerima prioritas bantuan sosial RT 03 Kelurahan Kedaung</p>
        </div>

        <form method="POST" action="{{ route('clustering.run') }}">
            @csrf
            <button
                type="submit"
                class="inline-flex items-center gap-2 rounded-xl bg-emerald-500 px-5 py-2.5 text-xs font-bold text-white shadow-md shadow-emerald-500/25 hover:bg-emerald-600 transition"
            >
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                Jalankan K-Means Clustering Sekarang
            </button>
        </form>
    </div>

    <!-- Algorithm Concept Info Card -->
    <div class="rounded-3xl border border-gray-200/80 bg-white p-6 shadow-xs dark:border-gray-800 dark:bg-gray-900">
        <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-2 flex items-center gap-2">
            <span class="flex h-6 w-6 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700 text-xs font-bold dark:bg-emerald-900/60 dark:text-emerald-300">&sigma;</span>
            Landasan Teori Algoritma &amp; Variabel Klasterisasi
        </h3>
        <p class="text-xs text-gray-600 dark:text-gray-300 leading-relaxed">
            Algoritma K-Means mengelompokkan data warga ke dalam <strong>3 Klaster Kebijakan (K=3)</strong> dengan menghitung jarak terdekat ke titik pusat (centroid) menggunakan rumus <em>Euclidean Distance</em>:
        </p>
        <div class="my-3 rounded-2xl bg-gray-50 p-3 font-mono text-xs text-center text-gray-800 dark:bg-gray-800 dark:text-gray-200">
            d(x, c) = &radic; [ (x<sub>usia</sub> - c<sub>usia</sub>)&sup2; + (x<sub>ekonomi</sub> - c<sub>ekonomi</sub>)&sup2; + (x<sub>tanggungan</sub> - c<sub>tanggungan</sub>)&sup2; + (x<sub>rumah</sub> - c<sub>rumah</sub>)&sup2; ]
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2 text-xs">
            <div class="rounded-xl border border-rose-100 bg-rose-50/60 p-3 dark:border-rose-900/30 dark:bg-rose-950/20">
                <p class="font-bold text-rose-800 dark:text-rose-300">Cluster 1: Prioritas Utama</p>
                <p class="mt-1 text-[11px] text-rose-600 dark:text-rose-400">Warga prasejahtera, berhak atas bantuan PKH, BLT, dan sembako rutin RT 03.</p>
            </div>
            <div class="rounded-xl border border-amber-100 bg-amber-50/60 p-3 dark:border-amber-900/30 dark:bg-amber-950/20">
                <p class="font-bold text-amber-800 dark:text-amber-300">Cluster 2: Prioritas Sedang</p>
                <p class="mt-1 text-[11px] text-amber-600 dark:text-amber-400">Warga rentan ekonomi, prioritas kupon pasar murah & program padat karya RT.</p>
            </div>
            <div class="rounded-xl border border-emerald-100 bg-emerald-50/60 p-3 dark:border-emerald-900/30 dark:bg-emerald-950/20">
                <p class="font-bold text-emerald-800 dark:text-emerald-300">Cluster 3: Mandiri / Mampu</p>
                <p class="mt-1 text-[11px] text-emerald-600 dark:text-emerald-400">Warga dengan kondisi ekonomi mapan & calon donatur kegiatan sosial lingkungan.</p>
            </div>
        </div>
    </div>

    <!-- History of Clustering Sessions -->
    <div class="rounded-3xl border border-gray-200/80 bg-white shadow-xs dark:border-gray-800 dark:bg-gray-900 overflow-hidden">
        <div class="p-6 border-b border-gray-100 dark:border-gray-800">
            <h3 class="text-base font-bold text-gray-900 dark:text-white">Riwayat Eksekusi Algoritma K-Means</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400">Seluruh riwayat sesi, iterasi per langkah, dan matriks jarak tersimpan untuk keperluan sidang skripsi</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="border-b border-gray-200 bg-gray-50/70 text-gray-500 dark:border-gray-800 dark:bg-gray-800/50 uppercase tracking-wider font-semibold">
                    <tr>
                        <th class="py-3.5 px-4">No</th>
                        <th class="py-3.5 px-4">Kode Sesi</th>
                        <th class="py-3.5 px-4">Tanggal & Waktu Proses</th>
                        <th class="py-3.5 px-4">Jumlah Data</th>
                        <th class="py-3.5 px-4">Total Iterasi</th>
                        <th class="py-3.5 px-4">Status Konvergensi</th>
                        <th class="py-3.5 px-4">Dijalankan Oleh</th>
                        <th class="py-3.5 px-4 text-center">Aksi &amp; Laporan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-gray-700 dark:text-gray-300">
                    @forelse($sessions as $session)
                    <tr class="hover:bg-gray-50/70 dark:hover:bg-gray-800/40 transition">
                        <td class="py-3.5 px-4 text-gray-400 font-medium">
                            {{ $loop->iteration + ($sessions->currentPage() - 1) * $sessions->perPage() }}
                        </td>
                        <td class="py-3.5 px-4">
                            <a href="{{ route('clustering.show', $session->id) }}" class="font-mono font-bold text-brand-600 hover:text-brand-700 dark:text-brand-400">
                                {{ $session->kode_sesi }}
                            </a>
                        </td>
                        <td class="py-3.5 px-4 text-gray-800 dark:text-gray-200 font-medium">
                            {{ $session->tanggal_proses->isoFormat('D MMMM Y, HH:mm') }} WIB
                        </td>
                        <td class="py-3.5 px-4 font-bold">{{ $session->total_data_warga }} Warga</td>
                        <td class="py-3.5 px-4">
                            <span class="inline-flex items-center gap-1 font-bold text-gray-900 dark:text-white">
                                {{ $session->total_iterasi }} Iterasi
                            </span>
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="rounded-full bg-emerald-100 px-2.5 py-0.5 text-[10px] font-bold text-emerald-800 dark:bg-emerald-950/70 dark:text-emerald-300">
                                &check; Konvergen
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-gray-500">{{ $session->user->name ?? 'Admin RT' }}</td>
                        <td class="py-3.5 px-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a
                                    href="{{ route('clustering.show', $session->id) }}"
                                    class="inline-flex items-center gap-1 rounded-lg bg-brand-50 px-2.5 py-1 text-[11px] font-bold text-brand-700 hover:bg-brand-100 dark:bg-brand-950/60 dark:text-brand-300"
                                >
                                    Detail Hasil
                                </a>
                                <a
                                    href="{{ route('clustering.exportPdf', $session->id) }}"
                                    target="_blank"
                                    class="rounded-lg p-1 text-gray-400 hover:text-rose-600"
                                    title="Cetak Dokumen PDF"
                                >
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('clustering.destroy', $session->id) }}" onsubmit="return confirm('Hapus sesi clustering ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1 text-gray-400 hover:text-rose-600" title="Hapus Sesi">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="py-8 text-center text-gray-400">
                            Belum ada riwayat klasterisasi. Klik tombol "Jalankan K-Means Clustering Sekarang" di atas untuk memulai analisis data warga.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($sessions->hasPages())
        <div class="p-4 border-t border-gray-100 dark:border-gray-800">
            {{ $sessions->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
