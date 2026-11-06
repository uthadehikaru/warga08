<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'latitude',
        'longitude',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'birth_date' => 'date',
        'password' => 'hashed',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    public static function religion(): array
    {
        return ['islam', 'kristen', 'protestan', 'hindu', 'budha', 'konghucu'];
    }

    public function scopeRt($query): void
    {
        $query->where('role', 'rt');
    }

    public function scopeWarga($query): void
    {
        $query->whereNotNull('nik');
    }

    public function scopeRw($query): void
    {
        $query->where('role', 'rw');
    }

    public function scopePosyandu($query): void
    {
        $query->where('role', 'posyandu');
    }

    public function scopeJumantik($query): void
    {
        $query->where('role', 'jumantik');
    }

    /**
     * A jumantik officer with an empty RT covers every RT.
     */
    public function coversAllJumantikRts(): bool
    {
        return $this->role === 'jumantik' && $this->rt === null;
    }

    public function canManageJumantikOfficers(): bool
    {
        return $this->role === 'rw' || $this->coversAllJumantikRts();
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->role == 'admin';
    }

    public function getAgeAttribute(): int
    {
        return now()->diffInYears($this->birth_date);
    }

    public function healthRecord(): HasOne
    {
        return $this->hasOne(HealthRecord::class);
    }
}
