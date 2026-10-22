@extends('layouts.app')

@section('title', 'Rekapitulasi Keaktifan Ronda Malam')
@section('page_title', 'Rekapitulasi Keaktifan Ronda Warga')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-gray-900 dark:text-white">Rekapitulasi &amp; Evaluasi Ronda Malam</h2>
            <p class="text-xs text-gray-500 dark:text-gray-400">Statistik kehadiran warga piket ronda malam RT 03 Kelurahan Kedaung</p>
        </div>

        <div class="flex items-center gap-2.5">
            <a href="{{ route('ronda.index') }}" class="rounded-xl border border-gray-300 px-3.5 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-100 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800 transition">
                &larr; Kembali ke Jadwal
            </a>
            <a
                href="{{ route('ronda.exportPdf') }}"
                target="_blank"
                class="inline-flex items-center gap-2 rounded-xl bg-rose-600 px-4 py-2 text-xs font-bold text-white shadow-md shadow-rose-600/25 hover:bg-rose-700 transition"
            >
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Cetak Dokumen PDF
            </a>
        </div>
    </div>

    <div class="rounded-3xl border border-gray-200/80 bg-white shadow-xs dark:border-gray-800 dark:bg-gray-900 overflow-hidden">
        <div class="p-6 border-b border-gray-100 dark:border-gray-800">
            <h3 class="text-base font-bold text-gray-900 dark:text-white">Tabel Peringkat Partisipasi Keamanan Warga</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400">Evaluasi rutin oleh Ketua RT untuk apresiasi warga dan tindak lanjut absensi alpha</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="border-b border-gray-200 bg-gray-50/70 text-gray-500 dark:border-gray-800 dark:bg-gray-800/50 uppercase tracking-wider font-semibold">
                    <tr>
                        <th class="py-3.5 px-4 text-center">Rank</th>
                        <th class="py-3.5 px-4">Nama Lengkap & NIK</th>
                        <th class="py-3.5 px-4">Alamat Blok</th>
                        <th class="py-3.5 px-4 text-center">Total Tugas</th>
                        <th class="py-3.5 px-4 text-center font-bold text-emerald-600">Hadir</th>
                        <th class="py-3.5 px-4 text-center font-bold text-amber-600">Izin</th>
                        <th class="py-3.5 px-4 text-center font-bold text-blue-600">Digantikan</th>
                        <th class="py-3.5 px-4 text-center font-bold text-rose-600">Alpha</th>
                        <th class="py-3.5 px-4 text-center">Tingkat Kehadiran (%)</th>
                        <th class="py-3.5 px-4 text-center">Status Evaluasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-gray-700 dark:text-gray-300">
                    @forelse($wargas as $w)
                    @php
                        $total = $w->total_tugas;
                        $rate = $total > 0 ? round((($w->total_hadir + ($w->total_digantikan * 0.8)) / $total) * 100) : 0;
                    @endphp
                    <tr class="hover:bg-gray-50/70 dark:hover:bg-gray-800/40 transition">
                        <td class="py-3.5 px-4 text-center font-bold text-gray-400">
                            #{{ $loop->iteration + ($wargas->currentPage() - 1) * $wargas->perPage() }}
                        </td>
                        <td class="py-3.5 px-4">
                            <a href="{{ route('warga.show', $w->id) }}" class="font-bold text-gray-900 dark:text-white hover:text-brand-600 block">
                                {{ $w->nama_lengkap }}
                            </a>
                            <span class="text-[11px] text-gray-400">{{ $w->nik }}</span>
                        </td>
                        <td class="py-3.5 px-4 font-medium">{{ $w->alamat_blok }}</td>
                        <td class="py-3.5 px-4 text-center font-bold">{{ $w->total_tugas }}x</td>
                        <td class="py-3.5 px-4 text-center font-extrabold text-emerald-600 dark:text-emerald-400">{{ $w->total_hadir }}</td>
                        <td class="py-3.5 px-4 text-center font-semibold text-amber-600 dark:text-amber-400">{{ $w->total_izin }}</td>
                        <td class="py-3.5 px-4 text-center font-semibold text-blue-600 dark:text-blue-400">{{ $w->total_digantikan }}</td>
                        <td class="py-3.5 px-4 text-center font-bold text-rose-600 dark:text-rose-400">{{ $w->total_alpha }}</td>
                        <td class="py-3.5 px-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <span class="font-black text-gray-900 dark:text-white">{{ $rate }}%</span>
                            </div>
                        </td>
                        <td class="py-3.5 px-4 text-center">
                            @if($rate >= 80)
                                <span class="rounded-full bg-emerald-100 px-2.5 py-0.5 text-[10px] font-bold text-emerald-800 dark:bg-emerald-950/70 dark:text-emerald-300">Sangat Aktif</span>
                            @elseif($rate >= 50)
                                <span class="rounded-full bg-amber-100 px-2.5 py-0.5 text-[10px] font-bold text-amber-800 dark:bg-amber-950/70 dark:text-amber-300">Cukup Aktif</span>
                            @else
                                <span class="rounded-full bg-rose-100 px-2.5 py-0.5 text-[10px] font-bold text-rose-800 dark:bg-rose-950/70 dark:text-rose-300">Perlu Pembinaan</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="py-8 text-center text-gray-400">Belum ada data warga.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($wargas->hasPages())
        <div class="p-4 border-t border-gray-100 dark:border-gray-800">
            {{ $wargas->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
