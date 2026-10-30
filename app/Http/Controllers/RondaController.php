<?php

namespace App\Http\Controllers;

use App\Models\RondaParticipant;
use App\Models\RondaSchedule;
use App\Models\Warga;
use App\Services\SimpleXlsxExporter;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class RondaController extends Controller
{
    public function index(Request $request)
    {
        $query = RondaSchedule::with(['participants.warga', 'createdBy']);

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_ronda', [$request->input('start_date'), $request->input('end_date')]);
        }

        $schedules = $query->orderBy('tanggal_ronda', 'desc')->paginate(10);
        $wargas = Warga::orderBy('nama_lengkap', 'asc')->get();

        return view('ronda.index', compact('schedules', 'wargas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal_ronda' => ['required', 'date'],
            'shift_ronda' => ['required', 'string', 'max:50'],
            'keterangan_khusus' => ['nullable', 'string'],
            'warga_ids' => ['required', 'array', 'min:1'],
            'warga_ids.*' => ['exists:wargas,id'],
        ]);

        $schedule = RondaSchedule::create([
            'tanggal_ronda' => $validated['tanggal_ronda'],
            'shift_ronda' => $validated['shift_ronda'],
            'keterangan_khusus' => $validated['keterangan_khusus'] ?? null,
            'created_by' => auth()->id(),
        ]);

        foreach ($validated['warga_ids'] as $wargaId) {
            RondaParticipant::create([
                'ronda_schedule_id' => $schedule->id,
                'warga_id' => $wargaId,
            ]);
        }

        return redirect()->route('ronda.index')->with('success', 'Jadwal ronda malam warga RT 03 berhasil dibuat dan siap dicetak/dibagikan.');
    }

    public function generateOtomatis(Request $request)
    {
        $validated = $request->validate([
            'tanggal_mulai' => ['required', 'date'],
            'jumlah_hari' => ['required', 'integer', 'min:1', 'max:30'],
            'petugas_per_malam' => ['required', 'integer', 'min:2', 'max:10'],
            'shift_ronda' => ['required', 'string', 'max:50'],
        ]);

        // Prioritaskan warga laki-laki dewasa
        $eligibleWargas = Warga::where('jenis_kelamin', 'L')->get();
        if ($eligibleWargas->count() < $validated['petugas_per_malam']) {
            $eligibleWargas = Warga::all();
        }

        if ($eligibleWargas->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data warga yang dapat dijadwalkan.');
        }

        // Acak / rotasi warga
        $shuffled = $eligibleWargas->shuffle()->values();
        $totalWarga = $shuffled->count();
        $wargaIndex = 0;

        $startDate = \Carbon\Carbon::parse($validated['tanggal_mulai']);
        $totalCreated = 0;

        for ($i = 0; $i < $validated['jumlah_hari']; $i++) {
            $targetDate = $startDate->copy()->addDays($i)->toDateString();

            // Cek jika sudah ada jadwal di tanggal ini
            $schedule = RondaSchedule::firstOrCreate(
                ['tanggal_ronda' => $targetDate],
                [
                    'shift_ronda' => $validated['shift_ronda'],
                    'keterangan_khusus' => 'Jadwal Ronda Bergilir RT 03',
                    'created_by' => auth()->id(),
                ]
            );

            // Ambil petugas sejumlah petugas_per_malam secara bergilir
            for ($k = 0; $k < $validated['petugas_per_malam']; $k++) {
                $warga = $shuffled[$wargaIndex % $totalWarga];
                $wargaIndex++;

                RondaParticipant::firstOrCreate([
                    'ronda_schedule_id' => $schedule->id,
                    'warga_id' => $warga->id,
                ]);
            }

            $totalCreated++;
        }

        return redirect()->route('ronda.index')->with('success', "Berhasil men-generate {$totalCreated} jadwal ronda bergilir otomatis.");
    }

    public function destroy(RondaSchedule $ronda)
    {
        $ronda->delete();
        return redirect()->route('ronda.index')->with('success', 'Jadwal ronda malam berhasil dihapus.');
    }

    public function exportPdf(Request $request)
    {
        $query = RondaSchedule::with(['participants.warga', 'createdBy']);

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_ronda', [$request->input('start_date'), $request->input('end_date')]);
        }

        $schedules = $query->orderBy('tanggal_ronda', 'asc')
            ->take(30)
            ->get();

        $pdf = Pdf::loadView('reports.ronda_pdf', compact('schedules'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('Jadwal_Ronda_RT03_' . date('Ymd_His') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $query = RondaSchedule::with(['participants.warga', 'createdBy']);

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_ronda', [$request->input('start_date'), $request->input('end_date')]);
        }

        $schedules = $query->orderBy('tanggal_ronda', 'asc')
            ->take(30)
            ->get();

        $headers = [
            'No',
            'Tanggal Ronda',
            'Hari',
            'Shift',
            'Nama Petugas Ronda',
            'Alamat Blok / Rumah',
            'Keterangan / Instruksi Khusus',
        ];

        $rows = [];
        $no = 1;
        foreach ($schedules as $sched) {
            foreach ($sched->participants as $p) {
                $rows[] = [
                    $no++,
                    $sched->tanggal_ronda ? $sched->tanggal_ronda->format('d/m/Y') : '-',
                    $sched->tanggal_ronda ? $sched->tanggal_ronda->isoFormat('dddd') : '-',
                    $sched->shift_ronda,
                    $p->warga->nama_lengkap,
                    $p->warga->alamat_blok,
                    $sched->keterangan_khusus ?? '-',
                ];
            }
        }

        $filename = 'Jadwal_Ronda_RT03_' . date('Ymd_His') . '.xlsx';

        return SimpleXlsxExporter::download($filename, 'Jadwal Ronda', $headers, $rows);
    }
}
