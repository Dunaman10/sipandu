@extends('layouts.app')

@section('title', 'Administrasi Keuangan Kas Warga')
@section('page_title', 'Keuangan Kas Warga RT 03')

@section('content')
<div class="space-y-6" x-data="{ showModalTagihan: false, showModalBayar: false }">
    <!-- Header & Action Buttons -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-gray-900 dark:text-white">Administrasi Iuran Kas Warga</h2>
            <p class="text-xs text-gray-500 dark:text-gray-400">Pencatatan kas lingkungan RT 03, transparansi keuangan warga & rekap iuran</p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            <a
                href="{{ route('kas.exportPdf', request()->all()) }}"
                target="_blank"
                class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-xs font-bold text-gray-700 shadow-xs hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 transition"
            >
                <svg class="h-4 w-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Cetak Rekap PDF
            </a>

            <button
                type="button"
                @click="showModalTagihan = true"
                class="inline-flex items-center gap-2 rounded-xl border border-brand-200 bg-brand-50 px-4 py-2.5 text-xs font-bold text-brand-700 hover:bg-brand-100 dark:border-brand-900/60 dark:bg-brand-950/40 dark:text-brand-300 transition"
            >
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                Terbitkan Tagihan Bulanan
            </button>

            <button
                type="button"
                @click="showModalBayar = true"
                class="inline-flex items-center gap-2 rounded-xl bg-brand-500 px-4 py-2.5 text-xs font-bold text-white shadow-md shadow-brand-500/25 hover:bg-brand-600 transition"
            >
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                + Catat Pembayaran
            </button>
        </div>
    </div>

    <!-- 4 Stats Cards for Selected Period -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="rounded-2xl border border-gray-200/80 bg-white p-4 shadow-xs dark:border-gray-800 dark:bg-gray-900">
            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400">Periode Aktif</p>
            <p class="mt-1 text-xl font-extrabold text-gray-900 dark:text-white">
                {{ $selectedPeriode === 'all' ? 'Semua Periode' : $selectedPeriode }}
            </p>
            <p class="mt-1 text-[11px] text-gray-400">Filter berdasarkan bulan terpilih</p>
        </div>

        <div class="rounded-2xl border border-emerald-100 bg-emerald-50/60 p-4 shadow-xs dark:border-emerald-900/30 dark:bg-emerald-950/20">
            <p class="text-xs font-bold text-emerald-800 dark:text-emerald-300">Total Kas Terkumpul (Lunas)</p>
            <p class="mt-1 text-2xl font-black text-emerald-600 dark:text-emerald-400">Rp {{ number_format($totalLunas, 0, ',', '.') }}</p>
            <p class="mt-1 text-[11px] text-emerald-700 dark:text-emerald-300 font-medium">{{ $countLunas }} Pembayaran tercatat</p>
        </div>

        <div class="rounded-2xl border border-rose-100 bg-rose-50/60 p-4 shadow-xs dark:border-rose-900/30 dark:bg-rose-950/20">
            <p class="text-xs font-bold text-rose-800 dark:text-rose-300">Total Tunggakan (Belum Lunas)</p>
            <p class="mt-1 text-2xl font-black text-rose-600 dark:text-rose-400">Rp {{ number_format($totalBelumLunas, 0, ',', '.') }}</p>
            <p class="mt-1 text-[11px] text-rose-700 dark:text-rose-300 font-medium">{{ $countBelumLunas }} Warga belum bayar</p>
        </div>

        <div class="rounded-2xl border border-indigo-100 bg-indigo-50/60 p-4 shadow-xs dark:border-indigo-900/30 dark:bg-indigo-950/20">
            <p class="text-xs font-bold text-indigo-800 dark:text-indigo-300">Persentase Kepatuhan Iuran</p>
            @php
                $totalCount = $countLunas + $countBelumLunas;
                $pct = $totalCount > 0 ? round(($countLunas / $totalCount) * 100, 1) : 0;
            @endphp
            <p class="mt-1 text-2xl font-black text-indigo-600 dark:text-indigo-400">{{ $pct }}%</p>
            <p class="mt-1 text-[11px] text-indigo-700 dark:text-indigo-300 font-medium">{{ $countLunas }} dari {{ $totalCount }} Warga lunas</p>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 dark:border-gray-800 dark:bg-white/[0.03]">
        <form method="GET" action="{{ route('kas.index') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">
            <div>
                <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1">Periode Bulan</label>
                <select
                    name="periode_bulan"
                    class="w-full rounded-xl border border-gray-300 px-3 py-2 text-xs text-gray-800 focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200"
                    onchange="this.form.submit()"
                >
                    <option value="all" {{ $selectedPeriode === 'all' ? 'selected' : '' }}>Semua Periode</option>
                    @foreach($availablePeriodes as $p)
                        <option value="{{ $p }}" {{ $selectedPeriode === $p ? 'selected' : '' }}>{{ $p }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1">Status Pembayaran</label>
                <select
                    name="status_pembayaran"
                    class="w-full rounded-xl border border-gray-300 px-3 py-2 text-xs text-gray-800 focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200"
                    onchange="this.form.submit()"
                >
                    <option value="">Semua Status</option>
                    <option value="lunas" {{ request('status_pembayaran') === 'lunas' ? 'selected' : '' }}>Lunas</option>
                    <option value="belum_lunas" {{ request('status_pembayaran') === 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1">Cari Warga</label>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Nama / NIK / Blok..."
                    class="w-full rounded-xl border border-gray-300 px-3 py-2 text-xs text-gray-800 focus:border-brand-500 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200"
                >
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 rounded-xl bg-gray-900 py-2 text-xs font-bold text-white hover:bg-gray-800 dark:bg-gray-700 dark:hover:bg-gray-600 transition">
                    Terapkan
                </button>
                @if(request()->anyFilled(['search', 'status_pembayaran']) || ($selectedPeriode !== date('Y-m') && $selectedPeriode !== 'all'))
                <a href="{{ route('kas.index') }}" class="rounded-xl border border-gray-300 px-3 py-2 text-xs font-medium text-gray-600 hover:bg-gray-100 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800 transition">
                    Reset
                </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table of Monthly Dues -->
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="border-b border-gray-200 bg-gray-50/70 text-gray-500 dark:border-gray-800 dark:bg-gray-800/50 uppercase tracking-wider font-semibold">
                    <tr>
                        <th class="py-3.5 px-4">No</th>
                        <th class="py-3.5 px-4">Nama Warga</th>
                        <th class="py-3.5 px-4">Alamat Blok</th>
                        <th class="py-3.5 px-4">Periode</th>
                        <th class="py-3.5 px-4">Nominal</th>
                        <th class="py-3.5 px-4">Status Iuran</th>
                        <th class="py-3.5 px-4">Tanggal Bayar</th>
                        <th class="py-3.5 px-4">Bendahara Penerima</th>
                        <th class="py-3.5 px-4 text-center">Tindakan Cepat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-gray-700 dark:text-gray-300">
                    @forelse($kasList as $kas)
                    <tr class="hover:bg-gray-50/70 dark:hover:bg-gray-800/40 transition">
                        <td class="py-3.5 px-4 text-gray-400 font-medium">
                            {{ $loop->iteration + ($kasList->currentPage() - 1) * $kasList->perPage() }}
                        </td>
                        <td class="py-3.5 px-4">
                            <a href="{{ route('warga.show', $kas->warga_id) }}" class="font-bold text-gray-900 dark:text-white hover:text-brand-600 dark:hover:text-brand-400 block">
                                {{ $kas->warga->nama_lengkap }}
                            </a>
                            <span class="text-[11px] text-gray-400">NIK: {{ $kas->warga->nik }}</span>
                        </td>
                        <td class="py-3.5 px-4 font-medium text-gray-900 dark:text-white">{{ $kas->warga->alamat_blok }}</td>
                        <td class="py-3.5 px-4 font-mono font-bold">{{ $kas->periode_bulan }}</td>
                        <td class="py-3.5 px-4 font-extrabold text-gray-900 dark:text-white">{{ $kas->formatted_nominal }}</td>
                        <td class="py-3.5 px-4">
                            @if($kas->status_pembayaran === 'lunas')
                                <span class="rounded-full bg-emerald-100 px-2.5 py-0.5 text-[10px] font-bold text-emerald-800 dark:bg-emerald-950/70 dark:text-emerald-300">Lunas</span>
                            @else
                                <span class="rounded-full bg-rose-100 px-2.5 py-0.5 text-[10px] font-bold text-rose-800 dark:bg-rose-950/70 dark:text-rose-300">Belum Lunas</span>
                            @endif
                        </td>
                        <td class="py-3.5 px-4 text-gray-500">
                            {{ $kas->tanggal_bayar ? $kas->tanggal_bayar->format('d/m/Y') : '-' }}
                        </td>
                        <td class="py-3.5 px-4 text-gray-500">{{ $kas->bendahara->name ?? '-' }}</td>
                        <td class="py-3.5 px-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <form method="POST" action="{{ route('kas.toggleStatus', $kas->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    @if($kas->status_pembayaran === 'lunas')
                                        <button
                                            type="submit"
                                            class="rounded-lg border border-amber-200 bg-amber-50 px-2 py-1 text-[10px] font-bold text-amber-700 hover:bg-amber-100 dark:border-amber-900/60 dark:bg-amber-950/40 dark:text-amber-300"
                                            title="Ubah jadi belum lunas"
                                        >
                                            Batalkan Lunas
                                        </button>
                                    @else
                                        <button
                                            type="submit"
                                            class="rounded-lg bg-emerald-500 px-2 py-1 text-[10px] font-bold text-white hover:bg-emerald-600 shadow-xs"
                                            title="Tandai sudah dibayar lunas"
                                        >
                                            &check; Tandai Lunas
                                        </button>
                                    @endif
                                </form>

                                <form method="POST" action="{{ route('kas.destroy', $kas->id) }}" onsubmit="return confirm('Hapus catatan iuran ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1 text-gray-400 hover:text-rose-600" title="Hapus">
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
                        <td colspan="9" class="py-8 text-center text-gray-400">
                            Belum ada catatan iuran kas untuk filter yang dipilih.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($kasList->hasPages())
        <div class="p-4 border-t border-gray-100 dark:border-gray-800">
            {{ $kasList->links() }}
        </div>
        @endif
    </div>

    <!-- Modal 1: Terbitkan Tagihan Bulanan Massal -->
    <div
        x-show="showModalTagihan"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/50 backdrop-blur-xs"
        x-cloak
    >
        <div @click.outside="showModalTagihan = false" class="w-full max-w-md rounded-3xl bg-white p-6 shadow-2xl dark:bg-gray-900 border border-gray-100 dark:border-gray-800">
            <h3 class="text-base font-bold text-gray-900 dark:text-white mb-2">Terbitkan Tagihan Iuran Bulanan Massal</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">Sistem akan membuat tagihan iuran baru secara otomatis untuk seluruh warga RT 03 yang belum tercatat pada periode tersebut.</p>

            <form method="POST" action="{{ route('kas.generateBulanan') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Periode Bulan Tagihan (YYYY-MM)</label>
                    <input
                        type="month"
                        name="periode_bulan"
                        value="{{ date('Y-m') }}"
                        required
                        class="w-full rounded-xl border border-gray-300 px-3.5 py-2 text-xs text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200"
                    >
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Nominal Iuran per Warga (Rp)</label>
                    <input
                        type="number"
                        name="nominal_iuran"
                        value="50000"
                        min="1000"
                        step="5000"
                        required
                        class="w-full rounded-xl border border-gray-300 px-3.5 py-2 text-xs text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200"
                    >
                </div>

                <div class="flex items-center justify-end gap-2 pt-2">
                    <button type="button" @click="showModalTagihan = false" class="rounded-xl border border-gray-300 px-4 py-2 text-xs font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-700 dark:text-gray-300">
                        Batal
                    </button>
                    <button type="submit" class="rounded-xl bg-brand-500 px-5 py-2 text-xs font-bold text-white hover:bg-brand-600">
                        Terbitkan Tagihan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal 2: Catat Pembayaran Manual -->
    <div
        x-show="showModalBayar"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/50 backdrop-blur-xs"
        x-cloak
    >
        <div @click.outside="showModalBayar = false" class="w-full max-w-lg rounded-3xl bg-white p-6 shadow-2xl dark:bg-gray-900 border border-gray-100 dark:border-gray-800">
            <h3 class="text-base font-bold text-gray-900 dark:text-white mb-2">Catat Pembayaran Iuran Kas RT</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">Input pembayaran langsung atau update tagihan iuran warga</p>

            <form method="POST" action="{{ route('kas.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Pilih Warga <span class="text-red-500">*</span></label>
                    <select
                        name="warga_id"
                        required
                        class="w-full rounded-xl border border-gray-300 px-3.5 py-2 text-xs text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200"
                    >
                        <option value="">-- Pilih Warga --</option>
                        @foreach($wargas as $w)
                            <option value="{{ $w->id }}">{{ $w->nama_lengkap }} ({{ $w->alamat_blok }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Periode Bulan <span class="text-red-500">*</span></label>
                        <input
                            type="month"
                            name="periode_bulan"
                            value="{{ date('Y-m') }}"
                            required
                            class="w-full rounded-xl border border-gray-300 px-3.5 py-2 text-xs text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Nominal Iuran (Rp) <span class="text-red-500">*</span></label>
                        <input
                            type="number"
                            name="nominal_iuran"
                            value="50000"
                            required
                            class="w-full rounded-xl border border-gray-300 px-3.5 py-2 text-xs text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200"
                        >
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Status Pembayaran <span class="text-red-500">*</span></label>
                        <select
                            name="status_pembayaran"
                            required
                            class="w-full rounded-xl border border-gray-300 px-3.5 py-2 text-xs text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200"
                        >
                            <option value="lunas">Lunas</option>
                            <option value="belum_lunas">Belum Lunas</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Tanggal Bayar</label>
                        <input
                            type="date"
                            name="tanggal_bayar"
                            value="{{ date('Y-m-d') }}"
                            class="w-full rounded-xl border border-gray-300 px-3.5 py-2 text-xs text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200"
                        >
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Keterangan Tambahan</label>
                    <textarea
                        name="keterangan"
                        rows="2"
                        placeholder="Contoh: Dibayar tunai melalui Bendahara RT"
                        class="w-full rounded-xl border border-gray-300 px-3.5 py-2 text-xs text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200"
                    ></textarea>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2">
                    <button type="button" @click="showModalBayar = false" class="rounded-xl border border-gray-300 px-4 py-2 text-xs font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-700 dark:text-gray-300">
                        Batal
                    </button>
                    <button type="submit" class="rounded-xl bg-brand-500 px-5 py-2 text-xs font-bold text-white hover:bg-brand-600">
                        Simpan Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
