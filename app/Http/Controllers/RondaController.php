<?php

namespace App\Http\Controllers;

use App\Models\RondaParticipant;
use App\Models\RondaSchedule;
use App\Models\Warga;
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

        // Calculate active citizen stats
        $wargaActivity = Warga::withCount([
            'rondaParticipants as total_tugas',
            'rondaParticipants as total_hadir' => function ($q) {
                $q->where('status_kehadiran', 'hadir');
            },
            'rondaParticipants as total_izin' => function ($q) {
                $q->where('status_kehadiran', 'izin');
            },
            'rondaParticipants as total_alpha' => function ($q) {
                $q->where('status_kehadiran', 'alpha');
            },
            'rondaParticipants as total_digantikan' => function ($q) {
                $q->where('status_kehadiran', 'digantikan');
            },
        ])
        ->where('jenis_kelamin', 'L')
        ->orderBy('total_hadir', 'desc')
        ->take(10)
        ->get();

        return view('ronda.index', compact('schedules', 'wargas', 'wargaActivity'));
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
                'status_kehadiran' => 'hadir',
            ]);
        }

        return redirect()->route('ronda.index')->with('success', 'Jadwal ronda malam berhasil dibuat.');
    }

    public function updateAbsensi(Request $request, RondaParticipant $participant)
    {
        $validated = $request->validate([
            'status_kehadiran' => ['required', 'in:hadir,izin,alpha,digantikan'],
            'catatan_keterangan' => ['nullable', 'string'],
        ]);

        $participant->update($validated);

        return redirect()->back()->with('success', 'Status absensi ' . $participant->warga->nama_lengkap . ' berhasil diperbarui.');
    }

    public function destroy(RondaSchedule $ronda)
    {
        $ronda->delete();
        return redirect()->route('ronda.index')->with('success', 'Jadwal ronda malam berhasil dihapus.');
    }

    public function rekapitulasi(Request $request)
    {
        $wargas = Warga::withCount([
            'rondaParticipants as total_tugas',
            'rondaParticipants as total_hadir' => function ($q) {
                $q->where('status_kehadiran', 'hadir');
            },
            'rondaParticipants as total_izin' => function ($q) {
                $q->where('status_kehadiran', 'izin');
            },
            'rondaParticipants as total_alpha' => function ($q) {
                $q->where('status_kehadiran', 'alpha');
            },
            'rondaParticipants as total_digantikan' => function ($q) {
                $q->where('status_kehadiran', 'digantikan');
            },
        ])
        ->orderBy('total_hadir', 'desc')
        ->paginate(15);

        return view('ronda.rekap', compact('wargas'));
    }

    public function exportPdf(Request $request)
    {
        $schedules = RondaSchedule::with(['participants.warga', 'createdBy'])
            ->orderBy('tanggal_ronda', 'desc')
            ->take(30)
            ->get();

        $pdf = Pdf::loadView('reports.ronda_pdf', compact('schedules'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('Jadwal_Ronda_RT03_' . date('Ymd') . '.pdf');
    }
}
