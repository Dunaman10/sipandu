<?php

namespace App\Http\Controllers;

use App\Models\ClusteringResult;
use App\Models\ClusteringSession;
use App\Models\Warga;
use App\Services\KMeansService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ClusteringController extends Controller
{
    public function index()
    {
        $sessions = ClusteringSession::with(['user', 'results'])->latest('id')->paginate(10);
        $totalWarga = Warga::count();
        $latestSession = ClusteringSession::with(['results.warga', 'iterations'])->latest('id')->first();

        return view('clustering.index', compact('sessions', 'totalWarga', 'latestSession'));
    }

    public function run(Request $request, KMeansService $kMeansService)
    {
        try {
            $session = $kMeansService->run(auth()->user(), 3);

            return redirect()->route('clustering.show', $session->id)
                ->with('success', "Algoritma K-Means berhasil dijalankan! Menghasilkan {$session->jumlah_cluster} cluster dalam {$session->total_iterasi} iterasi.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menjalankan K-Means: ' . $e->getMessage());
        }
    }

    public function show(ClusteringSession $session)
    {
        $session->load(['user', 'iterations', 'results.warga']);

        $cluster1Count = $session->results->where('cluster_terpilih', 'cluster_1')->count();
        $cluster2Count = $session->results->where('cluster_terpilih', 'cluster_2')->count();
        $cluster3Count = $session->results->where('cluster_terpilih', 'cluster_3')->count();

        return view('clustering.show', compact('session', 'cluster1Count', 'cluster2Count', 'cluster3Count'));
    }

    public function destroy(ClusteringSession $session)
    {
        $session->delete();
        return redirect()->route('clustering.index')->with('success', 'Sesi clustering berhasil dihapus.');
    }

    public function exportPdf(ClusteringSession $session)
    {
        $session->load(['user', 'iterations', 'results.warga']);

        $cluster1Count = $session->results->where('cluster_terpilih', 'cluster_1')->count();
        $cluster2Count = $session->results->where('cluster_terpilih', 'cluster_2')->count();
        $cluster3Count = $session->results->where('cluster_terpilih', 'cluster_3')->count();

        $pdf = Pdf::loadView('reports.clustering_pdf', compact('session', 'cluster1Count', 'cluster2Count', 'cluster3Count'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('Laporan_KMeans_RT03_' . $session->kode_sesi . '.pdf');
    }
}
