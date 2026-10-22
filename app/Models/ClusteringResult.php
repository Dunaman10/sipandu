<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClusteringResult extends Model
{
    use HasFactory;

    protected $table = 'clustering_results';

    protected $fillable = [
        'clustering_session_id',
        'warga_id',
        'jarak_c1',
        'jarak_c2',
        'jarak_c3',
        'jarak_terdekat',
        'cluster_terpilih',
        'rekomendasi_kebijakan',
    ];

    protected function casts(): array
    {
        return [
            'jarak_c1' => 'float',
            'jarak_c2' => 'float',
            'jarak_c3' => 'float',
            'jarak_terdekat' => 'float',
        ];
    }

    public function session(): BelongsTo
    {
        return $this->belongsTo(ClusteringSession::class, 'clustering_session_id');
    }

    public function warga(): BelongsTo
    {
        return $this->belongsTo(Warga::class);
    }

    public function getClusterLabelAttribute(): string
    {
        return match ($this->cluster_terpilih) {
            'cluster_1' => 'Cluster 1 - Prioritas Tinggi (Bansos Utama)',
            'cluster_2' => 'Cluster 2 - Prioritas Sedang (Bansos Pendukung)',
            'cluster_3' => 'Cluster 3 - Mandiri / Mampu',
            default => ucfirst(str_replace('_', ' ', $this->cluster_terpilih)),
        };
    }
}
