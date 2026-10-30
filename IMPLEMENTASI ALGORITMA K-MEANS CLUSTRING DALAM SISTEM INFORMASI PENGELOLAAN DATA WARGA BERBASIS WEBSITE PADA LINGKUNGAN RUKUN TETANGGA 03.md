- **IMPLEMENTASI SISTEM APLIKASI MENGGUNAKAN ALGORITMA** **_K-MEANS CLUSTERING_ UNTUK PENGELOLAAN DATA WARGA BERBASIS** **_WEBSITE_** 

**PADA LINGKUNGAN RUKUN TETANGGA 03** 

# **SKRIPSI** 



<!-- Start of picture text -->
SS SON<br>2 z<br>eS) (>)<br>q:& 3)ba<br>* ,<br>| Raw $7<br><!-- End of picture text -->

**OLEH:** 

# **DWIKI ALDIANSYAH** 

**221011402786** 

# **PROGRAM STUDI TEKNIK INFORMATIKA** 

# **FAKULTAS ILMU KOMPUTER** 

# **UNIVERSITAS PAMULANG** 

**2025** 

# **KATA PENGANTAR** 

Puji dan syukur penulis panjatkan ke hadirat Tuhan Yang Maha Esa atas segala rahmat, nikmat, dan karunia-Nya sehingga penulis dapat menyelesaikan penyusunan skripsi yang berjudul “Implementasi Sistem Aplikasi Menggunakan Algoritma _K-Means Clustering_ Untuk Pengelolaan Data Warga Berbasis _Website_ Pada Lingkungan Rukun Tetangga 03”. Skripsi ini disusun sebagai salah satu syarat untuk menyelesaikan Program Sarjana pada Program Studi Teknik Informatika, Fakultas Ilmu Komputer, Universitas Pamulang. 

Penyusunan skripsi ini tidak terlepas dari berbagai bantuan, dukungan, dan bimbingan dari berbagai pihak. Oleh karena itu, pada kesempatan ini penulis ingin mengucapkan terima kasih yang sebesar-besarnya kepada: 

1. Dr. Pranoto, S.E., M.M **.** , selaku Kepala Yayasan Universitas Pamulang yang selalu memberikan dukungan terhadap kegiatan akademik mahasiswa. 

2. Dr. H. E. Nurzaman, AM., M.M., M.Si., selaku Rektor Universitas Pamulang. 

3. Yan Mitha Djaksana, S.Kom., M.Kom., selaku Dekan Fakultas Ilmu Komputer Universitas Pamulang. 

4. Dr. Eng. Ahmad Musyafa, S.Kom., M.Kom., selaku Ketua Program Studi Teknik Informatika Universitas Pamulang. 

5. Eka Sri Rahayu, S.Kom.,M.Kom. selaku dosen penguji skripsi yang telah memberikan arahan, masukan, dan motivasi. 

6. Kedua orang tua tercinta, yang selalu memberikan doa, dukungan moral, serta semangat tanpa henti. 

7. Teman-teman mahasiswa Teknik Informatika, khususnya rekan seperjuangan yang selalu membantu memberikan wawasan, ide, serta diskusi konstruktif selama proses penyelesaian tugas akhir. 

Penulis menyadari bahwa skripsi ini masih jauh dari sempurna karena keterbatasan pengetahuan dan pengalaman. Oleh sebab itu, kritik dan saran yang bersifat membangun akan sangat penulis harapkan demi perbaikan di masa mendatang. Semoga skripsi ini dapat memberikan manfaat bagi pembaca, khususnya dalam pengembangan sistem aplikasi dan penerapan algoritma data _K-Means Clustering_ . 

# **DAFTAR ISI** 

|**KATA PENGANTAR**.............................................................................................................................i|
|---|
|**DAFTAR ISI**...........................................................................................................................................ii|
|**DAFTAR GAMBAR**.............................................................................................................................iii|
|**DAFTAR TABEL**..................................................................................................................................iv|
|**BAB I PENDAHULUAN**.......................................................................................................................5|
|**1.1 Latar Belakang**.............................................................................................................................5|
|**1.2 Identifikasi Masalah**....................................................................................................................6|
|**1.3 Rumusan Masalah**.......................................................................................................................6|
|**1.4 Tujuan Penelitian**.........................................................................................................................6|
|**1.5 Batasan Penelitian**........................................................................................................................7|
|**1.6 Manfaat Penelitian**.......................................................................................................................7|
|**1.7 Metodologi Penelitian**..................................................................................................................7|
|**1.7.1 Metode Pengumpulan Data.............................................................................................8**|
|**1.7.2 Metode pengembangan sistem........................................................................................9**|
|**1.8 Sitematika Penulisan**.................................................................................................................10|
|**BAB II LANDASAN TEORI**..............................................................................................................12|
|**2.1 Penelitian Yang Relavan**...........................................................................................................12|
|**2.2 Teori Umum**...............................................................................................................................17|
|**2.2.1 Implementasi.................................................................................................................17**|
|**2.2.3 Data Warga....................................................................................................................18**|
|**2.2.4 Website..........................................................................................................................18**|
|**2.2.5 K-Means.........................................................................................................................18**|
|**2.2.6 Clustring.........................................................................................................................20**|
|**2.3 Teori Perancangan Basis Data**..................................................................................................20|
|**2.3.1 Basis Data.......................................................................................................................20**|
|**2.3.2 Entity Relationship Diagram (ERD).................................................................................20**|
|**2.3.3 Logic Record Structure (LRS)...........................................................................................20**|
|**2.3 Aplikasi Pendukung**...................................................................................................................20|
|**2.3.1 Visual Studio Code (VS Code).........................................................................................20**|
|**2.3.2 HyperText Markup Language (HTML).............................................................................20**|
|**2.3.3 Cascading Style Sheets (CSS)..........................................................................................21**|
|**2.3.4 Hypertext Preprocessor (PHP)........................................................................................21**|
|**2.3.5****_XAMPP_...........................................................................................................................22**|



|**BAB III ANALISA DAN PERANCANGAN SISTEM**....................................................................22|
|---|
|**3.1 Analisa Sistem**............................................................................................................................22|
|**3.2 Analisa Sistem Berjalan**............................................................................................................23|
|**3.3 Analisa Sistem usulan**................................................................................................................25|



# **DAFTAR GAMBAR** 

|Gambar 1.Rumus K-means 1...................................................................................................19|
|---|
|Gambar 2.Rumus K-Means 2...................................................................................................19|
|Gambar 3.Kerangka Berfikir....................................................................................................20|
|Gambar 4. DiagraAm Sistem Berjalan.....................................................................................24|
|Gambar 5.Diagram Sistem Usulan...........................................................................................26|



**DAFTAR TABEL** 

# **BAB I** 

# **PENDAHULUAN** 

# **1.1 Latar Belakang** 

Lingkungan Rukun Tetangga (RT) merupakan unit organisasi masyarakat terkecil yang memiliki peran penting dalam mendukung kegiatan administrasi kependudukan, keamanan lingkungan, serta koordinasi sosial antarwarga. Dalam pelaksanaannya, pengelolaan data warga pada tingkat RT masih sering dilakukan secara manual, seperti pencatatan dalam buku, lembar _excel_ sederhana, atau arsip dokumen fisik. Cara ini menimbulkan berbagai kendala, seperti data sulit diperbarui, rawan hilang, tidak terstruktur, serta menyulitkan proses pendataan ulang ketika dibutuhkan. 

RT 03 sebagai bagian dari komunitas masyarakat di lingkungan kelurahan Kedaung juga menghadapi masalah serupa. Data warga yang terdiri dari data jumlah keluarga, kondisi ekonomi, dan distribusi tempat tinggal belum terkelola dengan baik. Kondisi ini menghambat proses pelayanan administrasi, seperti penerbitan surat keterangan, pendataan bantuan sosial, hingga perencanaan kegiatan kemasyarakatan. 

Untuk mengatasi permasalahan tersebut, diperlukan pengembangan sistem aplikasi pengelolaan data warga berbasis _website_ sehingga data dapat tersimpan secara terpusat, mudah diakses, dan diperbarui secara _real time_ . Selain itu, agar data tidak hanya tersimpan namun juga dapat dimanfaatkan sebagai dasar pengambilan 

5 

6 

keputusan, perlu diterapkan metode analisis data, salah satunya algoritma _K-Means Clustering_ **_._** 

Algoritma _K-Means Clustering_ memungkinkan pemetaan kelompok warga berdasarkan karakteristik tertentu, seperti penerima bantuan sosial dan yang belum mempunyai KTP. Hasil _clustering_ ini dapat digunakan sebagai dasar pembuatan program bantuan sosial, dan memudahkan pengurus RT dalam mengelola data. 

Dengan demikian, penerapan sistem aplikasi berbasis _website_ yang terintegrasi dengan algoritma _K-Means Clustering_ akan memberikan manfaat tidak hanya dari sisi penyimpanan data tetapi juga meningkatkan nilai informasi sebagai dasar pengambilan keputusan di RT 03. 

# **1.2 Identifikasi Masalah** 

Berdasarkan latar belakang, masalah yang dapat diidentifikasi adalah: 

1. Pengelolaan data warga masih dilakukan secara manual sehingga rawan kehilangan data dan masih belum _konsisten_ . 

2. Tidak terdapat sistem aplikasi berbasis _website_ yang memudahkan pengurus RT dalam pendataan dan pembaruan data. 

3. Data warga belum dianalisis untuk mendukung proses pengambilan keputusan, khususnya dalam pengelompokan karakteristik warga. 

# **1.3 Rumusan Masalah** 

Berdasarkan latar belakang masalah yang dapat didentifikasi adalah: 

1. Bagaimana membangun sistem aplikasi pengelolaan data warga berbasis _website_ pada lingkungan RT 03? 

2. Bagaimana mengimplementasikan algoritma _K-Means Clustering_ untuk mengelompokkan data warga pada sistem tersebut? 

7 

3. Bagaimana hasil pengelompokan data warga dapat digunakan sebagai dasar pengambilan keputusan di lingkungan RT 03? 

# **1.4 Tujuan Penelitian** 

Berdasarkan pemahaman yang telah diteliti, tujuan dari penulisan skripsi ini adalah: 

1. Membangun sistem aplikasi pengelolaan data warga berbasis _website_ yang dapat memudahkan pengelolaan data pada RT 03. 

2. Mengimplementasikan algoritma _K-Means Clustering_ untuk mengelompokkan data warga berdasarkan atribut tertentu. 

3. Menghasilkan aplikasi pengelompokan yang dapat digunakan sebagai dasar perencanaan dan kebijakan RT 03. 

# **1.5 Batasan Penelitian** 

Untuk memudahkan pemahaman, fokus, dan arahan penelitian sesuai 

dengan rumusan yang telah ditentukan, maka permasalahan dibatasi seperti berikut: 

1. Data yang dikelola terbatas pada data identitas dasar warga, usia, dan status ekonomi. 

2. Algoritma _clustering_ yang digunakan hanya _K-Means Clustering_ . 

3. Pengujian dilakukan pada lingkungan RT 03 sebagai ruang lingkup penelitian. 

# **1.6 Manfaat Penelitian** 

Manfaat yang bisa didapatkan dari penelitian tersebut antara lain adalah sebagai 

berikut: 

1. Manfaat bagi penulis 

   - Menambah pengalaman dalam menerapkan teori algortima _K-Means Clustering_ pada sistem nyata dan sebagai bentuk pengembangan kemampuan dalam membangun sistem aplikasi berbasis _website_ . 

2. Manfaat bagi pengguna 

8 

Memudahkan proses pendataan dan pengelolaan aplikasi warga secara lebih cepat, akurat dan terstruktur, serta mengurangi kesalahan pencatatan yang sering terjadi pada proses manual. 

3. Manfaat bagi instansi 

Mempercepat proses rekapitulasi data warga Ketika dibutuhkan dalam kegiatan _administrative_ , serta mendukung penyusunan program sosial berbasis data yang lebih tepat sasaran. 

# **1.7 Metodologi Penelitian** 

Metodologi penelitian merupakan langkah sistematis yang digunakan peneliti untuk memperoleh data, menganalisis aplikasi, serta menghasilkan jawaban atas rumusan masalah. Penelitian berjudul **"Implementasi Sistem Aplikasi Menggunakan Algoritma** **_K-Means Clustering_ Untuk Pengelolaan Data Warga Berbasis** **_Website_ Pada Lingkungan Rukun Tetangga 03"** menggunakan tahapan metodologi yang disusun secara terstruktur agar hasil penelitian akurat, valid, dan dapat dipertanggungjawabkan. 

Penelitian ini menggunakan dua metode utama, yaitu metode pengumpulan data dan metode pengembangan sistem (SDLC) **.** 

# **1.7.1 Metode Pengumpulan Data** 

# **a. Observasi** 

Observasi dilakukan secara langsung pada lingkungan Rukun Tetangga 03 untuk mengamati proses pendataan warga, alur administrasi, serta permasalahan yang muncul dalam proses pengelolaan data. Observasi ini digunakan untuk mengetahui kebutuhan nyata pengguna serta kendala yang dialami pengurus 

9 

RT, seperti pendataan manual, rentan kesalahan pencatatan, dan kesulitan 

melakukan pengelompokkan data warga. 

# **b. Wawancara** 

Wawancara dilakukan dengan Ketua RT, Sekretaris RT, dan beberapa warga yang terlibat dalam kegiatan administrasi. Tujuan wawancara adalah memperoleh informasi mendalam terkait kebutuhan sistem, jenis data warga yang dikelola, kategori pengelompokan yang dibutuhkan, serta evaluasi terhadap sistem pendataan yang digunakan saat ini. 

# **c. Studi Pustaka** 

Teknik pengumpulan data dilakukan melalui pengkajian jurnal, buku teks, artikel ilmiah, dan penelitian terdahulu yang berkaitan dengan: 

- a. Sistem aplikasi berbasis _website_ 

- b. Algoritma _K-Means Clustering_ 

- c. Pengelolaan data kependudukan 

- d. Teknologi pendukung ( _HTML, PHP, CSS, MySQL, XAMPP_ ). 

Sumber pustaka digunakan sebagai dasar teori dalam perancangan sistem 

serta pembuktian relevansi penggunaan algoritma _K-Means Clustering._ 

# **1.7.2 Metode pengembangan sistem** 

Penelitian ini menggunakan metode _System Development Life Cycle (SDLC)_ model _Waterfall_ , karena sesuai diterapkan pada pengembangan sistem yang terstruktur serta membutuhkan dokumentasi lengkap. Tahapan model _Waterfall_ meliputi: 

10 

# **a.** **_Communication (Requirement Analysis)_** 

Pada tahap ini peneliti berkomunikasi dengan pengurus RT untuk mengidentifikasi kebutuhan pengguna, kebutuhan sistem, jenis data warga, dan proses bisnis yang harus didukung oleh sistem aplikasi. 

# **b.** **_Planning_** 

Tahap perencanaan dilakukan untuk menentukan ruang lingkup proyek, estimasi waktu, kebutuhan perangkat lunak serta perangkat keras, dan penjadwalan penelitian. 

# **c.** **_Analysis_** 

Tahap perencanaan dilakukan untuk menentukan ruang lingkup proyek, estimasi waktu, kebutuhan perangkat lunak serta perangkat keras, dan penjadwalan penelitian. 

# **d.** **_Design_** 

Pada tahap desain, dibuat rancangan arsitektur sistem, desain basis data, desain antarmuka _(UI)_ , diagram alur, serta integrasi algoritma _K-Means Clustering_ ke dalam proses pengelolaan data warga. 

# **e.** **_Implementation_** 

Tahap implementasi dilakukan dengan membangun sistem berdasarkan desain 

yang telah dibuat menggunakan _PHP, HTML, CSS, dan MySQL_ . Algoritma _K-_ 

11 

_Means Clustering_ diimplementasikan untuk mengelompokkan data warga berdasarkan variabel tertentu (misalnya kondisi ekonomi, usia, dan lainnya). 

# **f.** **_Testing_** 

Pengujian dilakukan untuk memastikan fungsi sistem berjalan optimal, mulai dari proses input data, pengolahan _clustering_ , hingga tampilan hasil pengelompokan. Pengujian dilakukan menggunakan metode _blackbox testing_ . 

# **1.8 Sitematika Penulisan** 

Sistematika penulisan laporan penelitian ini disusun dalam beberapa bab dan subbab yang saling berkaitan. Adapun pembagian isi laporan adalah sebagai berikut: 

# **BAB I PENDAHULUAN** 

Bab ini menyajikan uraian mengenai latar belakang penelitian, identifikasi masalah, rumusan masalah, batasan penelitian, tujuan penelitian, manfaat penelitian, metodologi penelitian, dan sistematika penulisan. Bagian ini memberikan gambaran awal mengenai alasan pentingnya penelitian dilakukan serta arah penelitian secara keseluruhan. 

# **BAB II** 

# **LANDASAN TEORI** 

Bab ini berisi teori-teori pendukung yang digunakan sebagai dasar penelitian, mulai dari konsep sistem aplikasi, _website, HTML, CSS, PHP, XAMPP, NEXTJS_ , hingga algoritma _K-Means Clustering._ Selain itu, bab ini juga mencakup penelitian terdahulu yang relevan serta kerangka berpikir yang menjadi alur perumusan solusi dalam penelitian. 

# **BAB III** 

# **ANALISA DAN PERANCANGAN** 

12 

Bab ini membahas analisis sistem berjalan pada lingkungan RT 03, analisis kebutuhan sistem baru, serta proses perancangan sistem. Perancangan mencakup desain basis data, rancangan antarmuka, diagram alur proses, hingga integrasi _K-Means Clustering_ dalam pengolahan data warga. 

# **BAB VI** 

# **IMPLEMENTASI DAN PENGUJIAN** 

Bab ini menjelaskan implementasi sistem aplikasi berbasis website yang telah dirancang, mulai dari implementasi tampilan, proses bisnis, sampai pengaplikasian algoritma _K-Means_ pada data warga. Pengujian sistem dilakukan untuk memastikan bahwa sistem berfungsi sesuai kebutuhan pengguna dan mampu melakukan _clustering_ secara akurat. 

# **BAB V** 

# **PENUTUP** 

Bab terakhir berisi kesimpulan dari hasil penelitian dan saran untuk pengembangan sistem di masa mendatang. 

# **BAB II** 

# **LANDASAN TEORI** 

# **2.1 Penelitian Yang Relavan** 

Berdasarkan kajian terhadap berbagai sumber literatur, ditemukan beberapa penelitian terdahulu yang memiliki keterkaitan dengan topik penelitian ini. Hasil penelusuran tersebut menjadi landasan dalam memahami perkembangan dan pendekatan yang telah digunakan pada penelitian sejenis. Adapun ringkasan dari penelitian-penelitian tersebut dapat dipaparkan sebagai berikut: 

1. Penelitian yang berjudul “Pengelompokan Data Penduduk di Desa Penembang Menggunakan Algoritma K-Means Clustering untuk Program Bantuan Sosial” karya Artha Dwika Santosa, Herlina Latipa Sari, dan Prahasti bertujuan untuk membantu pemerintah Desa Penembang dalam menentukan prioritas penerima bantuan sosial agar lebih tepat sasaran. Penelitian ini dilatarbelakangi oleh proses pendataan penduduk dan penentuan penerima bantuan sosial yang masih dilakukan secara langsung dan melalui musyawarah desa, sehingga masih terdapat penduduk yang membutuhkan bantuan tetapi belum mendapatkannya. Untuk mengatasi permasalahan tersebut, peneliti menerapkan algoritma K-Means Clustering dengan menggunakan tiga variabel penilaian, yaitu jumlah anggota keluarga yang menjadi tanggungan, kondisi rumah, dan jumlah pendapatan per hari. Pengembangan aplikasi menggunakan metode Waterfall, dengan bahasa pemrograman Visual Basic .NET dan database SQL Server. Pengujian 

12 

13 

dilakukan terhadap 30 kepala keluarga (KK), yaitu sekitar 12,5% dari total 241 KK pada tahun 2024. Hasil penelitian menunjukkan bahwa data penduduk berhasil dikelompokkan menjadi dua kelompok, yaitu Cluster C1 yang terdiri dari 12 KK atau 40% yang sangat membutuhkan bantuan, serta Cluster C2 yang terdiri dari 18 KK atau 60% yang tidak membutuhkan bantuan. Hasil pengujian menunjukkan bahwa aplikasi dapat berfungsi dengan baik, mudah dioperasikan, dan membantu pemerintah desa memperoleh informasi mengenai pengelompokan penduduk. Dengan demikian, penerapan algoritma K-Means Clustering dapat membantu pemerintah Desa Penembang mengelola data penduduk dan menentukan prioritas penerima bantuan sosial. Penelitian ini juga menyarankan pengembangan lebih lanjut dengan membandingkan algoritma K-Means dengan metode lain, seperti K-Medoids dan Fuzzy C-Means, untuk memperoleh hasil pengelompokan yang dapat dievaluasi lebih lanjut (Bantuan Sosial et al., 2026). 

2. (Aria Alfaizi et al., 2023). Penelitian yang berjudul “Sistem Pendukung 

Keputusan Penerima Bantuan Langsung Tunai Dana Desa Menggunakan Metode Algoritma K-Means Clustering” karya Sarmila Sari dan Joy Nashar Utamajaya bertujuan untuk membantu pemerintah Desa Sesulu dalam menentukan masyarakat yang layak menerima Bantuan Langsung Tunai Dana Desa (BLT-DD) agar penyalurannya lebih tepat sasaran. Penelitian ini dilatarbelakangi oleh permasalahan penyaluran bantuan pada tahun 2020 hingga 2021, yaitu kesulitan dalam mengolah data penduduk dan menentukan prioritas penerima bantuan karena banyaknya masyarakat yang 

14 

mengajukan permohonan. Untuk mengatasi permasalahan tersebut, peneliti menerapkan metode K-Means Clustering dengan menggunakan data dari 336 penduduk yang mengusulkan bantuan BLT-DD pada tahun 2021. Pengelompokan dilakukan berdasarkan variabel pekerjaan, jumlah tanggungan keluarga, kondisi rumah, dan penghasilan, sedangkan nama digunakan sebagai identitas penduduk. Data yang awalnya berbentuk kategori diubah menjadi nilai numerik agar dapat diproses menggunakan algoritma K-Means. Selanjutnya, hasil perhitungan manual dievaluasi menggunakan perangkat lunak RapidMiner Studio versi 5.3. Hasil penelitian menunjukkan bahwa data penduduk terbagi menjadi tiga kelompok, yaitu kelompok penerima bantuan yang tepat sasaran sebanyak 87 orang, kelompok yang perlu dipertimbangkan sebanyak 193 orang, dan kelompok penerima bantuan yang dinilai tidak tepat sasaran sebanyak 56 orang. Kelompok yang dinilai paling layak menerima bantuan terdiri atas masyarakat yang bekerja sebagai buruh, memiliki rumah berbahan papan, dan berpenghasilan kurang dari Rp500.000. Hasil pengelompokan secara manual dan menggunakan RapidMiner menunjukkan hasil yang sama. Dengan demikian, penerapan algoritma K-Means Clustering dapat membantu pemerintah Desa Sesulu mengelompokkan data penduduk berdasarkan karakteristik sosial ekonomi sehingga mempermudah proses penentuan prioritas penerima BLT-DD. Penelitian ini menyarankan agar penelitian selanjutnya menggunakan algoritma atau mengombinasikan metode lain untuk membandingkan hasil dan memperoleh pengelompokan yang lebih baik (Aria Alfaizi et al., 2023). 

15 

3. Penelitian yang dilakukan oleh Suci Rainaya dan Sofia Dewi pada tahun 2025 dalam artikel berjudul “Penerapan Data Mining Penyaluran Dana Bantuan Sosial Menggunakan Metode K-Means Clustering di Desa Rancaekek Kulon” bertujuan untuk membantu pemerintah desa menentukan masyarakat yang layak dan tidak layak menerima bantuan sosial dari dana desa. Penelitian ini dilatarbelakangi oleh permasalahan ketidakakuratan data penduduk yang menyebabkan penyaluran bantuan sosial berpotensi tidak tepat sasaran. Selain itu, proses penentuan penerima bantuan yang masih bergantung pada rekomendasi Rukun Tetangga (RT) dan Rukun Warga (RW) dinilai membutuhkan waktu dan kurang efisien. Oleh karena itu, diperlukan penerapan teknologi data mining untuk membantu proses pengelompokan masyarakat berdasarkan kriteria yang telah ditentukan. Penelitian ini menggunakan metode deskriptif kuantitatif dengan algoritma K-Means Clustering. Pengumpulan data dilakukan melalui observasi, wawancara, studi pustaka, dan studi dokumentasi di Desa Rancaekek Kulon. Data yang digunakan merupakan data kependudukan tahun 2023. Dari 547 data penduduk yang dikumpulkan, sebanyak 526 data digunakan setelah melalui proses pembersihan untuk menghilangkan data duplikat. Pengelompokan masyarakat dilakukan berdasarkan lima atribut, yaitu usia kepala keluarga, status perkawinan, pekerjaan, penghasilan, dan jumlah tanggungan. Proses pengolahan data dilakukan melalui Microsoft Excel, kemudian hasilnya diuji menggunakan perangkat lunak RapidMiner untuk mengetahui kualitas pengelompokan yang dihasilkan. Hasil penelitian menunjukkan bahwa algoritma K-Means Clustering berhasil 

16 

membentuk dua kelompok masyarakat, yaitu cluster 0 yang dikategorikan sebagai masyarakat tidak layak menerima bantuan sosial dan cluster 1 yang dikategorikan sebagai masyarakat layak menerima bantuan sosial. Berdasarkan perhitungan menggunakan Microsoft Excel, terdapat 232 data masyarakat dalam kategori tidak layak dan 294 data dalam kategori layak. Sementara itu, hasil pengujian menggunakan RapidMiner menunjukkan sebanyak 206 data pada kategori tidak layak dan 320 data pada kategori layak. Perbedaan jumlah anggota cluster tersebut menunjukkan bahwa hasil pengelompokan dari kedua proses perhitungan belum sepenuhnya sama (Rainaya & Dewi, 2025). 

4. (Penerima Bantuan Dana Sosial PKH Di Kelurahan Kampung Singkep Sari Ufriani & Arviita SKom, 2023). Penelitian yang dilakukan oleh Sari Ufriani, Dr. Jasmir, S.Kom., dan Yulia Arviita, S.Kom., M.S.I. (2023) berjudul “Penerapan Algoritma Clustering K-Means untuk Menentukan Prioritas Penerima Bantuan Dana Sosial PKH di Kelurahan Kampung Singkep” bertujuan untuk membantu proses penentuan prioritas penerima bantuan Program Keluarga Harapan (PKH) agar penyalurannya lebih tepat sasaran berdasarkan kondisi dan kebutuhan masyarakat. Penelitian ini dilatarbelakangi oleh permasalahan penyaluran bantuan sosial yang belum merata dan kurang tepat sasaran akibat validasi data yang kurang optimal. Data yang digunakan merupakan data penduduk tahun 2020 sebanyak 1.001 kepala keluarga di Kelurahan Kampung Singkep, Kecamatan Muara Sabak Barat, Kabupaten Tanjung Jabung Timur, Provinsi Jambi. Peneliti menerapkan metode K-Means Clustering dengan bantuan perangkat lunak 

17 

SPSS serta melakukan perhitungan manual sebagai pembanding. Data diolah melalui tahapan seleksi, transformasi, penentuan centroid awal, perhitungan jarak menggunakan Euclidean Distance, pengelompokan data berdasarkan centroid terdekat, dan pembaruan centroid hingga hasil pengelompokan stabil. Atribut yang digunakan dalam proses clustering meliputi jumlah tanggungan atau tunjangan, penghasilan, status sosial, status kepemilikan rumah, dan kondisi rumah. Pengelompokan dilakukan menjadi tiga cluster prioritas, yaitu prioritas pertama, prioritas kedua, dan prioritas ketiga, dengan proses perhitungan sebanyak tujuh iterasi. Hasil penelitian menunjukkan bahwa cluster 1 berisi 497 kepala keluarga atau sekitar 49,65% dan dikategorikan sebagai prioritas ketiga, cluster 2 berisi 381 kepala keluarga atau sekitar 38,06% dan dikategorikan sebagai prioritas kedua, sedangkan cluster 3 berisi 123 kepala keluarga atau sekitar 12,28% dan dikategorikan sebagai prioritas pertama. Hasil perhitungan manual dan SPSS menunjukkan jumlah anggota yang sama pada setiap cluster. Ketika dibandingkan dengan data penerima PKH yang tercatat di kelurahan, terdapat 95 warga penerima bantuan yang seluruhnya termasuk dalam 123 warga yang direkomendasikan oleh peneliti, sehingga ditemukan 28 warga tambahan yang dinilai perlu dipertimbangkan sebagai penerima bantuan berdasarkan hasil pengelompokan. Penelitian ini menyimpulkan bahwa metode K-Means Clustering dapat digunakan untuk mengelompokkan masyarakat berdasarkan tingkat prioritas kebutuhan bantuan dan membantu pihak terkait dalam mengambil keputusan mengenai calon penerima PKH secara lebih terstruktur. Namun, hasil pengelompokan tersebut tetap dapat 

18 

dijadikan bahan pertimbangan yang perlu ditindaklanjuti melalui validasi data dan pemeriksaan kondisi masyarakat secara langsung (Sari Ufriani & Arviita, 2023). 

5. (Bahtiar et al., 2023) Penelitian yang dilakukan oleh Deni Bahtiar (2023) berjudul “Pemetaan Penduduk Penerima Bantuan Sosial Desa Waru Jaya Menggunakan Algoritma K-Means Clustering” bertujuan untuk membantu pemerintah desa dalam menentukan calon penerima bantuan sosial agar lebih tepat sasaran. Penelitian ini dilatarbelakangi oleh permasalahan penyaluran bantuan sosial yang belum merata serta adanya data penduduk yang belum diolah secara optimal. Metode yang digunakan adalah data mining dengan algoritma K-Means Clustering yang diimplementasikan menggunakan perangkat lunak RapidMiner Studio versi 9.10. Data penelitian berjumlah 823 data penduduk dengan tiga atribut yang dikelompokkan menjadi tiga cluster berdasarkan kedekatan data terhadap titik pusat kelompok (centroid). Hasil pengelompokan menunjukkan bahwa cluster 0 terdiri atas 104 anggota, cluster 1 terdiri atas 1 anggota, dan cluster 

2 terdiri atas 718 anggota. Pengujian menggunakan Davies-Bouldin Index (DBI) menghasilkan nilai sebesar 0,300, yang menunjukkan kualitas pengelompokan cukup baik karena mendekati angka nol. Penelitian ini menyimpulkan bahwa algoritma K-Means Clustering dapat digunakan untuk memetakan penduduk berdasarkan kategori kelayakan penerima bantuan sosial, yaitu layak, kurang layak, dan tidak layak menerima bantuan. Dengan demikian, metode ini diharapkan dapat membantu pemerintah Desa Waru Jaya mengolah data penduduk secara lebih 

19 

terstruktur dan mendukung penyaluran bantuan sosial yang lebih efektif dan tepat sasaran (Bahtiar et al., 2023). 

# **2.2 Teori Umum** 

Teori umum memuat berbagai konsep dan dasar teori yang digunakan sebagai acuan dalam pelaksanaan penelitian. Sumber teori ini diperoleh dari buku literatur, jurnal ilmiah, serta referensi daring _(internet)_ yang relavan dengan topik penelitian. Teori umum berfungsi sebagai landasan konseptual untuk memperkuat analisis, perancangan, dan pelaksanaan penelitian, sehingga hasil yang diperoleh memiliki dasar ilmiah yang kuat dan dapat dipertanggungjawabkan. 

# **2.2.1 Implementasi** 

Implementasi berasal dari bahasa Inggris yaitu to implement yang berarti mengimplementasikan. Implementasi merupakan penyediaan sarana untuk melaksanakan sesuatu yang menimbulkan dampak atau akibat terhadap sesuatu. Sesuatu tersebut dilakukan untuk menimbulkan dampak atau akibat itu dapat berupa undang-undang, peraturan pemerintah, keputusan peradilan dan kebijakan yang dibuat oleh lembaga-lembaga pemerintah dalam kehidupan kenegaraan.Pendapat Cleaves yang dikutip (dalam Wahab 2012;187), yang secara tegas menyebutkan bahwa: Implementasi itu mencakup “Proses bergerak menuju tujuan kebijakan dengan cara Langkah administratif dan politik”. Keberhasilan atau kegagalan implementasi sebagai demikian dapat dievaluasi dari sudut kemampuannya secara nyata dalam meneruskan atau mengoperasionalkan program-program yang telah dirancang sebelumya. Menurut Mazmanian dan Sebastiar (dalamWahab, 2012: 68) Implementasi adalah pelaksanaan keputusan kebijakan dasar, biasanya dalam bentuk undang-undang, namun dapat pula 

20 

berbentuk perintah-perintah atau keputusan-keputusan eksekutif yang penting atau keputusan badan peradilan.Menurut Van Meter dan Van Horn (dalam Wahab, 2012: 65) Implementasi adalah tindakan-tindakan yang dilakukan baik oleh individu-Individu atau pejabat-pejabat atau kelompok-kelompok pemerintah atau swasta yang diarahkan pada tercapainya tujuan-tujuan yang telah digariskan dalam keputusan kebijakan. Sebaliknya keseluruhan proses implementasi program dapat dievaluasi dengan cara mengukur atau membandingkan antara hasil akhir dari program-program tersebut dengan tujuan-tujuan kebijakan. Menurut Friedrich (dalam Wahab 2012: 3) Kebijakan adalah suatu tindakan yang mengarah pada tujuan yang diusulkan oleh seseorang, kelompok atau pemerintah dalam lingkungan tertentu sehubungan dengan adanya hambatan-hambatan tertentu seraya mencari peluang-peluang untuk mencapai tujuan atau mewujudkan sasaran yang diinginkan.Secara sederhana implementasi bisa diartikan pelaksanaan atau penerapan (Raudah & Amaliya, 2023). 

# **2.2.4 Website** 

Website adalah kumpulan halaman-halaman yang digunakan untuk menampilkan informasi dalam bentuk teks, gambar diam atau bergerak, animasi, suara, atau kombinasi dari semuanya. Halaman-halaman ini dapat memiliki sifat statis atau dinamis dan saling terhubung membentuk satu kesatuan yang terkait, dengan koneksi antar halaman melalui jaringan (CAHTRA, 2024). 

# **2.2.5 K-Means** 

Metode K-Means merupakan metode untuk menganalisis data yang dalam proses pemodelannya mengelompokkan suatu data berdasarkan titik pusat cluster 

21 

(centroid) yang dekat dengan data (Hakim et al., 2024). Langkah-langkah melakukan clustering menggunakan metode K- Means adalah sebagai berikut : 

1. Pilih jumlah cluster k sebanyak cluster yang di inginkan. 

2. Lakukan inisialisasi k pusat cluster (centroid) inisialisasi dapat dilakukan dengan berbagai cara, tetapi yang paling sering dilakukan adalah dengan memilih secara acak (random). 

3. Mengalokasikan seluruh data atau objek ke cluster terdekat. Kedekatan dua objek ditentukan berdasarkan jarak antar objek tersebut. Demikian juga kedekatan suatu data dengan pusat cluster (centroid). Langkah ini perlu dihitung jarak pada tiap data ke tiap pusat cluster (centroid). Jarak antara satu data dengan satu cluster tertentu akan menentukan data tersebut akan masuk dalam cluster yang mana. (centroid) dapat dengan menggunakan rumus Euclidean distance : 



<!-- Start of picture text -->
d(x;,X;) = | 3 (Xi — x;1)?<br>l=1<br><!-- End of picture text -->

𝑑(𝑥𝑖, 𝑥𝑗) 

- = Jarak antara objek ke 𝑖 dengan objek ke 𝑗 

𝑥𝑖𝑙 = 𝑁ilai objek 𝑘𝑒 − 𝑖 pada variabel 𝑘 

𝑥𝑗𝑙 = 𝑁ilai objek 𝑘𝑒 − 𝑗 pada variabel 𝑘 

n= Banyaknya  variabel 

4. Mengelompokkan objek berdasarkan jarak terdekat dengan centroid. 

22 

5. Menentukan centroid baru dengan menggunakan rumus: 



<!-- Start of picture text -->
Cn(q) = a1 bind)cn<br><!-- End of picture text -->

Dimana : 

𝐶𝑚(𝑞) = cluster pada objek ke- m 

m = jumlah data dalam sebuah kelompok 

𝑥𝑖 = nilai dari objek ke- i 

6. Ulangi langkah ke 3 dan ke 4 hingga tidak ada lagi objek yang berpindah cluster. 

# **2.2.6 Clustring** 

Clustering adalah salah satu sub bab dari data mining dan merupakan proses di mana sampel yang sama dibagi menjadi kelompok-kelompok yang disebut cluster. Setiap cluster termasuk sampel di mana anggota yang mirip satu sama lain dan berbeda dengan sampel yang tersedia dari kelompok lain. Analisa cluster merupakan Teknik multivariat yang mempunyai tujuan utama untuk mengelompokkan objek-objek berdasarkan karakteristik yang dimiliki. Analisis cluster mengklasifikasikan objek sehingga setiap objek yang paling dekat kesamaannya dengan objek lain berada dalam cluster yang sama (Sebagai et al., 2022). 

23 

# **2.3 Teori Perancangan Basis Data** 

# **2.3.1 Basis Data** 

Basis data terdiri dari dua panggalan kata yaitu “basis” dan “data”. Basis data adalah Gudang / markas / tempat berkumpul / bersarang. Dan data adalah representasi fakta dunia nyata yang mewakili suatu objek (orang, benda, peristiwa, dll) yang disimpan dalam bentuk teks, angka, gambar, suara, symbol, dan kombinasinya. 

Basis data adalah kumpulan data yang saling berhubungan secara logis dan di desain untuk mendapatkan data yang dibutuhkan oleh suatu organisasi yang tersimpan di hardware komputer dan menggunakan software untuk memproses data (diperbarui, dicari, diproses, melalui perhitungan-perhitungan tertentu, dan dihapus) dengan tujuan tertentu. 

<mark>Data adalah fakta-fakta yang menggambarkan  peristiwa  aktual  pada waktu tertentu. Data diperoleh dari peristiwa yang benar-benar terjadi, misalnya dari transaksi jual beli dan sebagainya.  Data identik  dengan  bukti transaksi yang terjadi di suatu perusahaan seperti kwitansi, invoice, formulir dan lain-lain. Data diolah kemudian dapat menghasilkan informasi berupa laporan, seperti laporan keuangan, laporan penjualan, dan sebagainya</mark> (Fatkhur Roji, 2023). 

# **2.3.2 Entity Relationship Diagram (ERD)** 

(M.Kom et al., 2022 ERD (Entity Relationship Diagram) adalah penggambaran objek yang menyatakan atau menggambarkan hubungan suatu model. Didalam hubungan ini tersebut dinyatakan yang utama dari ERD adalah menunjukan objek data (entity) dan hubungan (relationship) yang ada pada entity 

24 

yang ada dalam suatu proses. Kardinalisasi adalah penentu antar diagram yang menentukan banyaknya proses yang akan terjadi pada sebuah atribut. Kardinalisasi dapat berupa satu ke satu (one to one), satu ke banyak (one to many), dan juga banyak ke banyak (many to many) (Apriyanto et al, 2022). 

# **2.3.3 Logic Record Structure (LRS)** 

LRS (Logical Record Structure) terbentuk dari angka dari tipe record. Beberapa tipe record digambarkan dengan kotak persegi Panjang dan dengan nama yang unik. Beda LRS dengan ERD adalah tipe record berada diluar kotak field tipe record yang ditempatkan (Apriyanto et al., 2022). 

# **2.3 Aplikasi Pendukung** 

Aplikasi pendukung adalah aplikasi yang dipakai untuk mendukung proses dari studi kasus yang sedang dibuat dan dijalankan, dan ini beberapa aplikasi yang di pakai. 

# **2.3.1 Visual Studio Code (VS Code)** 

Visual Studio Code adalah perangkat lunak penyunting kode sumber buatan Microsoft untuk Linux, Windows. Visual Studio Code menyediakan fitur seperti penyorotan sintaksis, penyelesaian kode, kutipan kode, merefaktor kode, pengawakutuan, dan Git (CAHTRA, 2024). 

# **2.3.2 HyperText Markup Language (HTML)** 

HyperText Markup Language (HTML) adalah Bahasa dasar Web Scripting yang bersifat client-side dan digunakan untuk menampilkan informasi dalam bentuk teks, gambar, maupun elemen multimedia serta menghubungkan antar halaman web page. Namun, tanpa memahami konsep dan dasar-dasarnya hasil pembuatan halaman web biasanya tidak optimal. Meskipun banyak software yang 

25 

menawarkan kemudahan dalam merancang tampilan web, pada kenyataannya pengembang sering tetap perlu melakukan penyuntingan manual, terutama Ketika berhadapan dengan struktur web yang kompleks (Wibowo, 2026). 

# **2.3.3 Cascading Style Sheets (CSS)** 

(Wibowo, 2026). Cascading Style Sheets atau CSS merupakan bahasa pemrograman yang digunakan untuk mengatur tampilan dan tata letak halaman web. CSS berfungsi memisahkan aspek visual dari struktur HTML, sehingga pengembang dapat mengatur warna, ukuran huruf, jarak antar elemen, tata letak halaman, hingga desain responsif dengan lebih fleksibel dan efisien. CSS memungkinkan tampilan halaman web menjadi lebih konsisten dan mudah dikelola, karena perubahan gaya dapat dilakukan secara terpusat melalui satu berkas stylesheet yang langsung memengaruhi seluruh elemen yang terhubung. 

Dalam sistem informasi penjualan berbasis web, CSS memiliki peranan penting dalam menciptakan antarmuka yang nyaman dipakai dan mudah dipahami oleh pengguna. Tampilan seperti halaman daftar produk, tombol transaksi, formulir input penjualan, serta layout laporan dapat diatur dengan CSS agar lebih rapi, menarik, dan responsif ketika diakses melalui berbagai perangkat. Dengan pengaturan visual yang baik, pengalaman pengguna (user experience) meningkat, sehingga pengelola maupun pelanggan dapat menggunakan sistem secara lebih efektif dan efisien (Wibowo, 2026). 

# **2.3.4 Hypertext Preprocessor (PHP)** 

(CAHTRA, 2024). Hypertext Preprocessor (PHP) adalah sebuah Bahasa pemrograman yang secara luas digunakan dalam pengembangan dan pembuatan 

26 

situs web, dan dapat digunakan dalam kombinasi dengan Hypertext Markup Language (HTML). PHP merupakan kependekan dari Hypertext Preprocessor, dan merupakan bahasa yang terintegrasi dalam dokumen Hypertext Markup Language (HTML), serta bekerja di sisi server (server-side HTML-embedded scripting). Ini berarti sintaks dan perintah yang diberikan akan dieksekusi sepenuhnya di server, tetapi disertakan dalam halaman Hypertext Markup Language (HTML) biasa sehingga tidak terlihat oleh klien. Hypertext Preprocessor (PHP) dirancang untuk berinteraksi dengan server basis data, sehingga memudahkan pembuatan dokumen Hypertext Markup Language (HTML) yang dapat mengakses basis data. Tujuan dari bahasa scripting ini adalah untuk membuat aplikasi di mana aplikasi tersebut, yang dibangun menggunakan PHP, umumnya memberikan hasil pada peramban web, tetapi prosesnya secara keseluruhan dijalankan di server (Cahtra, 2024). 

# **2.3.5** **_XAMPP_** 

XAMPP adalah aplikasi yang bertindak sebagai server independen (localhost) dan terdiri dari beberapa program seperti server HTTP Apache, database MYSQL, dan penerjemah bahasa yang ditulis dalam Bahasa pemrograman PHP dan Perl. XAMPP sendiri merupakan singkatan dari sistem operasi X-Four yang meliputi Apache, MYSQL, PHP, dan Perl. Program ini, dilisensikan di bawah Lisensi Publik Umum, adalah server web yang mudah digunakan untuk menampilkan halaman web dinamis  (Cahtra, 2024). 

# **BAB III** 

# **ANALISA DAN PERANCANGAN SISTEM** 

# **3.1 Analisa Sistem** 

Analisa sistem dilakukan untuk memahami kondisi pengelolaan data warga di RT 03, mengidentifikasi masalah yang muncul, serta menentukan kebutuhan sistem aplikasi yang dapat memberikan solusi terhadap permasalahan tersebut. Analisis ini dilakukan berdasarkan hasil observasi, wawancara dengan pengurus RT, dan telah dokumen yang digunakan dalam proses administrasi warga. 

Saat ini, proses pengelolaan data warga masih dilakukan secara manual, yaitu melalui pencatatan menggunakan buku catatan, arsip fisik, atau file _Excel_ sederhana. Cara ini memiliki beberapa kelemahan, seperti data tidak terpusat, rentan hilang, sulit diperbarui, dan membutuhkan waktu lama ketika pengurus ingin mencari informasi tertentu. Kekurangan tersebut berdampak pada lambatnya pelayanan administrasi seperti pembuatan surat keterangan domisili, pendataan bantuan sosial, serta rekapitulasi warga. 

Selain itu, data warga yang sudah dikumpulkan belum dimanfaatkan secara optimal sebagai dasar pengambilan keputusan. Informasi seperti kondisi ekonomi, jumlah tanggungan, atau status pekerjaan tidak pernah dianalisis lebih lanjut untuk melakukan pengelompokan warga berdasarkan kategori tertentu. Hal ini menyebabkan pengurus kesulitan untuk menentukan warga prioritas bantuan atau segmentasi program sosial. 

22 

23 

Melihat berbagai permasalahan tersebut, diperlukan sebuah sistem aplikasi berbasis website yang mampu menyimpan data secara _terstruktur_ , mudah diperbarui, serta memiliki fitur analisis berbasis algoritma _K-Means Clustering_ . Dengan demikian, data warga tidak hanya berfungsi sebagai arsip tetapi juga menjadi sumber informasi pendukung keputusan bagi pengurus RT 03. 

# **3.2 Analisa Sistem Berjalan** 

Sistem yang sedang berjalan menunjukkan bahwa administrasi data warga di RT 03 masih dikelola melalui mekanisme manual yang melibatkan dua pihak utama, yaitu Ketua RT dan Bendahara. Tahapan awal proses tersebut berawal dari penyampaian informasi oleh warga kepada Ketua RT, baik ketika terdapat data baru maupun perubahan pada data yang telah tersedia. Selanjutnya, informasi tersebut didokumentasikan dalam buku administrasi atau berkas Excel sederhana, kemudian disimpan secara fisik di dalam lemari arsip. Proses penyusunan laporan yang dilakukan secara manual diperkirakan memerlukan waktu sekitar dua sampai empat jam; kondisi ini menyebabkan proses administrasi menjadi kurang efisien serta memiliki potensi kesalahan yang cukup tinggi 

Selanjutnya, data yang telah diterima dari Ketua RT dicatat kembali oleh Bendahara dalam buku yang terpisah. Praktik pencatatan ganda tersebut berpotensi menimbulkan duplikasi informasi serta ketidakkonsistenan antardata. Selain itu, pengelompokan warga masih dilakukan secara manual dengan mengandalkan penilaian subjektif dan belum didukung oleh analisis terkomputerisasi. Akibatnya, sistem yang berjalan belum terintegrasi, memerlukan waktu yang relatif lama, serta belum mampu mendukung pengambilan keputusan berbasis data. 

24 



<!-- Start of picture text -->
Warga Melaporkan:<br>data baru/perubahan<br>Mencatat data ke<br>buku / excel<br>Menyimpan data ke<br>lemari arsip<br>Membuat laporan<br>manual (2-4 jam)<br>Menerima salinan:<br>data dari ketua RT<br>Mencatat data di<br>buku terpisah<br>Menentukan<br>pengelompokan<br>secara manual<br>Menyimpan data di<br>lemari arsip_<br>Selesai<br><!-- End of picture text -->

_Gambar 1. Diagram Sistem Berjalan_ 

25 

# **3.3 Analisa Sistem usulan** 

sistem usulan menggambarkan proses pengelolaan data warga yang telah dikembangkan menggunakan sistem aplikasi berbasis website dan terintegrasi dengan algoritma _K-Means Clustering_ . Proses dimulai ketika pengguna, dalam hal ini Ketua RT, mengakses sistem aplikasi melalui _website_ dan melakukan login. Sistem kemudian melakukan validasi terhadap data _login_ yang dimasukkan. Apabila _login_ tidak valid, pengguna akan diminta untuk mengulangi proses login, sedangkan jika _login_ berhasil, pengguna dapat melanjutkan ke menu utama sistem. 

Setelah berhasil masuk, Ketua RT memilih menu data warga untuk melakukan pengelolaan data, seperti menambah, mengubah, atau menghapus data warga. Data yang telah diinput atau diperbarui akan disimpan secara otomatis ke dalam database sistem. Selanjutnya, sistem menjalankan algoritma _K-Means Clustering_ untuk mengelompokkan data warga ke dalam beberapa _cluster_ berdasarkan atribut yang telah ditentukan, seperti usia dan status ekonomi. Hasil pengelompokan ini kemudian digunakan oleh sistem untuk menghasilkan laporan secara otomatis. Ketua RT juga dapat mencetak hasil data dan laporan dalam bentuk file PDF sebagai bahan dokumentasi atau pelaporan resmi. 

Dalam sistem usulan ini, Bendahara juga memiliki akses tersendiri dengan menggunakan akun bendahara untuk _login_ ke sistem. Bendahara dapat mengakses data warga yang telah tersimpan, melakukan pembaruan data yang berkaitan dengan administrasi keuangan, serta menyusun laporan data yang dibutuhkan. Setelah laporan selesai dibuat, Bendahara melakukan koordinasi dengan Ketua RT sebagai bentuk sinkronisasi data dan informasi. Proses kemudian berakhir ketika 

26 

seluruh data tersimpan dengan baik dan laporan berhasil dihasilkan. Alur sistem usulan ini menunjukkan bahwa proses pengelolaan data menjadi lebih terintegrasi, efisien, cepat, serta mampu mendukung pengambilan keputusan berbasis data melalui penerapan algoritma _K-Means Clustering_ . 

27 



_Gambar 2.Diagram Sistem Usulan_ 

