# Product Requirements Document (PRD) v3.0

## SIPANDU RT 03 — Sistem Informasi Pemetaan dan Administrasi Data Kependudukan RT 03

---

### 1. Gambaran Umum Produk & Latar Belakang

- **Nama Produk:** SIPANDU RT 03 (_Sistem Informasi Pemetaan dan Administrasi Data Kependudukan RT 03_).
- **Lokasi Studi Kasus:** Lingkungan RT 03, Kelurahan Kedaung[cite: 1].
- **Latar Belakang Masalah:** Berdasarkan analisis skripsi[cite: 1], pengelolaan data di RT 03 sebelumnya masih manual (menggunakan buku tulis dan arsip fisik), memakan waktu lama untuk pelaporan (2–4 jam), rentan duplikasi antara Ketua RT dan Bendahara, serta belum memanfaatkan analisis data untuk penentuan bantuan sosial[cite: 1]. Selain itu, penjadwalan pos ronda malam sering kali kurang terstruktur dan sulit dikoordinasikan.
- **Solusi:** Membangun aplikasi berbasis web menggunakan **Laravel, Blade, Tailwind CSS, MySQL, dan Laravel Herd**[cite: 1] yang terpusat, dilengkapi mesin analisis **K-Means Clustering** otomatis[cite: 1], modul administrasi keuangan kas warga, serta **Modul Jadwal & Absensi Ronda Malam**.

---

### 2. Peran & Hak Akses Pengguna (_User Roles_)

Sistem memiliki **3 Aktor Utama** yang diatur menggunakan _Middleware_ Laravel:

1. **Admin (Superadmin):**
   - Mengelola akun pengguna (_CRUD User_ untuk Ketua RT dan Bendahara).
   - Mengatur parameter sistem dan konfigurasi umum aplikasi.
2. **Ketua RT:**
   - Mengelola data master kependudukan warga (Tambah, Edit, Hapus)[cite: 1].
   - Menjalankan algoritma _K-Means Clustering_ untuk mengelompokkan warga (misal: prioritas bantuan sosial)[cite: 1].
   - **Membuat dan mengatur Jadwal Ronda Malam** serta memantau rekap absensi ronda.
   - Mencetak laporan data warga dan hasil _clustering_ ke format **PDF**[cite: 1].
3. **Bendahara:**
   - Melihat daftar data warga[cite: 1].
   - Mengelola dan memperbarui data administrasi iuran kas warga.
   - Membuat laporan keuangan warga dan mencetaknya ke format **PDF**.

---

### 3. Rincian Fitur & Kebutuhan Fungsional (_Functional Requirements_)

#### Modul 1: Autentikasi & Keamanan

- Sistem menyediakan halaman _login_ terpusat untuk Admin, Ketua RT, dan Bendahara dengan enkripsi password (Bcrypt).

#### Modul 2: Dashboard Interaktif

- Menampilkan kartu statistik ringkas (Total Warga, KK, Warga Belum Punya KTP[cite: 1], Kas RT, dan Jadwal Ronda Terdekat).
- Grafik visualisasi proporsi _Cluster K-Means_ (Chart.js).

#### Modul 3: Manajemen Data Warga (CRUD)

- Pengelolaan data lengkap: NIK, No KK, Nama, Jenis Kelamin, Tanggal Lahir, Alamat Blok, Status KTP, Pekerjaan, Penghasilan, Jumlah Tanggungan, dan Kondisi Rumah[cite: 1].

#### Modul 4: Mesin Algoritma K-Means Clustering

- Transformasi atribut numerik (Usia, Skor Penghasilan, Jumlah Tanggungan)[cite: 1].
- Perhitungan jarak _Euclidean Distance_[cite: 1]:
  $$d(x_i, x_j) = \sqrt{\sum_{l=1}^{n} (x_{il} - x_{jl})^2}$$
- Iterasi otomatis pembaruan _centroid_ hingga konvergen[cite: 1] dan penyimpanan riwayat iterasi ke database untuk keperluan sidang skripsi.

#### Modul 5: Administrasi Keuangan (Kas Warga)

- Pencatatan iuran bulanan warga oleh Bendahara, status lunas/belum lunas, serta rekapitulasi kas masuk/keluar.

#### Modul 6: Jadwal & Absensi Ronda Malam (Fitur Baru)

- **FR-Ronda-01 (Pembuatan Jadwal):** Ketua RT dapat membuat jadwal ronda per tanggal dengan memasukkan daftar warga yang bertugas secara bergiliran untuk shift malam.
- **FR-Ronda-02 (Pencatatan Absensi):** Ketua RT atau petugas piket dapat menandai status kehadiran warga yang bertugas (_Hadir, Izin, Alpha, atau Digantikan_).
- **FR-Ronda-03 (Catatan / Keterangan):** Menyimpan alasan izin atau nama warga pengganti apabila yang bersangkutan berhalangan hadir.
- **FR-Ronda-04 (Rekapitulasi Ronda):** Menampilkan riwayat keaktifan ronda warga sebagai bahan evaluasi keamanan lingkungan RT 03.

#### Modul 7: Pelaporan & Cetak Dokumen (PDF)

- Integrasi _Barryvdh Laravel Dompdf_ untuk mencetak laporan data warga, hasil _clustering_[cite: 1], rekap kas, dan jadwal ronda ke format **PDF** lengkap dengan kop surat resmi RT 03.

---

### 4. Spesifikasi Teknis (_Tech Stack_)

- **Backend Framework:** Laravel 11 (PHP 8.2+)[cite: 1].
- **Frontend:** Laravel Blade Templating, Tailwind CSS, Alpine.js, Chart.js.
- **Database:** MySQL[cite: 1].
- **Local Server:** Laravel Herd[cite: 1].
- **Code Editor:** Visual Studio Code (VS Code)[cite: 1].
