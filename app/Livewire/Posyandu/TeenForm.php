<?php

namespace App\Livewire\Posyandu;

use App\Models\HealthHistory;
use App\Models\HealthRecord;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Illuminate\Support\Str;

class TeenForm extends Component
{
    public $form = false;
    public $types = HealthRecord::TYPE;
    public $type = 'remaja';
    public $teens = [];
    public $search = '';
    public $rt;
    public $check_date;
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

    public function mount($type = null, $nik = null)
    {
        $this->check_date = now()->format('Y-m-d');
        $this->type = request()->get('type') ?? $type;
        if($nik){
            $this->selectTeen($nik);
        }
    }

    public function searchTeen()
    {
        $this->teens = User::warga()->where(function($query) {
            $query->where('name', 'like', '%'.$this->search.'%')
                  ->orWhere('nik', 'like', '%'.$this->search.'%');
        })->orderBy('name')->get()->toArray();
    }

    public function selectTeen($nik)
    {
        $this->check_date = now()->format('Y-m-d');
        $user = User::warga()->where('nik', $nik)->first();
        $this->rt = $user->rt;
        $this->nik = $user->nik;
        $this->name = $user->name;
        $this->birth_place = $user->birth_place;
        $this->birth_date = $user->birth_date->format('Y-m-d');
        $this->gender = $user->gender;
        $this->address = $user->address;
        
        $healthRecord = HealthRecord::where('user_id', $user->id)->first();
        if($healthRecord){
            $this->father_name = $user->healthRecord->father_name;
            $this->mother_name = $user->healthRecord->mother_name;
            foreach($this->diseases as $key => $disease){
                if(in_array($key, $user->healthRecord->family_diseases ?? [])){
                    $this->family_disease[$key] = true;
                }
                if(in_array($key, $user->healthRecord->personal_diseases ?? [])){
                    $this->personal_disease[$key] = true;
                }
            }
        }
        $this->form = true;
    }

    public function register()
    {
        $this->form = true;
        $this->check_date = now()->format('Y-m-d');
    }

    public function cancel()
    {
        $this->form = false;
        $this->reset();
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

            $history = HealthHistory::where('health_record_id', $record->id)
                ->whereDate('check_date', $this->check_date)
                ->first();

            if (!$history) {
                $history = HealthHistory::create([
                    'health_record_id' => $record->id,
                    'check_date' => $this->check_date,
                    'type' => $this->type,
                    'age' => $warga->age,
                ]);
            }
    
            DB::commit();
            $this->reset();
            session()->flash('success', 'Data berhasil disimpan');
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
