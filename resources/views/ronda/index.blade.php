@extends('layouts.app')

@section('title', 'Jadwal Ronda Malam')
@section('page_title', 'Jadwal Ronda Malam Warga RT 03')

@section('content')
<div class="space-y-6" x-data="{
    showModalCreate: false,
    showModalGenerate: false,
    selectedWargas: [],
}">
    <!-- Header with Action -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-gray-900 dark:text-white">Jadwal Ronda Malam</h2>
            <p class="text-xs text-gray-500 dark:text-gray-400">Generate jadwal ronda bergilir warga RT 03, unduh PDF untuk cetak/mading, atau bagikan file ke grup WhatsApp warga</p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            <a
                href="{{ route('ronda.exportPdf', request()->all()) }}"
                target="_blank"
                class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-3.5 py-2.5 text-xs font-bold text-gray-700 shadow-xs hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 transition"
                title="Cetak PDF untuk mading atau share WhatsApp"
            >
                <svg class="h-4 w-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                PDF Cetak Mading / WA
            </a>

            <a
                href="{{ route('ronda.exportExcel', request()->all()) }}"
                class="inline-flex items-center gap-2 rounded-xl border border-emerald-200 bg-emerald-50/50 px-3.5 py-2.5 text-xs font-bold text-emerald-700 shadow-xs hover:bg-emerald-100 dark:border-emerald-900/40 dark:bg-emerald-950/20 dark:text-emerald-400 dark:hover:bg-emerald-950/40 transition"
            >
                <svg class="h-4 w-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Excel (XLSX)
            </a>

            @if(auth()->user()->isAdmin() || auth()->user()->isKetuaRt())
            <button
                type="button"
                @click="showModalGenerate = true"
                class="inline-flex items-center gap-2 rounded-xl border border-brand-200 bg-brand-50 px-3.5 py-2.5 text-xs font-bold text-brand-700 shadow-xs hover:bg-brand-100 dark:border-brand-900/40 dark:bg-brand-950/30 dark:text-brand-300 transition cursor-pointer"
            >
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                ⚡ Generate Bergilir
            </button>

            <button
                type="button"
                @click="showModalCreate = true"
                class="inline-flex items-center gap-2 rounded-xl bg-brand-500 px-4 py-2.5 text-xs font-bold text-white shadow-md shadow-brand-500/25 hover:bg-brand-600 transition cursor-pointer"
            >
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                + Buat Jadwal Manual
            </button>
            @endif
        </div>
    </div>

    <!-- Active Schedules Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($schedules as $sched)
        <div class="rounded-3xl border border-gray-200/80 bg-white p-6 shadow-xs dark:border-gray-800 dark:bg-gray-900 flex flex-col justify-between">
            <div>
                <!-- Schedule Card Header -->
                <div class="flex items-start justify-between pb-4 border-b border-gray-100 dark:border-gray-800">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="rounded-lg bg-brand-50 px-2.5 py-1 text-xs font-bold text-brand-700 dark:bg-brand-900/40 dark:text-brand-300">
                                {{ $sched->tanggal_ronda->isoFormat('dddd, D MMMM Y') }}
                            </span>
                            @if($sched->tanggal_ronda->isToday())
                                <span class="rounded-md bg-emerald-100 px-2 py-0.5 text-[10px] font-extrabold text-emerald-800 dark:bg-emerald-950/70 dark:text-emerald-300 animate-pulse">MALAM INI</span>
                            @elseif($sched->tanggal_ronda->isTomorrow())
                                <span class="rounded-md bg-blue-100 px-2 py-0.5 text-[10px] font-bold text-blue-800 dark:bg-blue-950/70 dark:text-blue-300">BESOK</span>
                            @endif
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 font-medium">Shift: {{ $sched->shift_ronda }}</p>
                    </div>

                    @if(auth()->user()->isAdmin() || auth()->user()->isKetuaRt())
                    <form method="POST" action="{{ route('ronda.destroy', $sched->id) }}" onsubmit="return confirm('Hapus jadwal ronda tanggal {{ $sched->tanggal_ronda->format('d/m/Y') }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="rounded-lg p-1.5 text-gray-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/30 transition cursor-pointer" title="Hapus Jadwal">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </form>
                    @endif
                </div>

                @if($sched->keterangan_khusus)
                <p class="mt-3 text-xs text-gray-600 dark:text-gray-300 italic bg-amber-50/60 dark:bg-amber-950/20 p-2.5 rounded-xl border border-amber-100 dark:border-amber-900/30">
                    &ldquo;{{ $sched->keterangan_khusus }}&rdquo;
                </p>
                @endif

                <!-- Participants List -->
                <div class="mt-4 space-y-2">
                    <p class="text-xs font-bold uppercase tracking-wider text-gray-400">
                        Petugas Piket ({{ $sched->participants->count() }} Warga)
                    </p>

                    @foreach($sched->participants as $participant)
                    <div class="flex items-center justify-between rounded-2xl border border-gray-100 bg-gray-50/60 p-3 dark:border-gray-800 dark:bg-gray-800/40">
                        <div class="flex items-center gap-3">
                            <div class="flex h-8 w-8 items-center justify-center rounded-xl bg-brand-100 font-bold text-brand-700 text-xs dark:bg-brand-900/60 dark:text-brand-300">
                                {{ $loop->iteration }}
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-900 dark:text-white">{{ $participant->warga->nama_lengkap }}</p>
                                <p class="text-[10px] text-gray-400">{{ $participant->warga->alamat_blok }} &bull; {{ $participant->warga->pekerjaan }}</p>
                            </div>
                        </div>

                        <span class="rounded-md bg-gray-100 px-2 py-0.5 text-[10px] font-medium text-gray-600 dark:bg-gray-800 dark:text-gray-300">
                            Petugas Terdaftar
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-gray-100 dark:border-gray-800 text-[11px] text-gray-400 flex justify-between">
                <span>Dibuat oleh: {{ $sched->createdBy->name ?? 'Ketua RT' }}</span>
                <span>{{ $sched->created_at->diffForHumans() }}</span>
            </div>
        </div>
        @empty
        <div class="col-span-full py-16 text-center rounded-3xl border border-dashed border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900">
            <svg class="h-12 w-12 mx-auto text-gray-300 dark:text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p class="mt-3 text-sm font-semibold text-gray-600 dark:text-gray-400">Belum ada jadwal ronda yang dibuat</p>
            <p class="text-xs text-gray-400 mt-1">Gunakan tombol "Generate Bergilir" atau "Buat Jadwal Manual" untuk menerbitkan jadwal pos ronda.</p>
        </div>
        @endforelse
    </div>

    @if($schedules->hasPages())
    <div class="mt-6">
        {{ $schedules->links() }}
    </div>
    @endif

    <!-- MODAL 1: Form Buat Jadwal Manual -->
    <div
        x-show="showModalCreate"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/50 backdrop-blur-xs"
        x-cloak
    >
        <div @click.outside="showModalCreate = false" class="w-full max-w-lg rounded-3xl bg-white p-6 shadow-2xl dark:bg-gray-900 border border-gray-100 dark:border-gray-800 max-h-[90vh] overflow-y-auto">
            <h3 class="text-base font-bold text-gray-900 dark:text-white mb-1">Buat Jadwal Ronda Manual</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">Tentukan tanggal ronda dan pilih warga yang bertugas malam</p>

            <form action="{{ route('ronda.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Tanggal Ronda <span class="text-red-500">*</span></label>
                        <input
                            type="date"
                            name="tanggal_ronda"
                            required
                            value="{{ date('Y-m-d') }}"
                            class="w-full rounded-xl border border-gray-300 px-3.5 py-2 text-xs text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Shift Ronda <span class="text-red-500">*</span></label>
                        <select
                            name="shift_ronda"
                            required
                            class="w-full rounded-xl border border-gray-300 px-3.5 py-2 text-xs text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200"
                        >
                            <option value="Malam (22:00 - 04:00)">Malam (22:00 - 04:00)</option>
                            <option value="Shift 1 (21:00 - 01:00)">Shift 1 (21:00 - 01:00)</option>
                            <option value="Shift 2 (01:00 - 05:00)">Shift 2 (01:00 - 05:00)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Pesan / Instruksi Pos Ronda (Opsional)</label>
                    <input
                        type="text"
                        name="keterangan_khusus"
                        placeholder="Contoh: Fokus patroli gerbang depan & waspada hujan"
                        class="w-full rounded-xl border border-gray-300 px-3.5 py-2 text-xs text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200"
                    >
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Pilih Petugas Ronda (Centang Warga) <span class="text-red-500">*</span></label>
                    <p class="text-[11px] text-gray-400 mb-2">Pilih beberapa warga RT 03 yang bertugas pada malam tersebut:</p>
                    <div class="max-h-48 overflow-y-auto space-y-1 rounded-xl border border-gray-200 p-2 dark:border-gray-800 dark:bg-gray-800/40">
                        @foreach($wargas as $w)
                        <label class="flex items-center gap-2.5 p-1.5 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 cursor-pointer text-xs">
                            <input
                                type="checkbox"
                                name="warga_ids[]"
                                value="{{ $w->id }}"
                                class="rounded border-gray-300 text-brand-600 focus:ring-brand-500"
                            >
                            <span class="font-medium text-gray-800 dark:text-gray-200">{{ $w->nama_lengkap }}</span>
                            <span class="text-[10px] text-gray-400">({{ $w->alamat_blok }} &bull; {{ $w->jenis_kelamin }})</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2 pt-3 border-t border-gray-100 dark:border-gray-800">
                    <button type="button" @click="showModalCreate = false" class="rounded-xl border border-gray-300 px-4 py-2 text-xs font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-700 dark:text-gray-300">
                        Batal
                    </button>
                    <button type="submit" class="rounded-xl bg-brand-500 px-5 py-2 text-xs font-bold text-white hover:bg-brand-600">
                        Simpan Jadwal Ronda
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 2: Generate Jadwal Bergilir Otomatis -->
    <div
        x-show="showModalGenerate"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/50 backdrop-blur-xs"
        x-cloak
    >
        <div @click.outside="showModalGenerate = false" class="w-full max-w-md rounded-3xl bg-white p-6 shadow-2xl dark:bg-gray-900 border border-gray-100 dark:border-gray-800">
            <div class="flex items-center gap-2 mb-1">
                <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-brand-100 text-brand-700 text-xs font-bold dark:bg-brand-900/60 dark:text-brand-300">⚡</span>
                <h3 class="text-base font-bold text-gray-900 dark:text-white">Generate Jadwal Ronda Bergilir</h3>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">
                Sistem akan membagi warga RT 03 secara acak dan bergilir per malam, lalu jadwal langsung siap dicetak (PDF) untuk ditempel di mading atau dibagikan ke WhatsApp warga.
            </p>

            <form action="{{ route('ronda.generateOtomatis') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Mulai Dari Tanggal <span class="text-red-500">*</span></label>
                    <input
                        type="date"
                        name="tanggal_mulai"
                        required
                        value="{{ date('Y-m-d') }}"
                        class="w-full rounded-xl border border-gray-300 px-3.5 py-2 text-xs text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200"
                    >
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Berapa Hari Ke Depan? <span class="text-red-500">*</span></label>
                        <input
                            type="number"
                            name="jumlah_hari"
                            min="1"
                            max="30"
                            value="7"
                            required
                            class="w-full rounded-xl border border-gray-300 px-3.5 py-2 text-xs text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Petugas / Malam <span class="text-red-500">*</span></label>
                        <input
                            type="number"
                            name="petugas_per_malam"
                            min="2"
                            max="10"
                            value="4"
                            required
                            class="w-full rounded-xl border border-gray-300 px-3.5 py-2 text-xs text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200"
                        >
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Shift Jam Ronda <span class="text-red-500">*</span></label>
                    <select
                        name="shift_ronda"
                        required
                        class="w-full rounded-xl border border-gray-300 px-3.5 py-2 text-xs text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200"
                    >
                        <option value="Malam (22:00 - 04:00)">Malam (22:00 - 04:00)</option>
                        <option value="Shift 1 (21:00 - 01:00)">Shift 1 (21:00 - 01:00)</option>
                        <option value="Shift 2 (01:00 - 05:00)">Shift 2 (01:00 - 05:00)</option>
                    </select>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2 border-t border-gray-100 dark:border-gray-800">
                    <button type="button" @click="showModalGenerate = false" class="rounded-xl border border-gray-300 px-4 py-2 text-xs font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-700 dark:text-gray-300">
                        Batal
                    </button>
                    <button type="submit" class="rounded-xl bg-brand-500 px-5 py-2 text-xs font-bold text-white hover:bg-brand-600">
                        Generate Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
