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

    public function getSummaryAttribute()
    {
        $message = "Hasil pengecekan ".$this->healthRecord->user->name.'%0a';
        $message .= 'Tanggal : '.$this->check_date->format('d M Y').'%0a';
        $message .= 'Berat Badan : '.$this->weight.' kg%0a';
        $message .= 'Tinggi Badan : '.$this->height.' cm%0a';
        $message .= 'IMT : '.$this->imt.'%0a';
        $message .= 'Lingkar Perut : '.$this->lingkar_perut.' cm%0a';
        $message .= 'Tekanan Darah : '.$this->sistol.'/'.$this->diastol.' mmHg%0a';
        $message .= 'Gula Darah : '.$this->gula_darah.' mg/dL%0a';
        if($this->healthRecord->user->gender=='w'){
            $message .= 'Kadar HB : '.$this->kadar_hb.' g/dL%0a';
            $message .= 'Status Anemia : '.($this->anemia ? 'Ya' : 'Tidak').'%0a';
        }
        
        $gejala = "";
        if ($this->batuk) $gejala .= '- Batuk%0a';
        if ($this->demam) $gejala .= '- Demam%0a';
        if ($this->bb_stagnan) $gejala .= '- BB Stagnan%0a';
        if ($this->kontak_tbc) $gejala .= '- Kontak TBC%0a';
        if($gejala)
            $message .= 'Gejala TBC :%0a'.$gejala;

        $masalah = "";
        if ($this->masalah_di_rumah) $masalah .= '- Masalah di Rumah%0a';
        if ($this->masalah_di_instansi) $masalah .= '- Masalah di Instansi%0a';
        if ($this->masalah_pola_makan) $masalah .= '- Masalah Pola Makan%0a';
        if ($this->masalah_aktivitas) $masalah .= '- Masalah Aktivitas%0a';
        if ($this->masalah_obat) $masalah .= '- Masalah Obat%0a';
        if ($this->masalah_seksual) $masalah .= '- Masalah Seksual%0a';
        if ($this->masalah_keamanan) $masalah .= '- Masalah Keamanan%0a';
        if ($this->masalah_depresi) $masalah .= '- Masalah Depresi%0a';
        if($masalah)
            $message .= 'Masalah :%0a'.$masalah;

        if ($this->edukasi) $message .= 'Edukasi : '.$this->edukasi.'%0a';
        if ($this->rujuk) $message .= 'Rujukan : '.$this->rujuk.'%0a';

        return $message;
    }
}
