@extends('layouts.app')

@section('title', 'Detail Warga: ' . $warga->nama_lengkap)

@section('content')
<!-- Breadcrumb Start -->
<div class="flex flex-wrap items-center justify-between gap-3 pb-6">
    <div>
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Biodata Kependudukan Warga</h2>
        <p class="mt-0.5 text-theme-xs text-gray-500 dark:text-gray-400">
            Detail informasi kependudukan, klasifikasi bantuan K-Means, dan penugasan ronda
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
                <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" href="{{ route('warga.index') }}">
                    Data Warga RT
                    <svg class="stroke-current" width="17" height="16" viewBox="0 0 17 16" fill="none">
                        <path d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </li>
            <li class="text-sm text-gray-800 dark:text-white/90">Detail Warga</li>
        </ol>
    </nav>
</div>
<!-- Breadcrumb End -->

<div class="space-y-6">
    <!-- Main Profile Card (TailAdmin Profile Layout) -->
    <div class="rounded-2xl border border-gray-200 bg-white p-5 lg:p-6 dark:border-gray-800 dark:bg-white/3">
        <!-- Top Profile Summary -->
        <div class="mb-6 rounded-2xl border border-gray-200 p-5 lg:p-6 dark:border-gray-800">
            <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex flex-col items-start gap-5 sm:flex-row sm:items-center">
                    <div class="flex h-20 w-20 shrink-0 items-center justify-center rounded-full border border-gray-200 {{ $warga->jenis_kelamin === 'L' ? 'bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400' : 'bg-theme-pink-500/10 text-theme-pink-500' }} text-2xl font-bold dark:border-gray-800">
                        {{ strtoupper(substr($warga->nama_lengkap, 0, 2)) }}
                    </div>
                    <div>
                        <h4 class="mb-1.5 text-lg font-semibold text-gray-800 dark:text-white/90">
                            {{ $warga->nama_lengkap }}
                        </h4>
                        <div class="flex flex-wrap items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                            <span>{{ $warga->pekerjaan }}</span>
                            <span class="hidden h-3.5 w-px bg-gray-300 sm:block dark:bg-gray-700"></span>
                            <span>{{ $warga->alamat_blok }}</span>
                            <span class="hidden h-3.5 w-px bg-gray-300 sm:block dark:bg-gray-700"></span>
                            <span>{{ $warga->jenis_kelamin_label }} ({{ $warga->usia }} thn)</span>
                        </div>
                        <div class="mt-2.5 flex flex-wrap gap-2">
                            @if($warga->status_ktp === 'ada')
                                <span class="bg-success-50 text-theme-xs text-success-600 dark:bg-success-500/15 dark:text-success-500 inline-flex items-center rounded-full px-2.5 py-0.5 font-medium">
                                    KTP Tersedia
                                </span>
                            @else
                                <span class="bg-error-50 text-theme-xs text-error-600 dark:bg-error-500/15 dark:text-error-500 inline-flex items-center rounded-full px-2.5 py-0.5 font-medium">
                                    Belum Ber-KTP
                                </span>
                            @endif

                            <span class="bg-brand-50 text-theme-xs text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 inline-flex items-center rounded-full px-2.5 py-0.5 font-medium">
                                Skor Ekonomi: {{ $warga->skor_ekonomi }}/5
                            </span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-2.5">
                    <a
                        href="{{ route('warga.index') }}"
                        class="shadow-theme-xs inline-flex h-10 items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/3 dark:hover:text-gray-200"
                    >
                        &larr; Kembali
                    </a>
                    @if(auth()->user()->isAdmin() || auth()->user()->isKetuaRt())
                    <a
                        href="{{ route('warga.edit', $warga->id) }}"
                        class="bg-brand-500 shadow-theme-xs hover:bg-brand-600 inline-flex h-10 items-center justify-center gap-2 rounded-lg px-4 py-2.5 text-sm font-medium text-white transition"
                    >
                        <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M15.0911 2.78206C14.2125 1.90338 12.7878 1.90338 11.9092 2.78206L4.57524 10.116C4.26682 10.4244 4.0547 10.8158 3.96468 11.2426L3.31231 14.3352C3.25997 14.5833 3.33653 14.841 3.51583 15.0203C3.69512 15.1996 3.95286 15.2761 4.20096 15.2238L7.29355 14.5714C7.72031 14.4814 8.11172 14.2693 8.42013 13.9609L15.7541 6.62695C16.6327 5.74827 16.6327 4.32365 15.7541 3.44497L15.0911 2.78206ZM12.9698 3.84272C13.2627 3.54982 13.7376 3.54982 14.0305 3.84272L14.6934 4.50563C14.9863 4.79852 14.9863 5.2734 14.6934 5.56629L14.044 6.21573L12.3204 4.49215L12.9698 3.84272ZM11.2597 5.55281L5.6359 11.1766C5.53309 11.2794 5.46238 11.4099 5.43238 11.5522L5.01758 13.5185L6.98394 13.1037C7.1262 13.0737 7.25666 13.003 7.35947 12.9002L12.9833 7.27639L11.2597 5.55281Z"/>
                        </svg>
                        Ubah Biodata
                    </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Personal & Economic Information Grid -->
        <div class="mb-6 rounded-2xl border border-gray-200 p-5 lg:p-6 dark:border-gray-800">
            <h4 class="mb-5 text-base font-semibold text-gray-800 lg:mb-6 dark:text-white/90">
                Informasi Kependudukan &amp; Sosial Ekonomi
            </h4>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 lg:gap-7">
                <div>
                    <p class="mb-1.5 text-xs leading-normal text-gray-500 dark:text-gray-400">Nomor Induk Kependudukan (NIK)</p>
                    <p class="font-mono text-sm font-medium text-gray-800 dark:text-white/90">{{ $warga->nik }}</p>
                </div>

                <div>
                    <p class="mb-1.5 text-xs leading-normal text-gray-500 dark:text-gray-400">Nomor Kartu Keluarga (No. KK)</p>
                    <p class="font-mono text-sm font-medium text-gray-800 dark:text-white/90">{{ $warga->no_kk }}</p>
                </div>

                <div>
                    <p class="mb-1.5 text-xs leading-normal text-gray-500 dark:text-gray-400">Tempat, Tanggal Lahir</p>
                    <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                        {{ $warga->tempat_lahir ?? '-' }}, {{ $warga->tanggal_lahir ? $warga->tanggal_lahir->isoFormat('D MMMM Y') : '-' }}
                    </p>
                </div>

                <div>
                    <p class="mb-1.5 text-xs leading-normal text-gray-500 dark:text-gray-400">Agama</p>
                    <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $warga->agama ?? 'Islam' }}</p>
                </div>

                <div>
                    <p class="mb-1.5 text-xs leading-normal text-gray-500 dark:text-gray-400">Alamat Blok / Rumah</p>
                    <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $warga->alamat_blok }}</p>
                </div>

                <div>
                    <p class="mb-1.5 text-xs leading-normal text-gray-500 dark:text-gray-400">Status Kepemilikan Rumah</p>
                    <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ ucwords(str_replace('_', ' ', $warga->status_kepemilikan_rumah)) }}</p>
                </div>

                <div>
                    <p class="mb-1.5 text-xs leading-normal text-gray-500 dark:text-gray-400">Penghasilan Bulanan</p>
                    <p class="text-sm font-semibold text-success-600 dark:text-success-400">{{ $warga->formatted_penghasilan }}</p>
                </div>

                <div>
                    <p class="mb-1.5 text-xs leading-normal text-gray-500 dark:text-gray-400">Keterangan Khusus</p>
                    <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $warga->keterangan ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- 2 Column Bottom Section: Klasifikasi K-Means & Tabel Riwayat Ronda -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
            <!-- Left: Hasil K-Means Clustering Terkini (5 Cols) -->
            <div class="lg:col-span-5">
                <div class="h-full rounded-2xl border border-gray-200 p-5 lg:p-6 dark:border-gray-800">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-4 dark:border-gray-800">
                        <div>
                            <h4 class="text-base font-semibold text-gray-800 dark:text-white/90">
                                Klasifikasi Bantuan K-Means
                            </h4>
                            <p class="text-theme-xs text-gray-500 dark:text-gray-400">
                                Hasil pemetaan prioritas bantuan sosial terkini
                            </p>
                        </div>
                        <span class="h-2.5 w-2.5 rounded-full bg-success-500"></span>
                    </div>

                    @if($warga->latestClusteringResult)
                    @php $res = $warga->latestClusteringResult; @endphp
                    <div class="mt-4 rounded-xl border p-4
                        @if($res->cluster_terpilih === 'cluster_1') border-error-200 bg-error-50/50 dark:border-error-500/30 dark:bg-error-500/10
                        @elseif($res->cluster_terpilih === 'cluster_2') border-warning-200 bg-warning-50/50 dark:border-warning-500/30 dark:bg-warning-500/10
                        @else border-success-200 bg-success-50/50 dark:border-success-500/30 dark:bg-success-500/10 @endif
                    ">
                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-theme-xs font-medium
                            @if($res->cluster_terpilih === 'cluster_1') bg-error-100 text-error-700 dark:bg-error-500/20 dark:text-error-400
                            @elseif($res->cluster_terpilih === 'cluster_2') bg-warning-100 text-warning-700 dark:bg-warning-500/20 dark:text-warning-400
                            @else bg-success-100 text-success-700 dark:bg-success-500/20 dark:text-success-400 @endif
                        ">
                            {{ $res->cluster_label }}
                        </span>
                        <p class="mt-2 text-base font-semibold text-gray-800 dark:text-white/90">
                            {{ $res->rekomendasi_kebijakan }}
                        </p>
                        <div class="mt-4 grid grid-cols-3 gap-2 border-t border-gray-200/60 pt-3 text-center dark:border-gray-800">
                            <div>
                                <span class="text-theme-xs block text-gray-500 dark:text-gray-400">Jarak C1</span>
                                <span class="font-mono text-sm font-semibold text-gray-800 dark:text-white/90">{{ $res->jarak_c1 }}</span>
                            </div>
                            <div>
                                <span class="text-theme-xs block text-gray-500 dark:text-gray-400">Jarak C2</span>
                                <span class="font-mono text-sm font-semibold text-gray-800 dark:text-white/90">{{ $res->jarak_c2 }}</span>
                            </div>
                            <div>
                                <span class="text-theme-xs block text-gray-500 dark:text-gray-400">Jarak C3</span>
                                <span class="font-mono text-sm font-semibold text-gray-800 dark:text-white/90">{{ $res->jarak_c3 }}</span>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="py-8 text-center">
                        <p class="text-theme-sm text-gray-500 dark:text-gray-400">
                            Warga belum terpetakan dalam sesi K-Means aktif.
                        </p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Right: Tabel Jadwal Penugasan Ronda Malam (7 Cols) -->
            <div class="lg:col-span-7">
                <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3">
                    <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4 sm:px-6 dark:border-gray-800">
                        <div>
                            <h4 class="text-base font-semibold text-gray-800 dark:text-white/90">
                                Jadwal Penugasan Ronda Malam
                            </h4>
                            <p class="text-theme-xs text-gray-500 dark:text-gray-400">
                                Daftar giliran piket pos keamanan lingkungan RT 03
                            </p>
                        </div>
                        <a href="{{ route('ronda.index') }}" class="text-theme-xs font-medium text-brand-500 hover:text-brand-600 dark:text-brand-400">
                            Lihat Semua &rarr;
                        </a>
                    </div>

                    <div class="custom-scrollbar max-w-full overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b border-gray-100 dark:border-gray-800">
                                    <th class="px-5 py-3 text-left sm:px-6">
                                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Tanggal Ronda</p>
                                    </th>
                                    <th class="px-5 py-3 text-left sm:px-6">
                                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Shift</p>
                                    </th>
                                    <th class="px-5 py-3 text-left sm:px-6">
                                        <p class="text-theme-xs font-medium text-gray-500 dark:text-gray-400">Catatan Jadwal</p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                @forelse($warga->rondaParticipants as $rp)
                                <tr class="transition hover:bg-gray-50/60 dark:hover:bg-white/[0.02]">
                                    <td class="px-5 py-3.5 whitespace-nowrap sm:px-6">
                                        <p class="text-theme-sm font-medium text-gray-800 dark:text-white/90">
                                            {{ $rp->schedule && $rp->schedule->tanggal_ronda ? $rp->schedule->tanggal_ronda->isoFormat('dddd, D MMMM Y') : '-' }}
                                        </p>
                                    </td>
                                    <td class="px-5 py-3.5 whitespace-nowrap sm:px-6">
                                        <span class="bg-brand-50 text-theme-xs text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 inline-flex rounded-full px-2.5 py-0.5 font-medium">
                                            {{ $rp->schedule->shift_ronda ?? 'Malam' }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3.5 sm:px-6">
                                        <p class="text-theme-sm text-gray-500 dark:text-gray-400">
                                            {{ $rp->schedule->keterangan_khusus ?? 'Patroli rutin pos ronda' }}
                                        </p>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-5 py-8 text-center sm:px-6">
                                        <p class="text-theme-sm text-gray-500 dark:text-gray-400">
                                            Belum ada riwayat penugasan jadwal ronda malam.
                                        </p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
