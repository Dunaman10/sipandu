<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClusteringIteration extends Model
{
    use HasFactory;

    protected $table = 'clustering_iterations';

    public $timestamps = false;

    protected $fillable = [
        'clustering_session_id',
        'iterasi_ke',
        'centroid_iterasi_json',
        'matriks_jarak_json',
        'is_konvergen',
    ];

    protected function casts(): array
    {
        return [
            'iterasi_ke' => 'integer',
            'centroid_iterasi_json' => 'array',
            'matriks_jarak_json' => 'array',
            'is_konvergen' => 'boolean',
            'created_at' => 'datetime',
        ];
    }

    public function session(): BelongsTo
    {
        return $this->belongsTo(ClusteringSession::class, 'clustering_session_id');
    }
}
