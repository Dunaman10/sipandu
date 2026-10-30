<?php

namespace App\Http\Controllers;

use App\Models\ClusteringResult;
use App\Models\ClusteringSession;
use App\Models\Warga;
use App\Services\KMeansService;
use App\Services\SimpleXlsxExporter;
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

    public function exportExcel(ClusteringSession $session)
    {
        $session->load(['user', 'results.warga']);

        $headers = [
            'No',
            'Nama Lengkap',
            'NIK',
            'Alamat Blok',
            'Usia (Tahun)',
            'Penghasilan (Rp)',
            'Tanggungan',
            'Jarak C1 (Utama)',
            'Jarak C2 (Sedang)',
            'Jarak C3 (Mandiri)',
            'Cluster Terpilih',
            'Kategori Bantuan',
            'Rekomendasi Kebijakan RT',
        ];

        $rows = [];
        foreach ($session->results as $index => $res) {
            $clusterLabel = match ($res->cluster_terpilih) {
                'cluster_1' => 'C1 (Utama)',
                'cluster_2' => 'C2 (Sedang)',
                default => 'C3 (Mandiri)',
            };

            $rows[] = [
                $index + 1,
                $res->warga->nama_lengkap,
                (string) $res->warga->nik,
                $res->warga->alamat_blok,
                (int) $res->warga->usia,
                (float) $res->warga->penghasilan_bulanan,
                (int) $res->warga->jumlah_tanggungan,
                (float) $res->jarak_c1,
                (float) $res->jarak_c2,
                (float) $res->jarak_c3,
                $res->cluster_terpilih,
                $clusterLabel,
                $res->rekomendasi_kebijakan,
            ];
        }

        $filename = 'Laporan_KMeans_RT03_' . $session->kode_sesi . '.xlsx';

        return SimpleXlsxExporter::download($filename, 'Hasil Clustering', $headers, $rows);
    }
}
