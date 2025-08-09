<?php

namespace App\Livewire\Posyandu;

use App\Models\HealthHistory;
use Livewire\Component;
use Livewire\WithPagination;

class Summary extends Component
{
    use WithPagination;
    
    public $type;
    public $check_date;

    public function mount($type)
    {
        $this->type = $type;
        $this->check_date = now()->format('Y-m-d');
    }

    public function render()
    {
        $healthHistory = HealthHistory::with('healthRecord.user')->whereDate('check_date', $this->check_date)
        ->oldest()->paginate(10);
        return view('livewire.posyandu.summary')
        ->extends('layouts.posyandu')
        ->with('healthHistory', $healthHistory);
    }
}
