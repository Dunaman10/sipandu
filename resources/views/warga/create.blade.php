@extends('layouts.app')

@section('title', 'Tambah Data Warga')
@section('page_title', 'Form Pendaftaran Warga Baru')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-extrabold text-gray-900 dark:text-white">Tambah Data Warga</h2>
            <p class="text-xs text-gray-500 dark:text-gray-400">Masukkan data kependudukan secara lengkap untuk RT 03 Kelurahan Kedaung</p>
        </div>
        <a href="{{ route('warga.index') }}" class="rounded-xl border border-gray-300 px-3.5 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-100 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800 transition">
            &larr; Kembali ke Daftar
        </a>
    </div>

    @if($errors->any())
    <div class="rounded-2xl border border-red-200 bg-red-50 p-4 text-xs text-red-700 dark:border-red-900/60 dark:bg-red-950/40 dark:text-red-300">
        <p class="font-bold mb-1">Terjadi kesalahan pengisian form:</p>
        <ul class="list-disc pl-5 space-y-1">
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="rounded-3xl border border-gray-200/80 bg-white p-6 sm:p-8 shadow-xs dark:border-gray-800 dark:bg-gray-900">
        <form method="POST" action="{{ route('warga.store') }}" class="space-y-6">
            @csrf

            <!-- Section 1: Identitas Kependudukan -->
            <div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white pb-3 border-b border-gray-100 dark:border-gray-800 flex items-center gap-2">
                    <span class="flex h-6 w-6 items-center justify-center rounded-lg bg-brand-100 text-brand-700 text-xs font-bold dark:bg-brand-900/60 dark:text-brand-300">1</span>
                    Identitas Kependudukan
                </h3>

                <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Nomor Induk Kependudukan (NIK) <span class="text-red-500">*</span></label>
                        <input
                            type="text"
                            name="nik"
                            value="{{ old('nik') }}"
                            maxlength="16"
                            required
                            placeholder="16 Digit NIK"
                            class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-xs text-gray-800 focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Nomor Kartu Keluarga (No. KK) <span class="text-red-500">*</span></label>
                        <input
                            type="text"
                            name="no_kk"
                            value="{{ old('no_kk') }}"
                            maxlength="16"
                            required
                            placeholder="16 Digit No. KK"
                            class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-xs text-gray-800 focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
                        >
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Nama Lengkap Sesuai KTP <span class="text-red-500">*</span></label>
                        <input
                            type="text"
                            name="nama_lengkap"
                            value="{{ old('nama_lengkap') }}"
                            required
                            placeholder="Nama Lengkap"
                            class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-xs text-gray-800 focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                        <select
                            name="jenis_kelamin"
                            required
                            class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-xs text-gray-800 focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
                        >
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Status KTP <span class="text-red-500">*</span></label>
                        <select
                            name="status_ktp"
                            required
                            class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-xs text-gray-800 focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
                        >
                            <option value="ada" {{ old('status_ktp') == 'ada' ? 'selected' : '' }}>Ada (KTP RT 03 / Domisili Lengkap)</option>
                            <option value="belum" {{ old('status_ktp') == 'belum' ? 'selected' : '' }}>Belum Ber-KTP</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Tempat Lahir</label>
                        <input
                            type="text"
                            name="tempat_lahir"
                            value="{{ old('tempat_lahir') }}"
                            placeholder="Kota Kelahiran"
                            class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-xs text-gray-800 focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Tanggal Lahir <span class="text-red-500">*</span></label>
                        <input
                            type="date"
                            name="tanggal_lahir"
                            value="{{ old('tanggal_lahir') }}"
                            required
                            class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-xs text-gray-800 focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
                        >
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Alamat Blok / Nomor Rumah <span class="text-red-500">*</span></label>
                        <input
                            type="text"
                            name="alamat_blok"
                            value="{{ old('alamat_blok') }}"
                            required
                            placeholder="Contoh: Blok A1 No. 04 RT 03"
                            class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-xs text-gray-800 focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
                        >
                    </div>
                </div>
            </div>

            <!-- Section 2: Sosial Ekonomi & Indikator K-Means -->
            <div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white pb-3 border-b border-gray-100 dark:border-gray-800 flex items-center gap-2">
                    <span class="flex h-6 w-6 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700 text-xs font-bold dark:bg-emerald-900/60 dark:text-emerald-300">2</span>
                    Indikator Sosial Ekonomi (K-Means Clustering)
                </h3>

                <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Pekerjaan Utama <span class="text-red-500">*</span></label>
                        <input
                            type="text"
                            name="pekerjaan"
                            value="{{ old('pekerjaan') }}"
                            required
                            placeholder="Contoh: Buruh, Pedagang, Karyawan Swasta"
                            class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-xs text-gray-800 focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Penghasilan Bulanan (Rp) <span class="text-red-500">*</span></label>
                        <input
                            type="number"
                            name="penghasilan_bulanan"
                            value="{{ old('penghasilan_bulanan', 0) }}"
                            min="0"
                            step="100000"
                            required
                            placeholder="Contoh: 2500000"
                            class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-xs text-gray-800 focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Jumlah Tanggungan Keluarga <span class="text-red-500">*</span></label>
                        <input
                            type="number"
                            name="jumlah_tanggungan"
                            value="{{ old('jumlah_tanggungan', 0) }}"
                            min="0"
                            max="20"
                            required
                            placeholder="Jumlah orang"
                            class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-xs text-gray-800 focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Status Kepemilikan Rumah <span class="text-red-500">*</span></label>
                        <select
                            name="status_kepemilikan_rumah"
                            required
                            class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-xs text-gray-800 focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
                        >
                            <option value="milik_sendiri" {{ old('status_kepemilikan_rumah') == 'milik_sendiri' ? 'selected' : '' }}>Milik Sendiri</option>
                            <option value="sewa_kontrak" {{ old('status_kepemilikan_rumah') == 'sewa_kontrak' ? 'selected' : '' }}>Sewa / Kontrak</option>
                            <option value="menumpang" {{ old('status_kepemilikan_rumah') == 'menumpang' ? 'selected' : '' }}>Menumpang (Keluarga/Kerabat)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Kondisi Fisik Rumah <span class="text-red-500">*</span></label>
                        <select
                            name="kondisi_rumah"
                            required
                            class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-xs text-gray-800 focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
                        >
                            <option value="layak_huni" {{ old('kondisi_rumah') == 'layak_huni' ? 'selected' : '' }}>Layak Huni (Skor: 1)</option>
                            <option value="kurang_layak" {{ old('kondisi_rumah') == 'kurang_layak' ? 'selected' : '' }}>Kurang Layak (Skor: 2)</option>
                            <option value="tidak_layak" {{ old('kondisi_rumah') == 'tidak_layak' ? 'selected' : '' }}>Tidak Layak Huni (Skor: 3)</option>
                        </select>
                    </div>


                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Keterangan Khusus</label>
                        <textarea
                            name="keterangan"
                            rows="2"
                            placeholder="Catatan mengenai kondisi khusus atau bantuan sosial warga..."
                            class="w-full rounded-xl border border-gray-300 px-3.5 py-2.5 text-xs text-gray-800 focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
                        >{{ old('keterangan') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-800">
                <a href="{{ route('warga.index') }}" class="rounded-xl border border-gray-300 px-5 py-2.5 text-xs font-semibold text-gray-700 hover:bg-gray-100 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-800 transition">
                    Batal
                </a>
                <button
                    type="submit"
                    class="rounded-xl bg-brand-500 px-6 py-2.5 text-xs font-bold text-white shadow-md shadow-brand-500/25 hover:bg-brand-600 transition"
                >
                    Simpan Data Warga
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
