<?php

namespace App\Livewire\Posyandu;

use App\Models\HealthRecord;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Illuminate\Support\Str;

class TeenForm extends Component
{
    public $rt;
    public $nik;
    public $name;
    public $father_name;
    public $mother_name;
    public $birth_place;
    public $birth_date;
    public $gender;
    public $address;
    public $family_disease = [];
    public $personal_disease = [];
    public $diseases = HealthRecord::DISEASES;

    public $rules = [
        'nik' => 'required|numeric|digits:16',
        'name' => 'required|string|max:255',
        'birth_place' => 'required|string|max:255',
        'birth_date' => 'required|date',
        'gender' => 'required|in:p,w',
        'address' => 'required|string|max:255',
        'rt' => 'required|numeric',
        'father_name' => 'required|string|max:255',
        'mother_name' => 'required|string|max:255',
        'family_disease' => 'nullable|array',
        'personal_disease' => 'nullable|array',
    ];

    public function mount($nik = null)
    {
        $warga = User::with('healthRecord')->where('nik', $nik)->first();
        if($nik && $warga){
            $this->rt = $warga->rt;
            $this->nik = $warga->nik;
            $this->name = $warga->name;
            $this->father_name = $warga->healthRecord->father_name;
            $this->mother_name = $warga->healthRecord->mother_name;
            $this->birth_place = $warga->birth_place;
            $this->birth_date = $warga->birth_date->format('Y-m-d');
            $this->gender = $warga->gender;
            $this->address = $warga->address;
            foreach($this->diseases as $key => $disease){
                if(in_array($key, $warga->healthRecord->family_diseases)){
                    $this->family_disease[$key] = true;
                }
                if(in_array($key, $warga->healthRecord->personal_diseases)){
                    $this->personal_disease[$key] = true;
                }
            }
        }
    }

    public function save()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            $email = Str::random(10).'@warga08.web.id';
            
            $warga = User::updateOrCreate([
                'nik' => $this->nik,
            ], [
                'password' => Hash::make('password'),
                'name' => $this->name,
                'email' => $email,
                'birth_place' => $this->birth_place,
                'birth_date' => $this->birth_date,
                'gender' => $this->gender,
                'address' => $this->address,
                'rt' => $this->rt,
            ]);

            $family_diseases = [];
            $personal_diseases = [];
            foreach ($this->family_disease as $key => $value) {
                if($value){
                    $family_diseases[] = $key;
                }
            }

            foreach ($this->personal_disease as $key => $value) {
                if($value){
                    $personal_diseases[] = $key;
                }
            }

            $record = HealthRecord::updateOrCreate([
                'user_id' => $warga->id,
            ], [
                'father_name' => $this->father_name,
                'mother_name' => $this->mother_name,
                'family_diseases' => $family_diseases,
                'personal_diseases' => $personal_diseases,
            ]);
    
            DB::commit();
            return redirect()->route('posyandu.teens.records.form', $warga->nik);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            $this->addError('error', $e->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.posyandu.teen-form')
        ->extends('layouts.posyandu');
    }
}
