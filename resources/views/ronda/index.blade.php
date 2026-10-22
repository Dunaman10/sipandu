@extends('layouts.app')

@section('title', 'Jadwal & Absensi Ronda Malam')
@section('page_title', 'Jadwal & Absensi Ronda Malam RT 03')

@section('content')
<div class="space-y-6" x-data="{
    showModalCreate: false,
    showModalAbsen: false,
    selectedParticipant: { id: null, nama: '', status: 'hadir', catatan: '' },
    openAbsenModal(id, nama, status, catatan) {
        this.selectedParticipant = { id, nama, status, catatan: catatan || '' };
        this.showModalAbsen = true;
    }
}">
    <!-- Header with Action -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-gray-900 dark:text-white">Jadwal &amp; Absensi Ronda Malam</h2>
            <p class="text-xs text-gray-500 dark:text-gray-400">Pengaturan jadwal piket keamanan lingkungan RT 03, absensi warga, dan pencatatan pengganti</p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            <a
                href="{{ route('ronda.rekap') }}"
                class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-xs font-bold text-gray-700 shadow-xs hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 transition"
            >
                <svg class="h-4 w-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Rekapitulasi Keaktifan
            </a>

            <a
                href="{{ route('ronda.exportPdf') }}"
                target="_blank"
                class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-xs font-bold text-gray-700 shadow-xs hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 transition"
            >
                <svg class="h-4 w-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Cetak Jadwal PDF
            </a>

            <button
                type="button"
                @click="showModalCreate = true"
                class="inline-flex items-center gap-2 rounded-xl bg-brand-500 px-4 py-2.5 text-xs font-bold text-white shadow-md shadow-brand-500/25 hover:bg-brand-600 transition"
            >
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                + Buat Jadwal Ronda Baru
            </button>
        </div>
    </div>

    <!-- Active Schedules Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($schedules as $sched)
        <div class="rounded-3xl border border-gray-200/80 bg-white p-6 shadow-xs dark:border-gray-800 dark:bg-gray-900 flex flex-col justify-between">
            <div>
                <!-- Schedule Card Header -->
                <div class="flex items-center justify-between pb-4 border-b border-gray-100 dark:border-gray-800">
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-base font-extrabold text-gray-900 dark:text-white">
                                {{ $sched->tanggal_ronda->isoFormat('dddd, D MMMM Y') }}
                            </h3>
                            @if($sched->tanggal_ronda->isToday())
                                <span class="rounded-full bg-emerald-100 px-2.5 py-0.5 text-[10px] font-bold text-emerald-800 dark:bg-emerald-950/70 dark:text-emerald-300 animate-pulse">
                                    Hari Ini
                                </span>
                            @endif
                        </div>
                        <p class="text-xs text-brand-600 dark:text-brand-400 font-semibold mt-0.5">{{ $sched->shift_ronda }}</p>
                    </div>

                    <form method="POST" action="{{ route('ronda.destroy', $sched->id) }}" onsubmit="return confirm('Hapus jadwal ronda malam ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="rounded-lg p-1 text-gray-400 hover:text-rose-600" title="Hapus Jadwal">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </form>
                </div>

                @if($sched->keterangan_khusus)
                <p class="mt-3 text-xs text-gray-500 dark:text-gray-400 italic bg-gray-50/70 dark:bg-gray-800/40 p-2.5 rounded-xl border border-gray-100 dark:border-gray-800">
                    &ldquo;{{ $sched->keterangan_khusus }}&rdquo;
                </p>
                @endif

                <!-- Participants List -->
                <div class="mt-4 space-y-2">
                    <p class="text-xs font-bold uppercase tracking-wider text-gray-400">
                        Petugas Ronda ({{ $sched->participants->count() }} Orang)
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
                                @if($participant->catatan_keterangan)
                                    <p class="text-[10px] text-amber-600 dark:text-amber-400 mt-0.5">Ket: {{ $participant->catatan_keterangan }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <span class="rounded-md px-2 py-0.5 text-[10px] font-bold
                                @if($participant->status_kehadiran === 'hadir') bg-emerald-100 text-emerald-800 dark:bg-emerald-950/70 dark:text-emerald-300
                                @elseif($participant->status_kehadiran === 'izin') bg-amber-100 text-amber-800 dark:bg-amber-950/70 dark:text-amber-300
                                @elseif($participant->status_kehadiran === 'digantikan') bg-blue-100 text-blue-800 dark:bg-blue-950/70 dark:text-blue-300
                                @else bg-rose-100 text-rose-800 dark:bg-rose-950/70 dark:text-rose-300 @endif">
                                {{ $participant->status_label }}
                            </span>

                            <button
                                type="button"
                                @click="openAbsenModal({{ $participant->id }}, '{{ addslashes($participant->warga->nama_lengkap) }}', '{{ $participant->status_kehadiran }}', '{{ addslashes($participant->catatan_keterangan ?? '') }}')"
                                class="rounded-lg p-1 text-gray-400 hover:text-brand-600 hover:bg-gray-100 dark:hover:bg-gray-700"
                                title="Ubah Status Absensi"
                            >
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                </svg>
                            </button>
                        </div>
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
        <div class="col-span-2 py-12 text-center rounded-3xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900">
            <p class="text-sm font-semibold text-gray-500">Belum ada jadwal ronda malam yang dibuat.</p>
            <p class="text-xs text-gray-400 mt-1">Klik tombol "+ Buat Jadwal Ronda Baru" di atas untuk membuat jadwal.</p>
        </div>
        @endforelse
    </div>

    @if($schedules->hasPages())
    <div class="p-4 bg-white rounded-2xl border border-gray-200/80 dark:bg-gray-900 dark:border-gray-800">
        {{ $schedules->links() }}
    </div>
    @endif

    <!-- MODAL 1: Buat Jadwal Ronda Baru (FR-Ronda-01) -->
    <div
        x-show="showModalCreate"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/50 backdrop-blur-xs"
        x-cloak
    >
        <div @click.outside="showModalCreate = false" class="w-full max-w-xl rounded-3xl bg-white p-6 sm:p-8 shadow-2xl dark:bg-gray-900 border border-gray-100 dark:border-gray-800 max-h-[90vh] overflow-y-auto">
            <h3 class="text-base font-bold text-gray-900 dark:text-white mb-1">Buat Jadwal Ronda Malam Baru</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">Tentukan tanggal ronda, shift waktu, serta pilih warga yang bertugas secara bergiliran</p>

            <form method="POST" action="{{ route('ronda.store') }}" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Tanggal Ronda <span class="text-red-500">*</span></label>
                        <input
                            type="date"
                            name="tanggal_ronda"
                            value="{{ date('Y-m-d') }}"
                            required
                            class="w-full rounded-xl border border-gray-300 px-3.5 py-2 text-xs text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Shift Jam Ronda <span class="text-red-500">*</span></label>
                        <input
                            type="text"
                            name="shift_ronda"
                            value="Malam (22:00 - 04:00)"
                            required
                            class="w-full rounded-xl border border-gray-300 px-3.5 py-2 text-xs text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200"
                        >
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Catatan / Intruksi Khusus (Opsional)</label>
                    <input
                        type="text"
                        name="keterangan_khusus"
                        placeholder="Contoh: Fokus pantau portal gang buntu & antisipasi cuaca hujan"
                        class="w-full rounded-xl border border-gray-300 px-3.5 py-2 text-xs text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200"
                    >
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                        Pilih Warga Yang Bertugas Ronda <span class="text-red-500">*</span> (Pilih minimal 1 warga)
                    </label>
                    <div class="max-h-56 overflow-y-auto rounded-2xl border border-gray-200 p-2 divide-y divide-gray-100 dark:border-gray-700 dark:divide-gray-800">
                        @foreach($wargas as $w)
                        <label class="flex items-center gap-3 p-2 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-xl cursor-pointer">
                            <input
                                type="checkbox"
                                name="warga_ids[]"
                                value="{{ $w->id }}"
                                class="h-4 w-4 rounded border-gray-300 text-brand-600 focus:ring-brand-500"
                            >
                            <span class="text-xs text-gray-800 dark:text-gray-200">
                                <strong>{{ $w->nama_lengkap }}</strong> &mdash; {{ $w->alamat_blok }} ({{ $w->pekerjaan }})
                            </span>
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

    <!-- MODAL 2: Form Catat Absensi (FR-Ronda-02 & FR-Ronda-03) -->
    <div
        x-show="showModalAbsen"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/50 backdrop-blur-xs"
        x-cloak
    >
        <div @click.outside="showModalAbsen = false" class="w-full max-w-md rounded-3xl bg-white p-6 shadow-2xl dark:bg-gray-900 border border-gray-100 dark:border-gray-800">
            <h3 class="text-base font-bold text-gray-900 dark:text-white mb-1">Pencatatan Kehadiran Ronda</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">
                Petugas: <strong x-text="selectedParticipant.nama" class="text-gray-900 dark:text-white"></strong>
            </p>

            <form :action="'{{ url('ronda/absensi') }}/' + selectedParticipant.id" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')

                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Status Kehadiran <span class="text-red-500">*</span></label>
                    <select
                        name="status_kehadiran"
                        x-model="selectedParticipant.status"
                        required
                        class="w-full rounded-xl border border-gray-300 px-3.5 py-2 text-xs text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200"
                    >
                        <option value="hadir">Hadir (Standby Sesuai Shift)</option>
                        <option value="izin">Izin (Berhalangan Sakit / Keperluan Mendesak)</option>
                        <option value="digantikan">Digantikan (Diwakilkan Keluarga / Kerabat)</option>
                        <option value="alpha">Alpha (Tidak Hadir Tanpa Keterangan)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Catatan / Nama Pengganti</label>
                    <textarea
                        name="catatan_keterangan"
                        x-model="selectedParticipant.catatan"
                        rows="3"
                        placeholder="Contoh: Digantikan oleh adik kandung / Sakit surat terlampir..."
                        class="w-full rounded-xl border border-gray-300 px-3.5 py-2 text-xs text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200"
                    ></textarea>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2">
                    <button type="button" @click="showModalAbsen = false" class="rounded-xl border border-gray-300 px-4 py-2 text-xs font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-700 dark:text-gray-300">
                        Batal
                    </button>
                    <button type="submit" class="rounded-xl bg-brand-500 px-5 py-2 text-xs font-bold text-white hover:bg-brand-600">
                        Simpan Absensi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
