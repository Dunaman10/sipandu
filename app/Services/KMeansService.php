<?php

namespace App\Services;

use App\Models\ClusteringIteration;
use App\Models\ClusteringResult;
use App\Models\ClusteringSession;
use App\Models\User;
use App\Models\Warga;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class KMeansService
{
    protected int $k = 3;
    protected int $maxIterations = 100;

    public function run(User $user, int $k = 3): ClusteringSession
    {
        $this->k = $k;
        $wargas = Warga::all();

        if ($wargas->count() < $this->k) {
            throw new \Exception("Jumlah data warga minimal harus sebanyak {$this->k} untuk clustering.");
        }

        // 1. Prepare data points
        // Atribut: [usia, skor_ekonomi, jumlah_tanggungan, skor_kondisi_rumah]
        $dataPoints = [];
        foreach ($wargas as $warga) {
            $dataPoints[] = [
                'warga_id' => $warga->id,
                'nama' => $warga->nama_lengkap,
                'nik' => $warga->nik,
                'vector' => [
                    'usia' => (float) $warga->usia,
                    'skor_ekonomi' => (float) $warga->skor_ekonomi,
                    'jumlah_tanggungan' => (float) $warga->jumlah_tanggungan,
                    'skor_kondisi_rumah' => (float) $warga->skor_kondisi_rumah,
                ],
            ];
        }

        // 2. Inisialisasi Centroid Awal
        $centroids = $this->initializeCentroids($dataPoints, $this->k);
        $initialCentroids = $centroids;

        $iterationsData = [];
        $isConverged = false;
        $iterationCount = 0;
        $finalAssignments = [];

        // 3. Iterasi K-Means
        while (!$isConverged && $iterationCount < $this->maxIterations) {
            $iterationCount++;

            $matrixJarak = [];
            $clusterMembers = array_fill(0, $this->k, []);

            // Hitung jarak Euclidean untuk tiap titik ke setiap centroid
            foreach ($dataPoints as $point) {
                $distances = [];
                foreach ($centroids as $cIndex => $centroid) {
                    $dist = $this->calculateEuclideanDistance($point['vector'], $centroid);
                    $distances[$cIndex] = round($dist, 4);
                }

                // Cari centroid terdekat
                $minDist = min($distances);
                $assignedCluster = array_search($minDist, $distances);

                $clusterMembers[$assignedCluster][] = $point;

                $matrixJarak[] = [
                    'warga_id' => $point['warga_id'],
                    'nama' => $point['nama'],
                    'jarak_c1' => $distances[0] ?? 0,
                    'jarak_c2' => $distances[1] ?? 0,
                    'jarak_c3' => $distances[2] ?? 0,
                    'jarak_terdekat' => $minDist,
                    'cluster' => $assignedCluster + 1,
                ];
            }

            // Hitung Centroid Baru
            $newCentroids = [];
            for ($i = 0; $i < $this->k; $i++) {
                if (count($clusterMembers[$i]) > 0) {
                    $sumVector = [
                        'usia' => 0,
                        'skor_ekonomi' => 0,
                        'jumlah_tanggungan' => 0,
                        'skor_kondisi_rumah' => 0,
                    ];
                    $count = count($clusterMembers[$i]);
                    foreach ($clusterMembers[$i] as $member) {
                        foreach ($sumVector as $key => $val) {
                            $sumVector[$key] += $member['vector'][$key];
                        }
                    }
                    $newCentroids[$i] = [
                        'usia' => round($sumVector['usia'] / $count, 2),
                        'skor_ekonomi' => round($sumVector['skor_ekonomi'] / $count, 2),
                        'jumlah_tanggungan' => round($sumVector['jumlah_tanggungan'] / $count, 2),
                        'skor_kondisi_rumah' => round($sumVector['skor_kondisi_rumah'] / $count, 2),
                    ];
                } else {
                    // Jika cluster kosong, pertahankan centroid sebelumnya
                    $newCentroids[$i] = $centroids[$i];
                }
            }

            // Periksa konvergensi
            $isConverged = $this->checkConvergence($centroids, $newCentroids);

            $iterationsData[] = [
                'iterasi_ke' => $iterationCount,
                'centroid_iterasi_json' => $centroids,
                'matriks_jarak_json' => $matrixJarak,
                'is_konvergen' => $isConverged,
            ];

            $centroids = $newCentroids;
            $finalAssignments = $matrixJarak;
        }

        // 4. Analisis Karakteristik Cluster untuk rekomendasi kebijakan
        // Cluster dengan skor_ekonomi paling rendah dan kondisi rumah/tanggungan tinggi -> Prioritas Utama
        $clusterRankings = $this->rankClustersByNeed($centroids);

        // 5. Simpan ke database
        $kodeSesi = 'KM-' . date('Ymd') . '-' . strtoupper(Str::random(5));

        $session = ClusteringSession::create([
            'kode_sesi' => $kodeSesi,
            'user_id' => $user->id,
            'tanggal_proses' => now(),
            'jumlah_cluster' => $this->k,
            'total_data_warga' => count($dataPoints),
            'total_iterasi' => $iterationCount,
            'centroid_awal_json' => $initialCentroids,
            'centroid_akhir_json' => $centroids,
        ]);

        foreach ($iterationsData as $it) {
            ClusteringIteration::create([
                'clustering_session_id' => $session->id,
                'iterasi_ke' => $it['iterasi_ke'],
                'centroid_iterasi_json' => $it['centroid_iterasi_json'],
                'matriks_jarak_json' => $it['matriks_jarak_json'],
                'is_konvergen' => $it['is_konvergen'],
            ]);
        }

        foreach ($finalAssignments as $res) {
            $rawCluster = $res['cluster']; // 1, 2, or 3
            $rankedCluster = $clusterRankings[$rawCluster - 1]; // mapped to standard label

            ClusteringResult::create([
                'clustering_session_id' => $session->id,
                'warga_id' => $res['warga_id'],
                'jarak_c1' => $res['jarak_c1'],
                'jarak_c2' => $res['jarak_c2'],
                'jarak_c3' => $res['jarak_c3'],
                'jarak_terdekat' => $res['jarak_terdekat'],
                'cluster_terpilih' => $rankedCluster['cluster_key'], // 'cluster_1', 'cluster_2', 'cluster_3'
                'rekomendasi_kebijakan' => $rankedCluster['rekomendasi'],
            ]);
        }

        return $session;
    }

    protected function initializeCentroids(array $dataPoints, int $k): array
    {
        // Sort by economic score & condition to get well-separated starting centroids
        usort($dataPoints, function ($a, $b) {
            return $a['vector']['skor_ekonomi'] <=> $b['vector']['skor_ekonomi'];
        });

        $count = count($dataPoints);
        $indices = [
            0, // lowest income
            (int) floor($count / 2), // middle income
            $count - 1, // highest income
        ];

        $centroids = [];
        for ($i = 0; $i < $k; $i++) {
            $idx = $indices[$i] ?? $i;
            $centroids[] = $dataPoints[$idx]['vector'];
        }

        return $centroids;
    }

    protected function calculateEuclideanDistance(array $v1, array $v2): float
    {
        $sum = 0.0;
        foreach ($v1 as $key => $val) {
            $diff = $val - ($v2[$key] ?? 0);
            $sum += $diff * $diff;
        }
        return sqrt($sum);
    }

    protected function checkConvergence(array $oldCentroids, array $newCentroids, float $epsilon = 0.0001): bool
    {
        foreach ($oldCentroids as $i => $old) {
            $dist = $this->calculateEuclideanDistance($old, $newCentroids[$i]);
            if ($dist > $epsilon) {
                return false;
            }
        }
        return true;
    }

    protected function rankClustersByNeed(array $finalCentroids): array
    {
        // Score need: lower skor_ekonomi + higher skor_kondisi_rumah + higher tanggungan
        $ranked = [];
        foreach ($finalCentroids as $idx => $centroid) {
            // Need Index: higher score = higher need
            $needScore = (5 - $centroid['skor_ekonomi']) * 2 + ($centroid['skor_kondisi_rumah'] * 2) + $centroid['jumlah_tanggungan'];
            $ranked[$idx] = [
                'idx' => $idx,
                'need_score' => $needScore,
            ];
        }

        // Sort descending by need score (highest need first)
        usort($ranked, function ($a, $b) {
            return $b['need_score'] <=> $a['need_score'];
        });

        $clusterKeyMapping = [];
        // Top 1 highest need: Cluster 1
        $clusterKeyMapping[$ranked[0]['idx']] = [
            'cluster_key' => 'cluster_1',
            'label' => 'Cluster 1 (Prioritas Bantuan Utama)',
            'rekomendasi' => 'Penerima Bantuan Sosial Utama (PKH, BLT RT, dan Sembako Rutin)',
        ];

        // Rank 2: Cluster 2
        $clusterKeyMapping[$ranked[1]['idx']] = [
            'cluster_key' => 'cluster_2',
            'label' => 'Cluster 2 (Prioritas Bantuan Pendukung)',
            'rekomendasi' => 'Prioritas Bantuan Subsidi Pangan / Padat Karya Lingkungan RT',
        ];

        // Rank 3: Cluster 3
        $clusterKeyMapping[$ranked[2]['idx']] = [
            'cluster_key' => 'cluster_3',
            'label' => 'Cluster 3 (Mandiri / Mampu)',
            'rekomendasi' => 'Warga Mandiri / Calon Donatur Program Kesejahteraan RT',
        ];

        return $clusterKeyMapping;
    }
}
