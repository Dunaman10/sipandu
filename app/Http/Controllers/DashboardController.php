<?php

namespace App\Http\Controllers;

use App\Models\ClusteringResult;
use App\Models\ClusteringSession;
use App\Models\RondaSchedule;
use App\Models\Warga;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Kependudukan Stats
        $totalWarga = Warga::count();
        $totalKk = Warga::distinct('no_kk')->count('no_kk');
        $wargaBelumKtp = Warga::where('status_ktp', 'belum')->count();
        $wargaAdaKtp = Warga::where('status_ktp', 'ada')->count();

        $persentaseKtp = $totalWarga > 0 ? round(($wargaAdaKtp / $totalWarga) * 100, 1) : 0;

        // 2. Sebaran Kelompok Usia Warga (atribut usia - Batasan Penelitian skripsi)
        $kelompokUsia = [
            '0-16' => [0, 16],
            '17-25' => [17, 25],
            '26-35' => [26, 35],
            '36-45' => [36, 45],
            '46-55' => [46, 55],
            '56-65' => [56, 65],
            '>65' => [66, 200],
        ];
        $usiaLabels = array_keys($kelompokUsia);
        $usiaData = [];
        foreach ($kelompokUsia as [$min, $max]) {
            $usiaData[] = Warga::whereBetween('usia', [$min, $max])->count();
        }

        // 3. Ronda Stats: upcoming or today's schedule
        $upcomingRonda = RondaSchedule::with(['participants.warga'])
            ->whereDate('tanggal_ronda', '>=', now()->toDateString())
            ->orderBy('tanggal_ronda', 'asc')
            ->first();

        if (! $upcomingRonda) {
            $upcomingRonda = RondaSchedule::with(['participants.warga'])
                ->orderBy('tanggal_ronda', 'desc')
                ->first();
        }

        // 4. Latest K-Means Clustering Session
        $latestSession = ClusteringSession::with('results.warga')->latest('id')->first();
        $clusterCounts = [
            'cluster_1' => 0,
            'cluster_2' => 0,
            'cluster_3' => 0,
        ];

        if ($latestSession) {
            $counts = ClusteringResult::where('clustering_session_id', $latestSession->id)
                ->selectRaw('cluster_terpilih, count(*) as total')
                ->groupBy('cluster_terpilih')
                ->pluck('total', 'cluster_terpilih')
                ->toArray();

            $clusterCounts['cluster_1'] = $counts['cluster_1'] ?? 0;
            $clusterCounts['cluster_2'] = $counts['cluster_2'] ?? 0;
            $clusterCounts['cluster_3'] = $counts['cluster_3'] ?? 0;
        }

        // 5. Recent Warga (5 latest)
        $recentWargas = Warga::latest('id')->take(5)->get();

        return view('dashboard', compact(
            'totalWarga',
            'totalKk',
            'wargaBelumKtp',
            'wargaAdaKtp',
            'persentaseKtp',
            'usiaLabels',
            'usiaData',
            'upcomingRonda',
            'latestSession',
            'clusterCounts',
            'recentWargas'
        ));
    }
}
