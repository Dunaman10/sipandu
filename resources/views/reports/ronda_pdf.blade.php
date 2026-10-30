<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Jadwal Petugas Ronda Malam RT 03</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
            color: #222;
            margin: 0;
            padding: 10px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
            margin-bottom: 12px;
        }
        .header h2 {
            margin: 0;
            font-size: 13px;
            text-transform: uppercase;
        }
        .header h1 {
            margin: 2px 0;
            font-size: 15px;
            text-transform: uppercase;
        }
        .header p {
            margin: 0;
            font-size: 9px;
            color: #555;
        }
        .title {
            text-align: center;
            margin-bottom: 14px;
        }
        .title h3 {
            margin: 0;
            font-size: 13px;
            text-transform: uppercase;
            text-decoration: underline;
        }
        .title p {
            margin: 3px 0 0;
            font-size: 9.5px;
            color: #444;
        }
        .announcement-box {
            background-color: #f8fafc;
            border: 1px dashed #64748b;
            padding: 8px 12px;
            margin-bottom: 15px;
            font-size: 9.5px;
            line-height: 1.4;
        }
        .announcement-box strong {
            color: #0f172a;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
        }
        th, td {
            border: 1px solid #666;
            padding: 5px 6px;
            text-align: left;
        }
        th {
            background-color: #f1f5f9;
            font-weight: bold;
            font-size: 9px;
            text-transform: uppercase;
        }
        .schedule-card {
            margin-bottom: 14px;
            page-break-inside: avoid;
        }
        .card-header {
            background-color: #0f172a;
            color: #ffffff;
            padding: 5px 8px;
            font-weight: bold;
            font-size: 10px;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .signatures {
            margin-top: 25px;
            width: 100%;
            page-break-inside: avoid;
        }
        .signatures td {
            border: none;
            padding: 0;
            text-align: center;
            font-size: 9.5px;
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
        <h3>Jadwal Petugas Ronda Malam Lingkungan RT 03</h3>
        <p>Pengumuman Resmi Keamanan Lingkungan &bull; Pos Kamling RT 03</p>
    </div>

    <div class="announcement-box">
        <strong>Pemberitahuan Warga:</strong> Jadwal ini diterbitkan resmi untuk diumumkan pada papan mading RT dan dibagikan melalui grup WhatsApp warga. Mohon kepada warga yang bertugas untuk hadir tepat waktu demi ketertiban serta keamanan lingkungan bersama. Apabila berhalangan, diharapkan saling berkoordinasi dengan sesama warga regu piket.
    </div>

    @forelse($schedules as $sched)
    <div class="schedule-card">
        <div class="card-header">
            HARI &amp; TANGGAL: {{ strtoupper($sched->tanggal_ronda->isoFormat('dddd, D MMMM Y')) }} &bull; SHIFT: {{ strtoupper($sched->shift_ronda) }}
        </div>

        @if($sched->keterangan_khusus)
        <div style="background-color: #fef3c7; color: #92400e; padding: 4px 8px; font-size: 9px; border: 1px solid #fde68a; border-top: none;">
            <strong>Catatan / Pesan:</strong> {{ $sched->keterangan_khusus }}
        </div>
        @endif

        <table>
            <thead>
                <tr>
                    <th class="text-center" style="width: 30px;">No</th>
                    <th>Nama Petugas Ronda</th>
                    <th>Alamat Blok / Rumah</th>
                    <th style="width: 150px; text-align: center;">Tanda Tangan Petugas</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sched->participants as $p)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td><strong>{{ $p->warga->nama_lengkap }}</strong></td>
                    <td>{{ $p->warga->alamat_blok }}</td>
                    <td style="height: 22px;"></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @empty
    <p style="text-align: center; color: #888; padding: 20px;">Belum ada jadwal ronda yang dibuat.</p>
    @endforelse

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
                <strong>Koordinator Pos Kamling</strong>
                <br><br><br><br>
                <u><strong>Lukman Hakim</strong></u>
            </td>
        </tr>
    </table>
</body>
</html>
