<?php

namespace App\Livewire\Posyandu;

use App\Models\HealthHistory;
use App\Models\HealthRecord;
use Livewire\Component;
use Livewire\WithPagination;

class PosyanduPos extends Component
{
    use WithPagination;

    public $step;
    public $check_date;
    public $type;
    public $pos_name;

    public function mount($type, $step)
    {
        $this->check_date = now()->format('Y-m-d');
        $this->type = $type;
        $this->step = $step;
        $this->pos_name = HealthRecord::STEP[$this->step];
    }

    public function check($nik, $id)
    {
        return redirect()->route('posyandu.teens.records.form', ['nik' => $nik, 'id' => $id]);
    }

    public function render()
    {
        $healthHistory = HealthHistory::with('healthRecord.user')->whereDate('check_date', $this->check_date)
        ->where('step', $this->step-1)->oldest()->paginate(10);
        return view('livewire.posyandu.posyandu-pos')
        ->extends('layouts.posyandu')
        ->with('healthHistory', $healthHistory);
    }
}
