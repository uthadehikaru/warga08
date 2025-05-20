<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class HealthHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'health_record_id',
        'check_date',
        'height',
        'weight',
        'imt',
        'lingkar_perut',
        'sistol',
        'diastol',
        'tekanan_darah',
        'gula_darah',
        'kadar_hb',
        'anemia',
        'batuk',
        'demam',
        'bb_stagnan',
        'kontak_tbc',
        'masalah_di_rumah',
        'masalah_di_instansi',
        'masalah_pola_makan',
        'masalah_aktivitas',
        'masalah_obat',
        'masalah_seksual',
        'masalah_keamanan',
        'masalah_depresi',
        'edukasi',
        'rujuk'
    ];

    protected $casts = [
        'check_date' => 'date',
    ];

    public function healthRecord(): BelongsTo
    {
        return $this->belongsTo(HealthRecord::class);
    }
}
