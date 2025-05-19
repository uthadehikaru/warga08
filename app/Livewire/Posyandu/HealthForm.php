<?php

namespace App\Livewire\Posyandu;

use App\Models\User;
use App\Models\HealthRecord;
use App\Models\HealthHistory;
use Livewire\Component;

class HealthForm extends Component
{
    public $warga;
    public $health_record;
    
    // Basic measurements
    public $check_date;
    public $height;
    public $weight;
    public $imt;
    public $lingkar_perut;
    
    // Blood pressure and related
    public $sistol;
    public $diastol;
    public $tekanan_darah;
    public $gula_darah;
    public $kadar_hb;
    public $anemia;
    
    // Health conditions
    public $tbc = [
        'batuk' => false,
        'demam' => false,
        'bb_stagnan' => false,
        'kontak_tbc' => false,
    ];
    
    // Problem indicators
    public $masalah = [
        'di_rumah' => false,
        'di_instansi' => false,
        'pola_makan' => false,
        'aktivitas' => false,
        'obat' => false,
        'seksual' => false,
        'keamanan' => false,
        'depresi' => false,
    ];
    
    // Additional info
    public $edukasi;
    public $rujuk = false;

    public function mount($nik)
    {
        $this->warga = User::where('nik', $nik)->first();
        $this->health_record = HealthRecord::firstOrCreate(['user_id' => $this->warga->id]);
        $this->check_date = now()->format('Y-m-d');
    }


    public function updated()
    {
        $this->calculateIMT();
        $this->calculateTekananDarah();
        $this->calculateKadarHb();
        $this->checkRujukan();
    }

    public function calculateKadarHb()
    {
        if ($this->kadar_hb) {
            if ($this->kadar_hb < 13.5) {
                $this->anemia = 'Ya';
            } else {
                $this->anemia = 'Tidak';
            }
        }
    }
    

    public function checkRujukan()
    {
        $checkTbc = collect($this->tbc)->filter(function($value) {
            return $value === true;
        })->count();

        $checkMasalah = collect($this->masalah)->filter(function($value) {
            return $value === true;
        })->count();

        if ($checkTbc >= 2 || $checkMasalah >= 1) {
            $this->rujuk = true;
        }else{
            $this->rujuk = false;
        }
    }

    public function calculateIMT()
    {
        if ($this->height && $this->weight) {
            $heightInMeters = $this->height / 100;
            $imt = number_format($this->weight / ($heightInMeters * $heightInMeters), 2);
            if($imt < 17.0){
                $this->imt = 'Sangat Kurus';
            }elseif($imt >= 17.0 && $imt < 18.5){
                $this->imt = 'Kurus';
            }elseif($imt >= 18.5 && $imt < 25.0){
                $this->imt = 'Normal';
            }elseif($imt >= 25.0 && $imt < 30.0){
                $this->imt = 'Gemuk';
            }else{
                $this->imt = 'Obesitas';
            }
        }
    }

    public function calculateTekananDarah()
    {
        if ($this->sistol && $this->diastol) {
            if($this->sistol < 90 || $this->diastol < 60) {
                $this->tekanan_darah = 'Rendah';
            } elseif($this->sistol >= 90 && $this->sistol <= 120 && $this->diastol >= 60 && $this->diastol <= 80) {
                $this->tekanan_darah = 'Normal';
            } else {
                $this->tekanan_darah = 'Tinggi';
            }
        }
    }

    public function save()
    {
        $this->calculateIMT();
        $this->calculateTekananDarah();
        $this->calculateKadarHb();
        $this->checkRujukan();

        $validatedData = $this->validate([
            'check_date' => 'required|date',
            'height' => 'nullable|integer|min:1',
            'weight' => 'nullable|integer|min:1',
            'imt' => 'nullable|string',
            'lingkar_perut' => 'nullable|integer|min:1',
            'sistol' => 'nullable|integer|min:1',
            'diastol' => 'nullable|integer|min:1',
            'tekanan_darah' => 'nullable|string',
            'gula_darah' => 'nullable|string',
            'kadar_hb' => 'nullable|integer|min:1',
            'anemia' => 'nullable|string',
            'tbc.batuk' => 'boolean',
            'tbc.demam' => 'boolean',
            'tbc.bb_stagnan' => 'boolean',
            'tbc.kontak_tbc' => 'boolean',
            'masalah.di_rumah' => 'boolean',
            'masalah.di_instansi' => 'boolean',
            'masalah.pola_makan' => 'boolean',
            'masalah.aktivitas' => 'boolean',
            'masalah.obat' => 'boolean',
            'masalah.seksual' => 'boolean',
            'masalah.keamanan' => 'boolean',
            'masalah.depresi' => 'boolean',
            'edukasi' => 'nullable|string',
            'rujuk' => 'boolean',
        ]);

        $validatedData['health_record_id'] = $this->health_record->id;

        foreach($validatedData['tbc'] as $key => $value){
            $validatedData[$key] = $value;
        }
        unset($validatedData['tbc']);

        foreach($validatedData['masalah'] as $key => $value){
            $validatedData['masalah_'.$key] = $value;
        }
        unset($validatedData['masalah']);
        
        HealthHistory::create($validatedData);
        
        session()->flash('message', 'Data kesehatan berhasil disimpan.');
        
        return redirect()->route('posyandu.teens.records', ['nik' => $this->warga->nik]);
    }

    public function render()
    {
        return view('livewire.posyandu.health-form')
        ->extends('layouts.posyandu');
    }
}
