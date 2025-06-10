<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HealthRecord extends Model
{
    use HasFactory;


    public const TYPE = [
        'remaja' => 'Remaja',
        'balita' => 'Balita',
        'ibu_hamil' => 'Ibu Hamil',
        'lansia' => 'Lansia',
    ];
    
    public const STEP = [
        '1' => 'Registrasi dan Verifikasi',
        '2' => 'Penimbangan dan Pengukuran',
        '3' => 'Pencatatan',
        '4' => 'Pelayanan Kesehatan',
        '5' => 'Edukasi',
        '6' => 'Selesai',
    ];

    public const DISEASES = [
        'hipertensi' => 'Hipertensi',
        'dm' => 'DM (Diabetes Melitus)',
        'stroke' => 'Stroke',
        'jantung' => 'Jantung',
        'asma' => 'Asma',
        'kanker' => 'Kanker',
        'kolesterol' => 'Kolesterol Tinggi',
    ];

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
