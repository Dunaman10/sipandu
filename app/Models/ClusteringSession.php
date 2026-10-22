<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClusteringSession extends Model
{
    use HasFactory;

    protected $table = 'clustering_sessions';

    protected $fillable = [
        'kode_sesi',
        'user_id',
        'tanggal_proses',
        'jumlah_cluster',
        'total_data_warga',
        'total_iterasi',
        'centroid_awal_json',
        'centroid_akhir_json',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_proses' => 'datetime',
            'jumlah_cluster' => 'integer',
            'total_data_warga' => 'integer',
            'total_iterasi' => 'integer',
            'centroid_awal_json' => 'array',
            'centroid_akhir_json' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function iterations(): HasMany
    {
        return $this->hasMany(ClusteringIteration::class)->orderBy('iterasi_ke');
    }

    public function results(): HasMany
    {
        return $this->hasMany(ClusteringResult::class);
    }
}
