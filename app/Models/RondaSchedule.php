<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RondaSchedule extends Model
{
    use HasFactory;

    protected $table = 'ronda_schedules';

    protected $fillable = [
        'tanggal_ronda',
        'shift_ronda',
        'keterangan_khusus',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_ronda' => 'date',
        ];
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function participants(): HasMany
    {
        return $this->hasMany(RondaParticipant::class);
    }
}
