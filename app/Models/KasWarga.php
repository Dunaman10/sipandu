<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KasWarga extends Model
{
    use HasFactory;

    protected $table = 'kas_wargas';

    protected $fillable = [
        'warga_id',
        'bendahara_id',
        'periode_bulan',
        'nominal_iuran',
        'status_pembayaran',
        'tanggal_bayar',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'nominal_iuran' => 'decimal:2',
            'tanggal_bayar' => 'date',
        ];
    }

    public function warga(): BelongsTo
    {
        return $this->belongsTo(Warga::class);
    }

    public function bendahara(): BelongsTo
    {
        return $this->belongsTo(User::class, 'bendahara_id');
    }

    public function getFormattedNominalAttribute(): string
    {
        return 'Rp ' . number_format($this->nominal_iuran, 0, ',', '.');
    }
}
