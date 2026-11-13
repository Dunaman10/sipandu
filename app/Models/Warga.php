<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Warga extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik',
        'no_kk',
        'nama_lengkap',
        'jenis_kelamin',
        'agama',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat_blok',
        'status_ktp',
        'pekerjaan',
        'usia',
        'penghasilan_bulanan',
        'skor_ekonomi',
        'status_kepemilikan_rumah',
        'keterangan',
        'created_by',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
            'usia' => 'integer',
            'penghasilan_bulanan' => 'decimal:2',
            'skor_ekonomi' => 'integer',
        ];
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function clusteringResults(): HasMany
    {
        return $this->hasMany(ClusteringResult::class);
    }

    public function latestClusteringResult(): HasOne
    {
        return $this->hasOne(ClusteringResult::class)->latestOfMany();
    }

    public function rondaParticipants(): HasMany
    {
        return $this->hasMany(RondaParticipant::class);
    }

    public function getJenisKelaminLabelAttribute(): string
    {
        return $this->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
    }

    public function getFormattedPenghasilanAttribute(): string
    {
        return 'Rp ' . number_format($this->penghasilan_bulanan, 0, ',', '.');
    }
}
