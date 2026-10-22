@extends('layouts.app')

@section('title', 'Detail Warga: ' . $warga->nama_lengkap)
@section('page_title', 'Biodata Kependudukan Warga')

@section('content')
<div class="space-y-6">
    <!-- Header Back & Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <a href="{{ route('warga.index') }}" class="rounded-xl border border-gray-200 bg-white p-2 text-gray-500 hover:bg-gray-100 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-400">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h2 class="text-xl font-extrabold text-gray-900 dark:text-white">{{ $warga->nama_lengkap }}</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400">NIK: {{ $warga->nik }} &bull; {{ $warga->alamat_blok }}</p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('warga.edit', $warga->id) }}" class="inline-flex items-center gap-2 rounded-xl bg-amber-500 px-4 py-2 text-xs font-bold text-white shadow-xs hover:bg-amber-600 transition">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Ubah Biodata
            </a>
        </div>
    </div>

    <!-- 2 Column Profile Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Left: Identitas & Status Bantuan (5 Cols) -->
        <div class="lg:col-span-5 space-y-6">
            <!-- Profil Singkat -->
            <div class="rounded-3xl border border-gray-200/80 bg-white p-6 shadow-xs dark:border-gray-800 dark:bg-gray-900">
                <div class="flex items-center gap-4 pb-6 border-b border-gray-100 dark:border-gray-800">
                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-tr from-brand-600 to-brand-400 text-white font-extrabold text-xl shadow-md">
                        {{ strtoupper(substr($warga->nama_lengkap, 0, 2)) }}
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $warga->nama_lengkap }}</h3>
                        <p class="text-xs text-gray-400">{{ $warga->pekerjaan }}</p>
                        <div class="mt-2 flex flex-wrap gap-1.5">
                            @if($warga->status_ktp === 'ada')
                                <span class="rounded-md bg-emerald-100 px-2 py-0.5 text-[10px] font-bold text-emerald-800 dark:bg-emerald-950/70 dark:text-emerald-300">KTP Tersedia</span>
                            @else
                                <span class="rounded-md bg-rose-100 px-2 py-0.5 text-[10px] font-bold text-rose-800 dark:bg-rose-950/70 dark:text-rose-300">Belum Ber-KTP</span>
                            @endif
                            <span class="rounded-md bg-indigo-100 px-2 py-0.5 text-[10px] font-bold text-indigo-800 dark:bg-indigo-950/70 dark:text-indigo-300">{{ $warga->jenis_kelamin_label }} ({{ $warga->usia }} thn)</span>
                        </div>
                    </div>
                </div>

                <div class="mt-4 space-y-3 text-xs">
                    <div class="flex justify-between py-1.5 border-b border-gray-50 dark:border-gray-800/60">
                        <span class="text-gray-400">Nomor Kartu Keluarga:</span>
                        <span class="font-mono font-bold text-gray-800 dark:text-gray-200">{{ $warga->no_kk }}</span>
                    </div>
                    <div class="flex justify-between py-1.5 border-b border-gray-50 dark:border-gray-800/60">
                        <span class="text-gray-400">Tempat, Tanggal Lahir:</span>
                        <span class="font-medium text-gray-800 dark:text-gray-200">{{ $warga->tempat_lahir ?? '-' }}, {{ $warga->tanggal_lahir->isoFormat('D MMMM Y') }}</span>
                    </div>
                    <div class="flex justify-between py-1.5 border-b border-gray-50 dark:border-gray-800/60">
                        <span class="text-gray-400">Alamat Rumah:</span>
                        <span class="font-medium text-gray-800 dark:text-gray-200">{{ $warga->alamat_blok }}</span>
                    </div>
                    <div class="flex justify-between py-1.5 border-b border-gray-50 dark:border-gray-800/60">
                        <span class="text-gray-400">Status Kepemilikan:</span>
                        <span class="font-medium text-gray-800 dark:text-gray-200">{{ ucwords(str_replace('_', ' ', $warga->status_kepemilikan_rumah)) }}</span>
                    </div>
                    <div class="flex justify-between py-1.5 border-b border-gray-50 dark:border-gray-800/60">
                        <span class="text-gray-400">Kondisi Fisik Rumah:</span>
                        <span class="font-bold text-gray-800 dark:text-gray-200">{{ ucwords(str_replace('_', ' ', $warga->kondisi_rumah)) }} (Skor: {{ $warga->skor_kondisi_rumah }})</span>
                    </div>
                    <div class="flex justify-between py-1.5 border-b border-gray-50 dark:border-gray-800/60">
                        <span class="text-gray-400">Penghasilan Bulanan:</span>
                        <span class="font-bold text-emerald-600 dark:text-emerald-400">{{ $warga->formatted_penghasilan }}</span>
                    </div>
                    <div class="flex justify-between py-1.5 border-b border-gray-50 dark:border-gray-800/60">
                        <span class="text-gray-400">Jumlah Tanggungan:</span>
                        <span class="font-bold text-gray-800 dark:text-gray-200">{{ $warga->jumlah_tanggungan }} Orang</span>
                    </div>
                    <div class="flex justify-between py-1.5">
                        <span class="text-gray-400">Status Iuran Kas RT:</span>
                        <span class="font-bold {{ $warga->status_iuran === 'lancar' ? 'text-emerald-600' : 'text-rose-600' }}">
                            {{ ucfirst($warga->status_iuran) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Kartu Hasil K-Means Clustering Terkini -->
            <div class="rounded-3xl border border-gray-200/80 bg-white p-6 shadow-xs dark:border-gray-800 dark:bg-gray-900">
                <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-800">
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <span class="flex h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                        Klasifikasi Bantuan K-Means
                    </h3>
                </div>

                @if($warga->latestClusteringResult)
                @php $res = $warga->latestClusteringResult; @endphp
                <div class="mt-4 p-4 rounded-2xl
                    @if($res->cluster_terpilih === 'cluster_1') bg-rose-50 border border-rose-200 text-rose-900 dark:bg-rose-950/40 dark:border-rose-900/50 dark:text-rose-200
                    @elseif($res->cluster_terpilih === 'cluster_2') bg-amber-50 border border-amber-200 text-amber-900 dark:bg-amber-950/40 dark:border-amber-900/50 dark:text-amber-200
                    @else bg-emerald-50 border border-emerald-200 text-emerald-900 dark:bg-emerald-950/40 dark:border-emerald-900/50 dark:text-emerald-200 @endif
                ">
                    <p class="text-xs font-bold uppercase tracking-wider">{{ $res->cluster_label }}</p>
                    <p class="mt-1 text-sm font-extrabold">{{ $res->rekomendasi_kebijakan }}</p>
                    <div class="mt-3 pt-3 border-t border-black/10 dark:border-white/10 grid grid-cols-3 gap-2 text-center text-[10px]">
                        <div>
                            <span class="block text-gray-500 dark:text-gray-400">Jarak C1</span>
                            <span class="font-bold">{{ $res->jarak_c1 }}</span>
                        </div>
                        <div>
                            <span class="block text-gray-500 dark:text-gray-400">Jarak C2</span>
                            <span class="font-bold">{{ $res->jarak_c2 }}</span>
                        </div>
                        <div>
                            <span class="block text-gray-500 dark:text-gray-400">Jarak C3</span>
                            <span class="font-bold">{{ $res->jarak_c3 }}</span>
                        </div>
                    </div>
                </div>
                @else
                <p class="mt-4 text-xs text-gray-400 text-center py-4">Warga belum terpetakan dalam sesi K-Means aktif.</p>
                @endif
            </div>
        </div>

        <!-- Right: Riwayat Kas & Kehadiran Ronda (7 Cols) -->
        <div class="lg:col-span-7 space-y-6">
            <!-- Riwayat Kas Iuran -->
            <div class="rounded-3xl border border-gray-200/80 bg-white p-6 shadow-xs dark:border-gray-800 dark:bg-gray-900">
                <div class="flex items-center justify-between pb-4 border-b border-gray-100 dark:border-gray-800">
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white">Riwayat Iuran Kas RT</h3>
                    <a href="{{ route('kas.index', ['search' => $warga->nama_lengkap]) }}" class="text-xs font-semibold text-brand-600 hover:text-brand-700 dark:text-brand-400">
                        Kelola di Menu Kas &rarr;
                    </a>
                </div>

                <div class="mt-4 overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="text-gray-400 border-b border-gray-100 dark:border-gray-800 font-semibold uppercase">
                            <tr>
                                <th class="pb-2.5">Periode</th>
                                <th class="pb-2.5">Nominal</th>
                                <th class="pb-2.5">Status</th>
                                <th class="pb-2.5">Tgl Bayar</th>
                                <th class="pb-2.5">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @forelse($warga->kasWargas as $kas)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/40">
                                <td class="py-2.5 font-bold text-gray-800 dark:text-gray-200">{{ $kas->periode_bulan }}</td>
                                <td class="py-2.5 font-semibold text-gray-900 dark:text-white">{{ $kas->formatted_nominal }}</td>
                                <td class="py-2.5">
                                    @if($kas->status_pembayaran === 'lunas')
                                        <span class="rounded-md bg-emerald-50 px-2 py-0.5 text-[10px] font-bold text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300">Lunas</span>
                                    @else
                                        <span class="rounded-md bg-rose-50 px-2 py-0.5 text-[10px] font-bold text-rose-700 dark:bg-rose-950/60 dark:text-rose-300">Belum Lunas</span>
                                    @endif
                                </td>
                                <td class="py-2.5 text-gray-500">{{ $kas->tanggal_bayar ? $kas->tanggal_bayar->format('d/m/Y') : '-' }}</td>
                                <td class="py-2.5 text-gray-500 truncate max-w-xs">{{ $kas->keterangan ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-4 text-center text-gray-400">Belum ada riwayat tagihan iuran kas.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Riwayat Tugas Ronda Malam -->
            <div class="rounded-3xl border border-gray-200/80 bg-white p-6 shadow-xs dark:border-gray-800 dark:bg-gray-900">
                <div class="flex items-center justify-between pb-4 border-b border-gray-100 dark:border-gray-800">
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white">Riwayat Kehadiran Ronda Malam</h3>
                    <a href="{{ route('ronda.index') }}" class="text-xs font-semibold text-brand-600 hover:text-brand-700 dark:text-brand-400">
                        Jadwal Ronda &rarr;
                    </a>
                </div>

                <div class="mt-4 overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="text-gray-400 border-b border-gray-100 dark:border-gray-800 font-semibold uppercase">
                            <tr>
                                <th class="pb-2.5">Tanggal Ronda</th>
                                <th class="pb-2.5">Shift</th>
                                <th class="pb-2.5">Status Kehadiran</th>
                                <th class="pb-2.5">Catatan / Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @forelse($warga->rondaParticipants as $rp)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/40">
                                <td class="py-2.5 font-bold text-gray-800 dark:text-gray-200">
                                    {{ $rp->schedule->tanggal_ronda ? $rp->schedule->tanggal_ronda->format('d/m/Y') : '-' }}
                                </td>
                                <td class="py-2.5 text-gray-600 dark:text-gray-400">{{ $rp->schedule->shift_ronda ?? 'Malam' }}</td>
                                <td class="py-2.5">
                                    <span class="rounded-md px-2 py-0.5 text-[10px] font-bold
                                        @if($rp->status_kehadiran === 'hadir') bg-emerald-100 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300
                                        @elseif($rp->status_kehadiran === 'izin') bg-amber-100 text-amber-700 dark:bg-amber-950/60 dark:text-amber-300
                                        @elseif($rp->status_kehadiran === 'digantikan') bg-blue-100 text-blue-700 dark:bg-blue-950/60 dark:text-blue-300
                                        @else bg-rose-100 text-rose-700 dark:bg-rose-950/60 dark:text-rose-300 @endif">
                                        {{ $rp->status_label }}
                                    </span>
                                </td>
                                <td class="py-2.5 text-gray-500 truncate max-w-xs">{{ $rp->catatan_keterangan ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-4 text-center text-gray-400">Belum ada riwayat penugasan ronda malam.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
