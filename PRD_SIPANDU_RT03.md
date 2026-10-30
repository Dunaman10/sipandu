# Product Requirements Document (PRD) v3.1

## SIPANDU RT 03 — Sistem Informasi Pemetaan dan Administrasi Data Kependudukan RT 03

---

### 1. Gambaran Umum Produk & Latar Belakang

- **Nama Produk:** SIPANDU RT 03 (_Sistem Informasi Pemetaan dan Administrasi Data Kependudukan RT 03_).
- **Lokasi Studi Kasus:** Lingkungan RT 03, Kelurahan Kedaung[cite: 1].
- **Latar Belakang Masalah:** Berdasarkan analisis skripsi[cite: 1], pengelolaan data di RT 03 sebelumnya masih manual (menggunakan buku tulis dan arsip fisik), memakan waktu lama untuk pelaporan (2–4 jam), rentan duplikasi antara Ketua RT dan Bendahara, serta belum memanfaatkan analisis data untuk penentuan bantuan sosial[cite: 1]. Selain itu, penjadwalan pos ronda malam sering kali kurang terstruktur dan sulit dikoordinasikan.
- **Solusi:** Membangun aplikasi berbasis web menggunakan **Laravel, Blade, Tailwind CSS, MySQL, dan Laravel Herd**[cite: 1] yang terpusat, dilengkapi mesin analisis **K-Means Clustering** otomatis[cite: 1], serta **Modul Jadwal Ronda Malam**.

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
   - Mencetak dan mengekspor laporan data warga dan hasil _clustering_ ke format **PDF** dan **Excel (XLSX)**[cite: 1].
3. **Bendahara:**
   - Melihat daftar dan detail data warga[cite: 1] (tanpa pencatatan ganda di buku terpisah seperti pada sistem berjalan).
   - Mencetak dan mengunduh laporan data warga ke format **PDF** dan **Excel (XLSX)** sebagai bahan koordinasi dengan Ketua RT[cite: 1].

---

### 3. Rincian Fitur & Kebutuhan Fungsional (_Functional Requirements_)

#### Modul 1: Autentikasi & Keamanan

- Sistem menyediakan halaman _login_ terpusat untuk Admin, Ketua RT, dan Bendahara dengan enkripsi password (Bcrypt).

#### Modul 2: Dashboard Interaktif

- Menampilkan kartu statistik ringkas (Total Warga, KK, Warga Belum Punya KTP[cite: 1], Warga Prioritas Bansos (Cluster 1), dan Jadwal Ronda Terdekat).
- Grafik visualisasi proporsi _Cluster K-Means_, sebaran kelompok usia warga, dan persentase kelengkapan KTP.

#### Modul 3: Manajemen Data Warga (CRUD)

- Pengelolaan data lengkap: NIK, No KK, Nama, Jenis Kelamin, Tanggal Lahir, Alamat Blok, Status KTP, Pekerjaan, Penghasilan, Jumlah Tanggungan, Kondisi Rumah[cite: 1], dan Keterangan Khusus.

#### Modul 4: Mesin Algoritma K-Means Clustering

- Transformasi atribut numerik (Usia, Skor Penghasilan, Jumlah Tanggungan)[cite: 1].
- Perhitungan jarak _Euclidean Distance_[cite: 1]:
  $$d(x_i, x_j) = \sqrt{\sum_{l=1}^{n} (x_{il} - x_{jl})^2}$$
- Iterasi otomatis pembaruan _centroid_ hingga konvergen[cite: 1] dan penyimpanan riwayat iterasi ke database untuk keperluan sidang skripsi.

#### Modul 5: Jadwal Ronda Malam (Fitur Publikasi Keamanan)

- **FR-Ronda-01 (Pembuatan & Generate Jadwal):** Ketua RT dapat membuat jadwal ronda secara manual atau menggunakan fitur **Generate Bergilir Otomatis** untuk membagi warga ke dalam regu malam selama periode tertentu.
- **FR-Ronda-02 (Cetak Mading & Share WhatsApp):** Jadwal yang telah di-generate dapat langsung dicetak ke format **PDF Resmi** untuk ditempel di papan mading pos kamling atau diunduh ke format **Excel (XLSX)** untuk dibagikan ke grup WhatsApp warga RT 03.
- **FR-Ronda-03 (Tanpa Fitur Absensi):** Sistem tidak mencatat absensi kehadiran/alpha, melainkan berfokus sebagai instrumen penjadwalan dan publikasi informasi tugas ronda lingkungan.

#### Modul 6: Pelaporan & Cetak Dokumen (PDF & Excel / XLSX)

- Mendukung cetak dan ekspor dokumen laporan dalam dua format:
  1. **PDF:** Menggunakan _Barryvdh Laravel Dompdf_ lengkap dengan kop surat resmi RT 03/RW 02 Kelurahan Kedaung dan tanda tangan pengurus.
  2. **Excel (XLSX):** Format spreadsheet OpenXML murni (.xlsx) agar data kependudukan, hasil analisis clustering, dan jadwal ronda dapat diolah kembali, difilter, atau diarsip secara fleksibel.
- Berlaku untuk seluruh modul laporan: **Data Warga**, **Hasil Clustering K-Means**, dan **Jadwal Ronda Malam**.[cite: 1]

---

### 4. Di Luar Cakupan (_Out of Scope_)

- **Administrasi keuangan / iuran kas warga** tidak termasuk dalam sistem. Sesuai **Batasan Penelitian (1.5)** skripsi, data yang dikelola terbatas pada identitas dasar warga, usia, dan status ekonomi; rumusan masalah dan tujuan penelitian juga tidak mencakup pengelolaan keuangan.

---

### 5. Spesifikasi Teknis (_Tech Stack_)

- **Backend Framework:** Laravel 11 (PHP 8.2+)[cite: 1].
- **Frontend:** Laravel Blade Templating, Tailwind CSS, Alpine.js, Chart.js.
- **Database:** MySQL[cite: 1].
- **Local Server:** Laravel Herd[cite: 1].
- **Code Editor:** Visual Studio Code (VS Code)[cite: 1].
