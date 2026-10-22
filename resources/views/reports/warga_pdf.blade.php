<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Kependudukan RT 03</title>
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
        .title p {
            margin: 2px 0 0;
            font-size: 9px;
            color: #666;
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
        <h3>Laporan Master Data Kependudukan Warga RT 03</h3>
        <p>Dicetak pada: {{ now()->isoFormat('D MMMM Y, HH:mm') }} WIB</p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center" style="width: 20px;">No</th>
                <th>Nama Lengkap</th>
                <th>NIK</th>
                <th>No. KK</th>
                <th class="text-center">L/P</th>
                <th class="text-center">Usia</th>
                <th>Alamat Blok</th>
                <th>Pekerjaan</th>
                <th>Penghasilan</th>
                <th class="text-center">Tgg</th>
                <th class="text-center">KTP</th>
                <th class="text-center">Iuran</th>
            </tr>
        </thead>
        <tbody>
            @foreach($wargas as $w)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td><strong>{{ $w->nama_lengkap }}</strong></td>
                <td>{{ $w->nik }}</td>
                <td>{{ $w->no_kk }}</td>
                <td class="text-center">{{ $w->jenis_kelamin }}</td>
                <td class="text-center">{{ $w->usia }} th</td>
                <td>{{ $w->alamat_blok }}</td>
                <td>{{ $w->pekerjaan }}</td>
                <td class="text-right">{{ $w->formatted_penghasilan }}</td>
                <td class="text-center">{{ $w->jumlah_tanggungan }}</td>
                <td class="text-center">{{ ucfirst($w->status_ktp) }}</td>
                <td class="text-center">{{ ucfirst($w->status_iuran) }}</td>
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
                <strong>Petugas Administrasi</strong>
                <br><br><br><br>
                <u><strong>{{ auth()->user()->name }}</strong></u>
            </td>
        </tr>
    </table>
</body>
</html>
