<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Jadwal Ronda Malam RT 03</title>
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
        <h3>Jadwal & Rekap Absensi Petugas Ronda Malam RT 03</h3>
        <p>Dicetak pada: {{ now()->isoFormat('D MMMM Y, HH:mm') }} WIB</p>
    </div>

    @foreach($schedules as $sched)
    <div style="margin-bottom: 12px;">
        <table style="margin-bottom: 4px; background-color: #f7f7f7;">
            <tr>
                <td style="border: 1px solid #555; width: 60%;">
                    <strong>Tanggal:</strong> {{ $sched->tanggal_ronda->isoFormat('dddd, D MMMM Y') }} &bull;
                    <strong>Shift:</strong> {{ $sched->shift_ronda }}
                </td>
                <td style="border: 1px solid #555; width: 40%; text-align: right;">
                    <strong>Petugas Piket:</strong> {{ $sched->participants->count() }} Orang
                </td>
            </tr>
            @if($sched->keterangan_khusus)
            <tr>
                <td colspan="2" style="border: 1px solid #555; font-style: italic; color: #555;">
                    Instruksi: {{ $sched->keterangan_khusus }}
                </td>
            </tr>
            @endif
        </table>

        <table>
            <thead>
                <tr>
                    <th class="text-center" style="width: 20px;">No</th>
                    <th>Nama Petugas</th>
                    <th>Alamat Blok</th>
                    <th class="text-center" style="width: 80px;">Kehadiran</th>
                    <th>Catatan / Keterangan Pengganti</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sched->participants as $p)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td><strong>{{ $p->warga->nama_lengkap }}</strong></td>
                    <td>{{ $p->warga->alamat_blok }}</td>
                    <td class="text-center" style="font-weight: bold;
                        color: {{ $p->status_kehadiran === 'hadir' ? '#047857' : ($p->status_kehadiran === 'izin' ? '#b45309' : ($p->status_kehadiran === 'digantikan' ? '#1d4ed8' : '#b91c1c')) }};">
                        {{ strtoupper($p->status_kehadiran) }}
                    </td>
                    <td>{{ $p->catatan_keterangan ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endforeach

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
                Seksi Keamanan Lingkungan RT 03<br>
                <strong>Koordinator Pos Ronda</strong>
                <br><br><br><br>
                <u><strong>Lukman Hakim</strong></u>
            </td>
        </tr>
    </table>
</body>
</html>
