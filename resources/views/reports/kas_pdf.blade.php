<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan Kas RT 03</title>
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
            font-size: 10px;
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
        <h3>Laporan Rekapitulasi Iuran Kas Warga RT 03</h3>
        <p>Periode: <strong>{{ $selectedPeriode === 'all' ? 'Seluruh Periode' : $selectedPeriode }}</strong> &bull; Dicetak: {{ now()->isoFormat('D MMMM Y, HH:mm') }} WIB</p>
    </div>

    <div class="summary-box">
        <strong>Ringkasan Keuangan Kas:</strong><br>
        Total Pemasukan Kas (Lunas): <strong>Rp {{ number_format($totalLunas, 0, ',', '.') }}</strong> &bull;
        Total Tunggakan: <strong>Rp {{ number_format($totalBelumLunas, 0, ',', '.') }}</strong>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center" style="width: 20px;">No</th>
                <th>Nama Warga</th>
                <th>Alamat Blok</th>
                <th class="text-center">Periode</th>
                <th class="text-right">Nominal</th>
                <th class="text-center">Status</th>
                <th class="text-center">Tanggal Bayar</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kasList as $k)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td><strong>{{ $k->warga->nama_lengkap }}</strong></td>
                <td>{{ $k->warga->alamat_blok }}</td>
                <td class="text-center">{{ $k->periode_bulan }}</td>
                <td class="text-right">{{ $k->formatted_nominal }}</td>
                <td class="text-center" style="font-weight: bold; color: {{ $k->status_pembayaran === 'lunas' ? '#047857' : '#b91c1c' }};">
                    {{ strtoupper(str_replace('_', ' ', $k->status_pembayaran)) }}
                </td>
                <td class="text-center">{{ $k->tanggal_bayar ? $k->tanggal_bayar->format('d/m/Y') : '-' }}</td>
                <td>{{ $k->keterangan ?? '-' }}</td>
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
                Bendahara RT 03<br>
                <strong>Pengelola Keuangan Kas</strong>
                <br><br><br><br>
                <u><strong>Hj. Siti Rohmah</strong></u>
            </td>
        </tr>
    </table>
</body>
</html>
