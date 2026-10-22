<?php

namespace App\Http\Controllers;

use App\Models\KasWarga;
use App\Models\Warga;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class KasWargaController extends Controller
{
    public function index(Request $request)
    {
        $selectedPeriode = $request->input('periode_bulan', date('Y-m'));

        $query = KasWarga::with(['warga', 'bendahara']);

        if ($selectedPeriode !== 'all') {
            $query->where('periode_bulan', $selectedPeriode);
        }

        if ($request->filled('status_pembayaran')) {
            $query->where('status_pembayaran', $request->input('status_pembayaran'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('warga', function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('alamat_blok', 'like', "%{$search}%");
            });
        }

        $kasList = $query->latest('id')->paginate(15)->withQueryString();

        // Calculate summary for selected period
        $statsQuery = KasWarga::query();
        if ($selectedPeriode !== 'all') {
            $statsQuery->where('periode_bulan', $selectedPeriode);
        }

        $totalLunas = (clone $statsQuery)->where('status_pembayaran', 'lunas')->sum('nominal_iuran');
        $totalBelumLunas = (clone $statsQuery)->where('status_pembayaran', 'belum_lunas')->sum('nominal_iuran');
        $countLunas = (clone $statsQuery)->where('status_pembayaran', 'lunas')->count();
        $countBelumLunas = (clone $statsQuery)->where('status_pembayaran', 'belum_lunas')->count();

        // Available periods for filter
        $availablePeriodes = KasWarga::select('periode_bulan')->distinct()->orderBy('periode_bulan', 'desc')->pluck('periode_bulan');

        $wargas = Warga::orderBy('nama_lengkap', 'asc')->get();

        return view('kas.index', compact(
            'kasList',
            'selectedPeriode',
            'totalLunas',
            'totalBelumLunas',
            'countLunas',
            'countBelumLunas',
            'availablePeriodes',
            'wargas'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'warga_id' => ['required', 'exists:wargas,id'],
            'periode_bulan' => ['required', 'string', 'max:20'],
            'nominal_iuran' => ['required', 'numeric', 'min:0'],
            'status_pembayaran' => ['required', 'in:lunas,belum_lunas'],
            'tanggal_bayar' => ['nullable', 'date'],
            'keterangan' => ['nullable', 'string'],
        ]);

        $validated['bendahara_id'] = auth()->id();

        if ($validated['status_pembayaran'] === 'lunas' && empty($validated['tanggal_bayar'])) {
            $validated['tanggal_bayar'] = now()->toDateString();
        }

        KasWarga::updateOrCreate(
            [
                'warga_id' => $validated['warga_id'],
                'periode_bulan' => $validated['periode_bulan'],
            ],
            $validated
        );

        return redirect()->back()->with('success', 'Catatan iuran kas warga berhasil disimpan.');
    }

    public function generateBulanan(Request $request)
    {
        $periode = $request->input('periode_bulan', date('Y-m'));
        $nominal = $request->input('nominal_iuran', 50000);
        $wargas = Warga::all();

        $count = 0;
        foreach ($wargas as $w) {
            $exists = KasWarga::where('warga_id', $w->id)->where('periode_bulan', $periode)->exists();
            if (! $exists) {
                KasWarga::create([
                    'warga_id' => $w->id,
                    'bendahara_id' => auth()->id(),
                    'periode_bulan' => $periode,
                    'nominal_iuran' => $nominal,
                    'status_pembayaran' => 'belum_lunas',
                    'tanggal_bayar' => null,
                    'keterangan' => 'Tagihan iuran kas bulanan RT 03',
                ]);
                $count++;
            }
        }

        return redirect()->route('kas.index', ['periode_bulan' => $periode])
            ->with('success', "Berhasil menerbitkan {$count} tagihan kas untuk periode {$periode}.");
    }

    public function toggleStatus(KasWarga $ka)
    {
        if ($ka->status_pembayaran === 'lunas') {
            $ka->update([
                'status_pembayaran' => 'belum_lunas',
                'tanggal_bayar' => null,
            ]);
            $msg = 'Status iuran diubah menjadi Belum Lunas.';
        } else {
            $ka->update([
                'status_pembayaran' => 'lunas',
                'tanggal_bayar' => now()->toDateString(),
            ]);
            $msg = 'Pembayaran iuran kas berhasil dicatat sebagai Lunas.';
        }

        return redirect()->back()->with('success', $msg);
    }

    public function destroy(KasWarga $ka)
    {
        $ka->delete();
        return redirect()->back()->with('success', 'Catatan kas berhasil dihapus.');
    }

    public function exportPdf(Request $request)
    {
        $selectedPeriode = $request->input('periode_bulan', date('Y-m'));

        $query = KasWarga::with(['warga', 'bendahara']);

        if ($selectedPeriode !== 'all') {
            $query->where('periode_bulan', $selectedPeriode);
        }

        $kasList = $query->orderBy('status_pembayaran', 'desc')->get();

        $totalLunas = $kasList->where('status_pembayaran', 'lunas')->sum('nominal_iuran');
        $totalBelumLunas = $kasList->where('status_pembayaran', 'belum_lunas')->sum('nominal_iuran');

        $pdf = Pdf::loadView('reports.kas_pdf', compact('kasList', 'selectedPeriode', 'totalLunas', 'totalBelumLunas'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('Laporan_Kas_RT03_' . $selectedPeriode . '.pdf');
    }
}
