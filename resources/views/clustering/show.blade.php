@extends('layouts.app')

@section('title', 'Hasil K-Means: ' . $session->kode_sesi)
@section('page_title', 'Hasil Analisis K-Means Clustering')

@section('content')
<div class="space-y-6" x-data="{ activeTab: 'hasil' }">
    <!-- Header with Back & PDF Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('clustering.index') }}" class="rounded-xl border border-gray-200 bg-white p-2 text-gray-500 hover:bg-gray-100 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-400">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <div class="flex items-center gap-2">
                    <h2 class="text-xl font-extrabold text-gray-900 dark:text-white">{{ $session->kode_sesi }}</h2>
                    <span class="rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-bold text-emerald-800 dark:bg-emerald-950/70 dark:text-emerald-300">Konvergen</span>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    Diproses pada {{ $session->tanggal_proses->isoFormat('D MMMM Y, HH:mm') }} WIB &bull; Total: <strong>{{ $session->total_data_warga }}</strong> warga &bull; <strong>{{ $session->total_iterasi }}</strong> Iterasi pembaruan centroid
                </p>
            </div>
        </div>

        <div class="flex items-center gap-2.5">
            <a
                href="{{ route('clustering.exportPdf', $session->id) }}"
                target="_blank"
                class="inline-flex items-center gap-2 rounded-xl bg-rose-600 px-4 py-2.5 text-xs font-bold text-white shadow-md shadow-rose-600/25 hover:bg-rose-700 transition"
            >
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Cetak Laporan K-Means PDF
            </a>
        </div>
    </div>

    <!-- Cluster Breakdown Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="rounded-3xl border border-rose-200/80 bg-rose-50/50 p-5 dark:border-rose-900/40 dark:bg-rose-950/20 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="rounded-lg bg-rose-100 px-2 py-0.5 text-xs font-bold text-rose-800 dark:bg-rose-900/60 dark:text-rose-300">Cluster 1</span>
                <span class="text-2xl font-black text-rose-700 dark:text-rose-300">{{ $cluster1Count }} Warga</span>
            </div>
            <p class="mt-2 text-xs font-bold text-rose-900 dark:text-rose-200">Prioritas Bantuan Sosial Utama</p>
            <p class="mt-1 text-[11px] text-rose-600 dark:text-rose-400">Warga prasejahtera / ekonomi rendah dengan tanggungan keluarga tinggi. Layak menerima PKH, BLT RT, dan bantuan sembako.</p>
        </div>

        <div class="rounded-3xl border border-amber-200/80 bg-amber-50/50 p-5 dark:border-amber-900/40 dark:bg-amber-950/20 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="rounded-lg bg-amber-100 px-2 py-0.5 text-xs font-bold text-amber-800 dark:bg-amber-900/60 dark:text-amber-300">Cluster 2</span>
                <span class="text-2xl font-black text-amber-700 dark:text-amber-300">{{ $cluster2Count }} Warga</span>
            </div>
            <p class="mt-2 text-xs font-bold text-amber-900 dark:text-amber-200">Prioritas Bantuan Sosial Pendukung</p>
            <p class="mt-1 text-[11px] text-amber-600 dark:text-amber-400">Warga dengan ekonomi menengah-bawah. Diprioritaskan untuk subsidi pangan murah & keterlibatan program padat karya RT.</p>
        </div>

        <div class="rounded-3xl border border-emerald-200/80 bg-emerald-50/50 p-5 dark:border-emerald-900/40 dark:bg-emerald-950/20 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="rounded-lg bg-emerald-100 px-2 py-0.5 text-xs font-bold text-emerald-800 dark:bg-emerald-900/60 dark:text-emerald-300">Cluster 3</span>
                <span class="text-2xl font-black text-emerald-700 dark:text-emerald-300">{{ $cluster3Count }} Warga</span>
            </div>
            <p class="mt-2 text-xs font-bold text-emerald-900 dark:text-emerald-200">Mandiri / Mampu</p>
            <p class="mt-1 text-[11px] text-emerald-600 dark:text-emerald-400">Warga dengan ekonomi mapan dan hunian layak. Direkomendasikan sebagai motor gotong royong dan calon donatur RT.</p>
        </div>
    </div>

    <!-- Centroid Initialization & Final Centroid Comparison -->
    <div class="rounded-3xl border border-gray-200/80 bg-white p-6 shadow-xs dark:border-gray-800 dark:bg-gray-900">
        <h3 class="text-sm font-bold text-gray-900 dark:text-white pb-3 border-b border-gray-100 dark:border-gray-800">
            Perbandingan Titik Pusat (Centroid) Awal vs. Centroid Akhir
        </h3>

        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6 text-xs">
            <!-- Centroid Awal -->
            <div class="rounded-2xl border border-gray-200 bg-gray-50/70 p-4 dark:border-gray-800 dark:bg-gray-800/50">
                <p class="font-bold text-gray-900 dark:text-white mb-2 flex items-center gap-1.5">
                    <span class="h-2 w-2 rounded-full bg-brand-500"></span>
                    Centroid Awal (Inisialisasi t=0)
                </p>
                <table class="w-full text-left">
                    <thead class="text-gray-400 uppercase font-semibold border-b border-gray-200 dark:border-gray-700">
                        <tr>
                            <th class="pb-1.5">Centroid</th>
                            <th class="pb-1.5">Usia</th>
                            <th class="pb-1.5">Skor Ekonomi</th>
                            <th class="pb-1.5">Tanggungan</th>
                            <th class="pb-1.5">Skor Rumah</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700 font-mono">
                        @foreach($session->centroid_awal_json as $idx => $cAwal)
                        <tr>
                            <td class="py-1.5 font-bold text-brand-600 dark:text-brand-400">C{{ $idx + 1 }}</td>
                            <td class="py-1.5">{{ $cAwal['usia'] }}</td>
                            <td class="py-1.5">{{ $cAwal['skor_ekonomi'] }}</td>
                            <td class="py-1.5">{{ $cAwal['jumlah_tanggungan'] }}</td>
                            <td class="py-1.5">{{ $cAwal['skor_kondisi_rumah'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Centroid Akhir -->
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50/50 p-4 dark:border-emerald-900/40 dark:bg-emerald-950/20">
                <p class="font-bold text-emerald-900 dark:text-emerald-200 mb-2 flex items-center gap-1.5">
                    <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                    Centroid Akhir (Konvergen t={{ $session->total_iterasi }})
                </p>
                <table class="w-full text-left">
                    <thead class="text-emerald-800/60 dark:text-emerald-300/60 uppercase font-semibold border-b border-emerald-200 dark:border-emerald-800">
                        <tr>
                            <th class="pb-1.5">Centroid</th>
                            <th class="pb-1.5">Usia</th>
                            <th class="pb-1.5">Skor Ekonomi</th>
                            <th class="pb-1.5">Tanggungan</th>
                            <th class="pb-1.5">Skor Rumah</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-emerald-200 dark:divide-emerald-800/60 font-mono text-emerald-950 dark:text-emerald-200 font-semibold">
                        @foreach($session->centroid_akhir_json as $idx => $cAkhir)
                        <tr>
                            <td class="py-1.5 font-bold text-emerald-700 dark:text-emerald-300">C{{ $idx + 1 }}</td>
                            <td class="py-1.5">{{ $cAkhir['usia'] }}</td>
                            <td class="py-1.5">{{ $cAkhir['skor_ekonomi'] }}</td>
                            <td class="py-1.5">{{ $cAkhir['jumlah_tanggungan'] }}</td>
                            <td class="py-1.5">{{ $cAkhir['skor_kondisi_rumah'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs: Hasil Rekomendasi vs Jejak Iterasi (Skripsi) -->
    <div class="flex items-center gap-2 border-b border-gray-200 dark:border-gray-800 pb-2">
        <button
            @click="activeTab = 'hasil'"
            :class="activeTab === 'hasil' ? 'bg-brand-500 text-white shadow-xs' : 'bg-white text-gray-700 hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700'"
            class="rounded-xl px-4 py-2 text-xs font-bold transition"
        >
            Tabel Rekomendasi Bantuan Warga ({{ $session->results->count() }})
        </button>
        <button
            @click="activeTab = 'iterasi'"
            :class="activeTab === 'iterasi' ? 'bg-brand-500 text-white shadow-xs' : 'bg-white text-gray-700 hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700'"
            class="rounded-xl px-4 py-2 text-xs font-bold transition flex items-center gap-1.5"
        >
            <span>Langkah & Matriks Jarak Iterasi</span>
            <span class="rounded-full bg-white/20 px-1.5 py-0.2 text-[10px]">{{ $session->total_iterasi }} Step</span>
        </button>
    </div>

    <!-- TAB 1: Hasil Rekomendasi Pengelompokan Warga -->
    <div x-show="activeTab === 'hasil'" class="rounded-3xl border border-gray-200/80 bg-white shadow-xs dark:border-gray-800 dark:bg-gray-900 overflow-hidden">
        <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <div>
                <h3 class="text-base font-bold text-gray-900 dark:text-white">Hasil Klasifikasi Warga Berdasarkan K-Means</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400">Jarak Euclidean terdekat dan rekomendasi kebijakan bantuan sosial RT 03</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="border-b border-gray-200 bg-gray-50/70 text-gray-500 dark:border-gray-800 dark:bg-gray-800/50 uppercase tracking-wider font-semibold">
                    <tr>
                        <th class="py-3.5 px-4">No</th>
                        <th class="py-3.5 px-4">Nama Lengkap & NIK</th>
                        <th class="py-3.5 px-4">Alamat Blok</th>
                        <th class="py-3.5 px-4 text-center">Atribut (Usia / Eko / Tgg / Rmh)</th>
                        <th class="py-3.5 px-4 font-mono text-center">Jarak C1</th>
                        <th class="py-3.5 px-4 font-mono text-center">Jarak C2</th>
                        <th class="py-3.5 px-4 font-mono text-center">Jarak C3</th>
                        <th class="py-3.5 px-4 font-mono text-center">Jarak Terdekat</th>
                        <th class="py-3.5 px-4">Cluster Terpilih</th>
                        <th class="py-3.5 px-4">Rekomendasi Kebijakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-gray-700 dark:text-gray-300">
                    @foreach($session->results as $res)
                    <tr class="hover:bg-gray-50/70 dark:hover:bg-gray-800/40 transition">
                        <td class="py-3 px-4 text-gray-400 font-medium">{{ $loop->iteration }}</td>
                        <td class="py-3 px-4">
                            <a href="{{ route('warga.show', $res->warga_id) }}" class="font-bold text-gray-900 dark:text-white hover:text-brand-600 block">
                                {{ $res->warga->nama_lengkap }}
                            </a>
                            <span class="text-[11px] text-gray-400">{{ $res->warga->nik }}</span>
                        </td>
                        <td class="py-3 px-4">{{ $res->warga->alamat_blok }}</td>
                        <td class="py-3 px-4 text-center font-mono">
                            {{ $res->warga->usia }} / {{ $res->warga->skor_ekonomi }} / {{ $res->warga->jumlah_tanggungan }} / {{ $res->warga->skor_kondisi_rumah }}
                        </td>
                        <td class="py-3 px-4 font-mono text-center {{ $res->cluster_terpilih === 'cluster_1' ? 'font-bold text-rose-600 bg-rose-50/50 dark:bg-rose-950/20' : 'text-gray-500' }}">
                            {{ $res->jarak_c1 }}
                        </td>
                        <td class="py-3 px-4 font-mono text-center {{ $res->cluster_terpilih === 'cluster_2' ? 'font-bold text-amber-600 bg-amber-50/50 dark:bg-amber-950/20' : 'text-gray-500' }}">
                            {{ $res->jarak_c2 }}
                        </td>
                        <td class="py-3 px-4 font-mono text-center {{ $res->cluster_terpilih === 'cluster_3' ? 'font-bold text-emerald-600 bg-emerald-50/50 dark:bg-emerald-950/20' : 'text-gray-500' }}">
                            {{ $res->jarak_c3 }}
                        </td>
                        <td class="py-3 px-4 font-mono text-center font-bold text-gray-900 dark:text-white">
                            {{ $res->jarak_terdekat }}
                        </td>
                        <td class="py-3 px-4">
                            @if($res->cluster_terpilih === 'cluster_1')
                                <span class="rounded-full bg-rose-100 px-2.5 py-0.5 text-[10px] font-bold text-rose-800 dark:bg-rose-950/80 dark:text-rose-300">Cluster 1</span>
                            @elseif($res->cluster_terpilih === 'cluster_2')
                                <span class="rounded-full bg-amber-100 px-2.5 py-0.5 text-[10px] font-bold text-amber-800 dark:bg-amber-950/80 dark:text-amber-300">Cluster 2</span>
                            @else
                                <span class="rounded-full bg-emerald-100 px-2.5 py-0.5 text-[10px] font-bold text-emerald-800 dark:bg-emerald-950/80 dark:text-emerald-300">Cluster 3</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 font-semibold text-gray-800 dark:text-gray-200">
                            {{ $res->rekomendasi_kebijakan }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- TAB 2: Jejak Langkah Iterasi K-Means (Skripsi Feature) -->
    <div x-show="activeTab === 'iterasi'" class="space-y-6" x-cloak>
        @foreach($session->iterations as $iteration)
        <div class="rounded-3xl border border-gray-200/80 bg-white p-6 shadow-xs dark:border-gray-800 dark:bg-gray-900">
            <div class="flex items-center justify-between pb-4 border-b border-gray-100 dark:border-gray-800">
                <div class="flex items-center gap-2">
                    <span class="flex h-7 w-7 items-center justify-center rounded-xl bg-brand-500 font-bold text-white text-xs">
                        t={{ $iteration->iterasi_ke }}
                    </span>
                    <h4 class="text-sm font-bold text-gray-900 dark:text-white">Iterasi Ke-{{ $iteration->iterasi_ke }}</h4>
                </div>
                <div>
                    @if($iteration->is_konvergen)
                        <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-800 dark:bg-emerald-950/70 dark:text-emerald-300">
                            &check; Centroid Konvergen (Stabil)
                        </span>
                    @else
                        <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-bold text-amber-800 dark:bg-amber-950/70 dark:text-amber-300">
                            Masih Berubah &rarr; Lanjut ke Iterasi {{ $iteration->iterasi_ke + 1 }}
                        </span>
                    @endif
                </div>
            </div>

            <!-- Centroid pada iterasi ini -->
            <div class="mt-4">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nilai Titik Centroid Iterasi {{ $iteration->iterasi_ke }}</p>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    @foreach($iteration->centroid_iterasi_json as $cIdx => $cVal)
                    <div class="rounded-2xl border border-gray-200 bg-gray-50/60 p-3 text-xs dark:border-gray-800 dark:bg-gray-800/40">
                        <span class="font-bold text-brand-600 dark:text-brand-400">Centroid {{ $cIdx + 1 }}</span>
                        <div class="mt-1 font-mono text-[11px] text-gray-600 dark:text-gray-300 space-y-0.5">
                            <div>Usia: <strong>{{ $cVal['usia'] }}</strong></div>
                            <div>Skor Ekonomi: <strong>{{ $cVal['skor_ekonomi'] }}</strong></div>
                            <div>Tanggungan: <strong>{{ $cVal['jumlah_tanggungan'] }}</strong></div>
                            <div>Kondisi Rumah: <strong>{{ $cVal['skor_kondisi_rumah'] }}</strong></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Matriks Jarak Sampel (Top 5 data warga) -->
            <div class="mt-4">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Matriks Jarak Euclidean Iterasi {{ $iteration->iterasi_ke }}</p>
                <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-800">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-gray-50 text-gray-500 dark:bg-gray-800 font-semibold border-b border-gray-200 dark:border-gray-700">
                            <tr>
                                <th class="p-2.5">Nama Warga</th>
                                <th class="p-2.5 font-mono text-center">Jarak ke C1</th>
                                <th class="p-2.5 font-mono text-center">Jarak ke C2</th>
                                <th class="p-2.5 font-mono text-center">Jarak ke C3</th>
                                <th class="p-2.5 font-mono text-center">Jarak Min</th>
                                <th class="p-2.5 text-center">Cluster Ditugaskan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @foreach($iteration->matriks_jarak_json as $row)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/40">
                                <td class="p-2.5 font-medium text-gray-800 dark:text-gray-200">{{ $row['nama'] }}</td>
                                <td class="p-2.5 font-mono text-center text-gray-600 dark:text-gray-400">{{ $row['jarak_c1'] }}</td>
                                <td class="p-2.5 font-mono text-center text-gray-600 dark:text-gray-400">{{ $row['jarak_c2'] }}</td>
                                <td class="p-2.5 font-mono text-center text-gray-600 dark:text-gray-400">{{ $row['jarak_c3'] }}</td>
                                <td class="p-2.5 font-mono text-center font-bold text-brand-600">{{ $row['jarak_terdekat'] }}</td>
                                <td class="p-2.5 text-center font-bold">Cluster {{ $row['cluster'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
