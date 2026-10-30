<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RondaParticipant extends Model
{
    use HasFactory;

    protected $table = 'ronda_participants';

    protected $fillable = [
        'ronda_schedule_id',
        'warga_id',
        'catatan_keterangan',
    ];

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(RondaSchedule::class, 'ronda_schedule_id');
    }

    public function warga(): BelongsTo
    {
        return $this->belongsTo(Warga::class);
    }
}
