@extends('layouts.app')

@section('title', 'Data Master Warga')
@section('page_title', 'Data Kependudukan Warga RT 03')

@section('content')
<div class="space-y-6">
    <!-- Header with Search, Filter & Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-gray-900 dark:text-white">Master Data Warga</h2>
            <p class="text-xs text-gray-500 dark:text-gray-400">Total terdata: <strong>{{ $wargas->total() }}</strong> warga di lingkungan RT 03 Kelurahan Kedaung</p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            <a
                href="{{ route('warga.exportPdf', request()->all()) }}"
                target="_blank"
                class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-xs font-bold text-gray-700 shadow-xs hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-200 dark:hover:bg-gray-800 transition"
            >
                <svg class="h-4 w-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Cetak PDF Resmi
            </a>

            <a
                href="{{ route('warga.create') }}"
                class="inline-flex items-center gap-2 rounded-xl bg-brand-500 px-4 py-2.5 text-xs font-bold text-white shadow-md shadow-brand-500/25 hover:bg-brand-600 transition"
            >
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                + Tambah Warga Baru
            </a>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="rounded-2xl border border-gray-200 bg-white p-5 md:p-6 dark:border-gray-800 dark:bg-white/[0.03]">
        <form method="GET" action="{{ route('warga.index') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-3">
            <!-- Search -->
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1">Cari Nama / NIK / No. KK / Blok</label>
                <div class="relative">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Ketik pencarian..."
                        class="w-full rounded-xl border border-gray-300 bg-white pl-9 pr-3.5 py-2 text-xs text-gray-800 focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200"
                    >
                    <svg class="h-4 w-4 absolute left-3 top-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>

            <!-- Status KTP -->
            <div>
                <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1">Status KTP</label>
                <select
                    name="status_ktp"
                    class="w-full rounded-xl border border-gray-300 bg-white px-3 py-2 text-xs text-gray-800 focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200"
                >
                    <option value="">Semua Status KTP</option>
                    <option value="ada" {{ request('status_ktp') == 'ada' ? 'selected' : '' }}>Ada (KTP RT 03 / Domisili)</option>
                    <option value="belum" {{ request('status_ktp') == 'belum' ? 'selected' : '' }}>Belum Ber-KTP</option>
                </select>
            </div>

            <!-- Status Iuran -->
            <div>
                <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1">Status Iuran Kas</label>
                <select
                    name="status_iuran"
                    class="w-full rounded-xl border border-gray-300 bg-white px-3 py-2 text-xs text-gray-800 focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200"
                >
                    <option value="">Semua Iuran</option>
                    <option value="lancar" {{ request('status_iuran') == 'lancar' ? 'selected' : '' }}>Lancar</option>
                    <option value="menunggak" {{ request('status_iuran') == 'menunggak' ? 'selected' : '' }}>Menunggak</option>
                </select>
            </div>

            <!-- Submit / Reset Buttons -->
            <div class="flex items-end gap-2">
                <button
                    type="submit"
                    class="flex-1 rounded-xl bg-gray-900 py-2 text-xs font-bold text-white hover:bg-gray-800 dark:bg-gray-700 dark:hover:bg-gray-600 transition"
                >
                    Filter
                </button>
                @if(request()->anyFilled(['search', 'status_ktp', 'status_iuran', 'jenis_kelamin', 'kondisi_rumah']))
                <a
                    href="{{ route('warga.index') }}"
                    class="rounded-xl border border-gray-300 px-3 py-2 text-xs font-medium text-gray-600 hover:bg-gray-100 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800 transition"
                >
                    Reset
                </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Data Table -->
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="border-b border-gray-200 bg-gray-50/70 text-gray-500 dark:border-gray-800 dark:bg-gray-800/50 uppercase tracking-wider font-semibold">
                    <tr>
                        <th class="py-3.5 px-4">No</th>
                        <th class="py-3.5 px-4">Data Warga</th>
                        <th class="py-3.5 px-4">No. KK</th>
                        <th class="py-3.5 px-4">Alamat Blok</th>
                        <th class="py-3.5 px-4">Pekerjaan</th>
                        <th class="py-3.5 px-4">Penghasilan / Bln</th>
                        <th class="py-3.5 px-4">Tanggungan</th>
                        <th class="py-3.5 px-4">Kondisi Rumah</th>
                        <th class="py-3.5 px-4">Status KTP</th>
                        <th class="py-3.5 px-4">Status Iuran</th>
                        <th class="py-3.5 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-gray-700 dark:text-gray-300">
                    @forelse($wargas as $warga)
                    <tr class="hover:bg-gray-50/70 dark:hover:bg-gray-800/40 transition">
                        <td class="py-3.5 px-4 text-gray-400 font-medium">
                            {{ $loop->iteration + ($wargas->currentPage() - 1) * $wargas->perPage() }}
                        </td>
                        <td class="py-3.5 px-4">
                            <a href="{{ route('warga.show', $warga->id) }}" class="font-bold text-gray-900 dark:text-white hover:text-brand-600 dark:hover:text-brand-400 block">
                                {{ $warga->nama_lengkap }}
                            </a>
                            <span class="text-[11px] text-gray-400">
                                NIK: {{ $warga->nik }} &bull; {{ $warga->jenis_kelamin_label }}, {{ $warga->usia }} thn
                            </span>
                        </td>
                        <td class="py-3.5 px-4 font-mono text-gray-600 dark:text-gray-400">{{ $warga->no_kk }}</td>
                        <td class="py-3.5 px-4 font-medium text-gray-900 dark:text-white">{{ $warga->alamat_blok }}</td>
                        <td class="py-3.5 px-4">{{ $warga->pekerjaan }}</td>
                        <td class="py-3.5 px-4 font-semibold text-gray-900 dark:text-white">
                            {{ $warga->formatted_penghasilan }}
                            <span class="block text-[10px] text-gray-400 font-normal">Skor: {{ $warga->skor_ekonomi }}/5</span>
                        </td>
                        <td class="py-3.5 px-4 text-center font-bold">{{ $warga->jumlah_tanggungan }} Org</td>
                        <td class="py-3.5 px-4">
                            @if($warga->kondisi_rumah === 'layak_huni')
                                <span class="rounded-md bg-emerald-50 px-2 py-0.5 text-[10px] font-semibold text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300">Layak Huni</span>
                            @elseif($warga->kondisi_rumah === 'kurang_layak')
                                <span class="rounded-md bg-amber-50 px-2 py-0.5 text-[10px] font-semibold text-amber-700 dark:bg-amber-950/60 dark:text-amber-300">Kurang Layak</span>
                            @else
                                <span class="rounded-md bg-rose-50 px-2 py-0.5 text-[10px] font-semibold text-rose-700 dark:bg-rose-950/60 dark:text-rose-300">Tidak Layak</span>
                            @endif
                        </td>
                        <td class="py-3.5 px-4">
                            @if($warga->status_ktp === 'ada')
                                <span class="rounded-full bg-emerald-100 px-2.5 py-0.5 text-[10px] font-bold text-emerald-800 dark:bg-emerald-950/80 dark:text-emerald-300">Ada</span>
                            @else
                                <span class="rounded-full bg-rose-100 px-2.5 py-0.5 text-[10px] font-bold text-rose-800 dark:bg-rose-950/80 dark:text-rose-300">Belum KTP</span>
                            @endif
                        </td>
                        <td class="py-3.5 px-4">
                            @if($warga->status_iuran === 'lancar')
                                <span class="rounded-full bg-brand-100 px-2.5 py-0.5 text-[10px] font-bold text-brand-800 dark:bg-brand-950/80 dark:text-brand-300">Lancar</span>
                            @else
                                <span class="rounded-full bg-amber-100 px-2.5 py-0.5 text-[10px] font-bold text-amber-800 dark:bg-amber-950/80 dark:text-amber-300">Menunggak</span>
                            @endif
                        </td>
                        <td class="py-3.5 px-4 text-center">
                            <div class="flex items-center justify-center gap-1.5">
                                <a href="{{ route('warga.show', $warga->id) }}" class="rounded-lg p-1 text-gray-500 hover:bg-gray-100 hover:text-brand-600 dark:hover:bg-gray-800" title="Lihat Detail">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('warga.edit', $warga->id) }}" class="rounded-lg p-1 text-gray-500 hover:bg-gray-100 hover:text-amber-600 dark:hover:bg-gray-800" title="Ubah Data">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('warga.destroy', $warga->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data warga ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-lg p-1 text-gray-500 hover:bg-gray-100 hover:text-rose-600 dark:hover:bg-gray-800" title="Hapus Data">
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
                        <td colspan="11" class="py-8 text-center text-gray-400">
                            Tidak ditemukan data warga yang sesuai dengan kriteria filter.
                        </td>
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
