<?php

namespace App\Livewire\Posyandu;

use App\Models\HealthHistory;
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

    public function delete($id)
    {
        $healthHistory = HealthHistory::find($id);
        $healthHistory->delete();
        session()->flash('message', 'Riwayat kesehatan berhasil dihapus.');
        $this->dispatch('refresh');
    }

    public function render()
    {
        $healthHistories = $this->warga->healthRecord->healthHistories()->latest('check_date')->paginate(5);
        return view('livewire.posyandu.health-records', compact('healthHistories'))
        ->extends('layouts.posyandu');
    }
}
