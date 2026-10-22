<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Hasil K-Means Clustering RT 03</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
            color: #333;
            margin: 0;
            padding: 10px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }
        .header h2 {
            margin: 0;
            font-size: 14px;
            text-transform: uppercase;
        }
        .header h1 {
            margin: 2px 0;
            font-size: 16px;
            text-transform: uppercase;
        }
        .header p {
            margin: 0;
            font-size: 9px;
            color: #555;
        }
        .title {
            text-align: center;
            margin-bottom: 12px;
        }
        .title h3 {
            margin: 0;
            font-size: 12px;
            text-transform: uppercase;
            text-decoration: underline;
        }
        .summary-box {
            margin-bottom: 15px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
            padding: 8px;
            font-size: 9.5px;
            line-height: 1.4;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #777;
            padding: 5px 6px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            font-size: 9px;
            text-transform: uppercase;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .signatures {
            margin-top: 30px;
            width: 100%;
        }
        .signatures td {
            border: none;
            padding: 0;
            text-align: center;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>RUKUN TETANGGA 03 / RUKUN WARGA 02</h2>
        <h1>KELURAHAN KEDAUNG, KECAMATAN PAMULANG</h1>
        <p>Sekretariat: Pos Warga RT 03/02, Kedaung, Kec. Pamulang, Kota Tangerang Selatan, Banten 15415</p>
    </div>

    <div class="title">
        <h3>Laporan Hasil Analisis K-Means Clustering Kependudukan</h3>
        <p>Kode Sesi: <strong>{{ $session->kode_sesi }}</strong> &bull; Waktu Eksekusi: {{ $session->tanggal_proses->isoFormat('D MMMM Y, HH:mm') }} WIB</p>
    </div>

    <div class="summary-box">
        <strong>Ringkasan Hasil Algoritma:</strong><br>
        Total Warga Terklasterisasi: <strong>{{ $session->total_data_warga }} Jiwa</strong> &bull;
        Jumlah Klaster: <strong>K=3</strong> &bull;
        Total Iterasi Konvergen: <strong>{{ $session->total_iterasi }} Langkah</strong><br>
        &bull; <strong>Cluster 1 (Prioritas Bantuan Utama):</strong> {{ $cluster1Count }} Warga (Penerima PKH, BLT, Sembako)<br>
        &bull; <strong>Cluster 2 (Prioritas Bantuan Pendukung):</strong> {{ $cluster2Count }} Warga (Subsidi Pasar Murah & Padat Karya RT)<br>
        &bull; <strong>Cluster 3 (Mandiri / Mampu):</strong> {{ $cluster3Count }} Warga (Warga Mandiri & Calon Donatur)
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center" style="width: 20px;">No</th>
                <th>Nama Warga</th>
                <th>NIK</th>
                <th>Alamat Blok</th>
                <th class="text-center">Jarak C1</th>
                <th class="text-center">Jarak C2</th>
                <th class="text-center">Jarak C3</th>
                <th class="text-center">Cluster</th>
                <th>Rekomendasi Kebijakan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($session->results as $res)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td><strong>{{ $res->warga->nama_lengkap }}</strong></td>
                <td>{{ $res->warga->nik }}</td>
                <td>{{ $res->warga->alamat_blok }}</td>
                <td class="text-center">{{ $res->jarak_c1 }}</td>
                <td class="text-center">{{ $res->jarak_c2 }}</td>
                <td class="text-center">{{ $res->jarak_c3 }}</td>
                <td class="text-center" style="font-weight: bold;">
                    @if($res->cluster_terpilih === 'cluster_1') C1 (Utama)
                    @elseif($res->cluster_terpilih === 'cluster_2') C2 (Sedang)
                    @else C3 (Mandiri) @endif
                </td>
                <td>{{ $res->rekomendasi_kebijakan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="signatures">
        <tr>
            <td style="width: 50%;">
                <br>
                Mengetahui,<br>
                <strong>Ketua RT 03 Kelurahan Kedaung</strong>
                <br><br><br><br>
                <u><strong>H. Bambang Sutrisno</strong></u>
            </td>
            <td style="width: 50%;">
                Kedaung, {{ now()->isoFormat('D MMMM Y') }}<br>
                Sekretariat RT 03<br>
                <strong>Ketua Tim Analis Kependudukan</strong>
                <br><br><br><br>
                <u><strong>{{ $session->user->name }}</strong></u>
            </td>
        </tr>
    </table>
</body>
</html>
