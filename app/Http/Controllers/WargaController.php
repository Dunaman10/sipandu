<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use App\Services\SimpleXlsxExporter;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WargaController extends Controller
{
    public function index(Request $request)
    {
        $query = Warga::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('no_kk', 'like', "%{$search}%")
                    ->orWhere('alamat_blok', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status_ktp')) {
            $query->where('status_ktp', $request->input('status_ktp'));
        }

        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->input('jenis_kelamin'));
        }

        if ($request->filled('kondisi_rumah')) {
            $query->where('kondisi_rumah', $request->input('kondisi_rumah'));
        }

        $wargas = $query->latest('id')->paginate(10)->withQueryString();

        return view('warga.index', compact('wargas'));
    }

    public function create()
    {
        return view('warga.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => ['required', 'string', 'size:16', 'unique:wargas,nik'],
            'no_kk' => ['required', 'string', 'size:16'],
            'nama_lengkap' => ['required', 'string', 'max:150'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'tempat_lahir' => ['nullable', 'string', 'max:100'],
            'tanggal_lahir' => ['required', 'date'],
            'alamat_blok' => ['required', 'string', 'max:255'],
            'status_ktp' => ['required', 'in:ada,belum'],
            'pekerjaan' => ['required', 'string', 'max:100'],
            'penghasilan_bulanan' => ['required', 'numeric', 'min:0'],
            'jumlah_tanggungan' => ['required', 'integer', 'min:0'],
            'status_kepemilikan_rumah' => ['required', 'in:milik_sendiri,sewa_kontrak,menumpang'],
            'kondisi_rumah' => ['required', 'in:layak_huni,kurang_layak,tidak_layak'],
            'keterangan' => ['nullable', 'string'],
        ]);

        $birthDate = Carbon::parse($validated['tanggal_lahir']);
        $validated['usia'] = $birthDate->age;

        // Hitung skor ekonomi otomatis
        $income = (float) $validated['penghasilan_bulanan'];
        if ($income <= 2000000) {
            $validated['skor_ekonomi'] = 1;
        } elseif ($income <= 4000000) {
            $validated['skor_ekonomi'] = 2;
        } elseif ($income <= 7000000) {
            $validated['skor_ekonomi'] = 3;
        } elseif ($income <= 10000000) {
            $validated['skor_ekonomi'] = 4;
        } else {
            $validated['skor_ekonomi'] = 5;
        }

        // Hitung skor kondisi rumah otomatis
        $validated['skor_kondisi_rumah'] = match ($validated['kondisi_rumah']) {
            'layak_huni' => 1,
            'kurang_layak' => 2,
            'tidak_layak' => 3,
            default => 1,
        };

        $validated['created_by'] = auth()->id();
        $validated['updated_by'] = auth()->id();

        Warga::create($validated);

        return redirect()->route('warga.index')->with('success', 'Data warga berhasil ditambahkan.');
    }

    public function show(Warga $warga)
    {
        $warga->load(['createdBy', 'updatedBy', 'rondaParticipants.schedule', 'clusteringResults.session']);
        return view('warga.show', compact('warga'));
    }

    public function edit(Warga $warga)
    {
        return view('warga.edit', compact('warga'));
    }

    public function update(Request $request, Warga $warga)
    {
        $validated = $request->validate([
            'nik' => ['required', 'string', 'size:16', 'unique:wargas,nik,' . $warga->id],
            'no_kk' => ['required', 'string', 'size:16'],
            'nama_lengkap' => ['required', 'string', 'max:150'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'tempat_lahir' => ['nullable', 'string', 'max:100'],
            'tanggal_lahir' => ['required', 'date'],
            'alamat_blok' => ['required', 'string', 'max:255'],
            'status_ktp' => ['required', 'in:ada,belum'],
            'pekerjaan' => ['required', 'string', 'max:100'],
            'penghasilan_bulanan' => ['required', 'numeric', 'min:0'],
            'jumlah_tanggungan' => ['required', 'integer', 'min:0'],
            'status_kepemilikan_rumah' => ['required', 'in:milik_sendiri,sewa_kontrak,menumpang'],
            'kondisi_rumah' => ['required', 'in:layak_huni,kurang_layak,tidak_layak'],
            'keterangan' => ['nullable', 'string'],
        ]);

        $birthDate = Carbon::parse($validated['tanggal_lahir']);
        $validated['usia'] = $birthDate->age;

        $income = (float) $validated['penghasilan_bulanan'];
        if ($income <= 2000000) {
            $validated['skor_ekonomi'] = 1;
        } elseif ($income <= 4000000) {
            $validated['skor_ekonomi'] = 2;
        } elseif ($income <= 7000000) {
            $validated['skor_ekonomi'] = 3;
        } elseif ($income <= 10000000) {
            $validated['skor_ekonomi'] = 4;
        } else {
            $validated['skor_ekonomi'] = 5;
        }

        $validated['skor_kondisi_rumah'] = match ($validated['kondisi_rumah']) {
            'layak_huni' => 1,
            'kurang_layak' => 2,
            'tidak_layak' => 3,
            default => 1,
        };

        $validated['updated_by'] = auth()->id();

        $warga->update($validated);

        return redirect()->route('warga.index')->with('success', 'Data warga berhasil diperbarui.');
    }

    public function destroy(Warga $warga)
    {
        $warga->delete();
        return redirect()->route('warga.index')->with('success', 'Data warga berhasil dihapus.');
    }

    public function exportPdf(Request $request)
    {
        $query = Warga::query();

        if ($request->filled('status_ktp')) {
            $query->where('status_ktp', $request->input('status_ktp'));
        }

        $wargas = $query->orderBy('nama_lengkap', 'asc')->get();

        $pdf = Pdf::loadView('reports.warga_pdf', compact('wargas'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan_Data_Warga_RT03_' . date('Ymd_His') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $query = Warga::query();

        if ($request->filled('status_ktp')) {
            $query->where('status_ktp', $request->input('status_ktp'));
        }

        if ($request->filled('kondisi_rumah')) {
            $query->where('kondisi_rumah', $request->input('kondisi_rumah'));
        }

        $wargas = $query->orderBy('nama_lengkap', 'asc')->get();

        $headers = [
            'No',
            'Nama Lengkap',
            'NIK',
            'No. KK',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Usia (Tahun)',
            'Alamat Blok',
            'Status KTP',
            'Pekerjaan',
            'Penghasilan Bulanan (Rp)',
            'Skor Ekonomi',
            'Jumlah Tanggungan',
            'Status Kepemilikan Rumah',
            'Kondisi Rumah',
            'Keterangan Khusus',
        ];

        $rows = [];
        foreach ($wargas as $index => $w) {
            $rows[] = [
                $index + 1,
                $w->nama_lengkap,
                (string) $w->nik,
                (string) $w->no_kk,
                $w->jenis_kelamin_label,
                $w->tempat_lahir ?? '-',
                $w->tanggal_lahir ? $w->tanggal_lahir->format('d/m/Y') : '-',
                (int) $w->usia,
                $w->alamat_blok,
                $w->status_ktp === 'ada' ? 'Ada' : 'Belum Ada',
                $w->pekerjaan,
                (float) $w->penghasilan_bulanan,
                (int) $w->skor_ekonomi,
                (int) $w->jumlah_tanggungan,
                ucwords(str_replace('_', ' ', $w->status_kepemilikan_rumah)),
                ucwords(str_replace('_', ' ', $w->kondisi_rumah)),
                $w->keterangan ?? '-',
            ];
        }

        $filename = 'Laporan_Data_Warga_RT03_' . date('Ymd_His') . '.xlsx';

        return SimpleXlsxExporter::download($filename, 'Data Warga RT03', $headers, $rows);
    }
}
