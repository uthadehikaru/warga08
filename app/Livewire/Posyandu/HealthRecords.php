<?php

namespace App\Livewire\Posyandu;

use App\Models\User;
use App\Models\HealthRecord;
use Livewire\Component;
use Livewire\WithPagination;

class HealthRecords extends Component
{
    use WithPagination;
    public $warga;
    public $diseases = HealthRecord::DISEASES;

    public function mount($nik)
    {
        $this->warga = User::with(['healthRecord','healthRecord.healthHistories'])->where('nik', $nik)->first();
    }

    public function render()
    {
        $healthHistories = $this->warga->healthRecord->healthHistories()->latest('check_date')->paginate(5);
        return view('livewire.posyandu.health-records', compact('healthHistories'))
        ->extends('layouts.posyandu');
    }
}
