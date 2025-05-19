<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HealthRecord extends Model
{
    use HasFactory;

    protected $casts = [
        'family_diseases' => 'array',
        'personal_diseases' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function healthHistories():HasMany
    {
        return $this->hasMany(HealthHistory::class);
    }
}
