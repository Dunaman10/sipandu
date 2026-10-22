<?php

namespace App\Http\Controllers;

use App\Models\ClusteringResult;
use App\Models\ClusteringSession;
use App\Models\KasWarga;
use App\Models\RondaSchedule;
use App\Models\Warga;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalWarga = Warga::count();
        $totalKk = Warga::distinct('no_kk')->count('no_kk');
        $wargaBelumKtp = Warga::where('status_ktp', 'belum')->count();

        // Kas Stats
        $currentMonth = date('Y-m');
        $totalKasTerkumpul = KasWarga::where('status_pembayaran', 'lunas')->sum('nominal_iuran');
        $totalKasMenunggak = KasWarga::where('status_pembayaran', 'belum_lunas')->sum('nominal_iuran');
        $kasBulanIniLunas = KasWarga::where('periode_bulan', $currentMonth)->where('status_pembayaran', 'lunas')->sum('nominal_iuran');
        $kasBulanIniBelum = KasWarga::where('periode_bulan', $currentMonth)->where('status_pembayaran', 'belum_lunas')->sum('nominal_iuran');

        // Ronda Stats: upcoming or today's schedule
        $upcomingRonda = RondaSchedule::with(['participants.warga'])
            ->whereDate('tanggal_ronda', '>=', now()->toDateString())
            ->orderBy('tanggal_ronda', 'asc')
            ->first();

        if (! $upcomingRonda) {
            $upcomingRonda = RondaSchedule::with(['participants.warga'])
                ->orderBy('tanggal_ronda', 'desc')
                ->first();
        }

        // Latest Clustering Session
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

        // Recent Warga
        $recentWargas = Warga::latest('id')->take(5)->get();

        return view('dashboard', compact(
            'totalWarga',
            'totalKk',
            'wargaBelumKtp',
            'totalKasTerkumpul',
            'totalKasMenunggak',
            'kasBulanIniLunas',
            'kasBulanIniBelum',
            'upcomingRonda',
            'latestSession',
            'clusterCounts',
            'recentWargas'
        ));
    }
}
