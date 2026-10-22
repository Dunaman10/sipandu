<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'no_hp',
        'role',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isKetuaRt(): bool
    {
        return $this->role === 'ketua_rt';
    }

    public function isBendahara(): bool
    {
        return $this->role === 'bendahara';
    }

    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            'admin' => 'Administrator',
            'ketua_rt' => 'Ketua RT 03',
            'bendahara' => 'Bendahara RT 03',
            default => ucfirst($this->role),
        };
    }

    public function wargasCreated(): HasMany
    {
        return $this->hasMany(Warga::class, 'created_by');
    }

    public function kasWargas(): HasMany
    {
        return $this->hasMany(KasWarga::class, 'bendahara_id');
    }

    public function clusteringSessions(): HasMany
    {
        return $this->hasMany(ClusteringSession::class, 'user_id');
    }

    public function rondaSchedules(): HasMany
    {
        return $this->hasMany(RondaSchedule::class, 'created_by');
    }
}
