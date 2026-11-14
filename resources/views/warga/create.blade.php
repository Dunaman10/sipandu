@extends('layouts.app')

@section('title', 'Tambah Data Warga')

@section('content')
<!-- Breadcrumb Start -->
<div class="flex flex-wrap items-center justify-between gap-3 pb-6">
    <div>
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Tambah Data Warga Baru</h2>
        <p class="mt-0.5 text-theme-xs text-gray-500 dark:text-gray-400">
            Masukkan data kependudukan secara lengkap untuk lingkungan RT 03 Kelurahan Kedaung
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
            <li class="text-sm text-gray-800 dark:text-white/90">Tambah Warga</li>
        </ol>
    </nav>
</div>
<!-- Breadcrumb End -->

<div class="space-y-6">
    @if($errors->any())
    <div class="rounded-xl border border-error-500 bg-error-50 p-4 dark:border-error-500/30 dark:bg-error-500/15">
        <div class="flex items-start gap-3">
            <div class="-mt-0.5 text-error-500">
                <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M20.3499 12.0004C20.3499 16.612 16.6115 20.3504 11.9999 20.3504C7.38832 20.3504 3.6499 16.612 3.6499 12.0004C3.6499 7.38881 7.38833 3.65039 11.9999 3.65039C16.6115 3.65039 20.3499 7.38881 20.3499 12.0004ZM11.9999 22.1504C17.6056 22.1504 22.1499 17.6061 22.1499 12.0004C22.1499 6.3947 17.6056 1.85039 11.9999 1.85039C6.39421 1.85039 1.8499 6.3947 1.8499 12.0004C1.8499 17.6061 6.39421 22.1504 11.9999 22.1504ZM13.0008 16.4753C13.0008 15.923 12.5531 15.4753 12.0008 15.4753L11.9998 15.4753C11.4475 15.4753 10.9998 15.923 10.9998 16.4753C10.9998 17.0276 11.4475 17.4753 11.9998 17.4753L12.0008 17.4753C12.5531 17.4753 13.0008 17.0276 13.0008 16.4753ZM11.9998 6.62898C12.414 6.62898 12.7498 6.96476 12.7498 7.37898L12.7498 13.0555C12.7498 13.4697 12.414 13.8055 11.9998 13.8055C11.5856 13.8055 11.2498 13.4697 11.2498 13.0555L11.2498 7.37898C11.2498 6.96476 11.5856 6.62898 11.9998 6.62898Z" fill="#F04438"/>
                </svg>
            </div>
            <div>
                <h4 class="mb-1 text-sm font-semibold text-gray-800 dark:text-white/90">Terjadi kesalahan pengisian form:</h4>
                <ul class="list-disc pl-5 text-sm text-gray-500 dark:text-gray-400 space-y-1">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    <form method="POST" action="{{ route('warga.store') }}" class="space-y-6">
        @csrf

        <!-- Card 1: Identitas Kependudukan -->
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3">
            <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4 sm:px-6 sm:py-5 dark:border-gray-800">
                <div class="flex items-center gap-3">
                    <span class="bg-brand-50 text-brand-500 dark:bg-brand-500/15 dark:text-brand-400 flex h-8 w-8 items-center justify-center rounded-lg text-sm font-semibold">
                        1
                    </span>
                    <div>
                        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                            Identitas Kependudukan
                        </h3>
                        <p class="text-theme-xs text-gray-500 dark:text-gray-400">
                            Data resmi sesuai Kartu Tanda Penduduk (KTP) dan Kartu Keluarga (KK)
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 p-5 sm:grid-cols-2 sm:p-6">
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Nomor Induk Kependudukan (NIK) <span class="text-error-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="nik"
                        value="{{ old('nik') }}"
                        maxlength="16"
                        required
                        placeholder="Masukkan 16 Digit NIK"
                        class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                    />
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Nomor Kartu Keluarga (No. KK) <span class="text-error-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="no_kk"
                        value="{{ old('no_kk') }}"
                        maxlength="16"
                        required
                        placeholder="Masukkan 16 Digit No. KK"
                        class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                    />
                </div>

                <div class="sm:col-span-2">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Nama Lengkap Sesuai KTP <span class="text-error-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="nama_lengkap"
                        value="{{ old('nama_lengkap') }}"
                        required
                        placeholder="Masukkan nama lengkap warga"
                        class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                    />
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Jenis Kelamin <span class="text-error-500">*</span>
                    </label>
                    <div class="relative z-20 bg-transparent">
                        <select
                            name="jenis_kelamin"
                            required
                            class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                        >
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }} class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }} class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">Perempuan</option>
                        </select>
                        <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                            <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                    </div>
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Agama <span class="text-error-500">*</span>
                    </label>
                    <div class="relative z-20 bg-transparent">
                        <select
                            name="agama"
                            required
                            class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                        >
                            @foreach(['Islam', 'Kristen Protestan', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agamaOption)
                                <option value="{{ $agamaOption }}" {{ old('agama', 'Islam') == $agamaOption ? 'selected' : '' }} class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">{{ $agamaOption }}</option>
                            @endforeach
                        </select>
                        <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                            <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                    </div>
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Tempat Lahir
                    </label>
                    <input
                        type="text"
                        name="tempat_lahir"
                        value="{{ old('tempat_lahir') }}"
                        placeholder="Kota kelahiran"
                        class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                    />
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Tanggal Lahir <span class="text-error-500">*</span>
                    </label>
                    <div class="relative">
                        <input
                            type="date"
                            name="tanggal_lahir"
                            value="{{ old('tanggal_lahir') }}"
                            required
                            onclick="this.showPicker && this.showPicker()"
                            class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                        />
                        <span class="pointer-events-none absolute top-1/2 right-3.5 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                            <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M6.66659 1.5415C7.0808 1.5415 7.41658 1.87729 7.41658 2.2915V2.99984H12.5833V2.2915C12.5833 1.87729 12.919 1.5415 13.3333 1.5415C13.7475 1.5415 14.0833 1.87729 14.0833 2.2915V2.99984L15.4166 2.99984C16.5212 2.99984 17.4166 3.89527 17.4166 4.99984V7.49984V15.8332C17.4166 16.9377 16.5212 17.8332 15.4166 17.8332H4.58325C3.47868 17.8332 2.58325 16.9377 2.58325 15.8332V7.49984V4.99984C2.58325 3.89527 3.47868 2.99984 4.58325 2.99984L5.91659 2.99984V2.2915C5.91659 1.87729 6.25237 1.5415 6.66659 1.5415ZM6.66659 4.49984H4.58325C4.30711 4.49984 4.08325 4.7237 4.08325 4.99984V6.74984H15.9166V4.99984C15.9166 4.7237 15.6927 4.49984 15.4166 4.49984H13.3333H6.66659ZM15.9166 8.24984H4.08325V15.8332C4.08325 16.1093 4.30711 16.3332 4.58325 16.3332H15.4166C15.6927 16.3332 15.9166 16.1093 15.9166 15.8332V8.24984Z"/>
                            </svg>
                        </span>
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Alamat Blok / Nomor Rumah <span class="text-error-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="alamat_blok"
                        value="{{ old('alamat_blok') }}"
                        required
                        placeholder="Contoh: Blok A1 No. 04 RT 03"
                        class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                    />
                </div>
            </div>
        </div>

        <!-- Card 2: Indikator Sosial Ekonomi (K-Means Clustering) -->
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3">
            <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4 sm:px-6 sm:py-5 dark:border-gray-800">
                <div class="flex items-center gap-3">
                    <span class="bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-500 flex h-8 w-8 items-center justify-center rounded-lg text-sm font-semibold">
                        2
                    </span>
                    <div>
                        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                            Indikator Sosial Ekonomi (K-Means Clustering)
                        </h3>
                        <p class="text-theme-xs text-gray-500 dark:text-gray-400">
                            Digunakan secara otomatis untuk perhitungan skor prioritas bantuan sosial
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 p-5 sm:grid-cols-2 sm:p-6">
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Status KTP <span class="text-error-500">*</span>
                    </label>
                    <div class="relative z-20 bg-transparent">
                        <select
                            name="status_ktp"
                            required
                            class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                        >
                            <option value="ada" {{ old('status_ktp') == 'ada' ? 'selected' : '' }} class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">Ada (KTP RT 03 / Domisili Lengkap)</option>
                            <option value="belum" {{ old('status_ktp') == 'belum' ? 'selected' : '' }} class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">Belum Ber-KTP</option>
                        </select>
                        <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                            <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                    </div>
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Pekerjaan Utama <span class="text-error-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="pekerjaan"
                        value="{{ old('pekerjaan') }}"
                        required
                        placeholder="Contoh: Buruh, Pedagang, Karyawan Swasta"
                        class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                    />
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Penghasilan Bulanan (Rp) <span class="text-error-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="pointer-events-none absolute top-1/2 left-0 -translate-y-1/2 border-r border-gray-200 px-3.5 py-2.5 text-sm font-medium text-gray-500 dark:border-gray-800 dark:text-gray-400">
                            Rp
                        </span>
                        <input
                            type="number"
                            name="penghasilan_bulanan"
                            value="{{ old('penghasilan_bulanan', 0) }}"
                            min="0"
                            step="100000"
                            required
                            placeholder="Contoh: 2500000"
                            class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pr-4 pl-14 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                        />
                    </div>
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Status Kepemilikan Rumah <span class="text-error-500">*</span>
                    </label>
                    <div class="relative z-20 bg-transparent">
                        <select
                            name="status_kepemilikan_rumah"
                            required
                            class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                        >
                            <option value="milik_sendiri" {{ old('status_kepemilikan_rumah') == 'milik_sendiri' ? 'selected' : '' }} class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">Milik Sendiri</option>
                            <option value="sewa_kontrak" {{ old('status_kepemilikan_rumah') == 'sewa_kontrak' ? 'selected' : '' }} class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">Sewa / Kontrak</option>
                            <option value="menumpang" {{ old('status_kepemilikan_rumah') == 'menumpang' ? 'selected' : '' }} class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">Menumpang (Keluarga/Kerabat)</option>
                        </select>
                        <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                            <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Keterangan Khusus (Opsional)
                    </label>
                    <textarea
                        name="keterangan"
                        rows="3"
                        placeholder="Catatan mengenai kondisi khusus atau riwayat bantuan sosial warga..."
                        class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                    >{{ old('keterangan') }}</textarea>
                </div>
            </div>

            <!-- Form Actions Footer -->
            <div class="flex items-center justify-end gap-3 border-t border-gray-100 px-5 py-4 sm:px-6 dark:border-gray-800">
                <a
                    href="{{ route('warga.index') }}"
                    class="shadow-theme-xs inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/3"
                >
                    Batal
                </a>
                <button
                    type="submit"
                    class="bg-brand-500 shadow-theme-xs hover:bg-brand-600 inline-flex items-center justify-center gap-2 rounded-lg px-5 py-2.5 text-sm font-medium text-white transition"
                >
                    Simpan Data Warga
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
