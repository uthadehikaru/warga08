<?php

namespace App\Livewire\Posyandu;

use App\Models\HealthRecord;
use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{
    public $search;
    public $menu;
    public $steps = HealthRecord::STEP;

    public function mount()
    {
        $this->menu = request()->get('menu');
    }
    
    public function search()
    {
        return redirect()->route('posyandu.teens.index',['search' => $this->search]);
    }

    public function selectMenu($menu)
    {
        $this->menu = $menu;
    }

    public function selectStep($step)
    {
        if($this->menu == 'posyandu_remaja' && $step == 1){
            return redirect()->route('posyandu.teens.form', ['type' => 'remaja']);
        }else{
            return redirect()->route('posyandu.pos', ['type' => 'remaja', 'step' => $step]);
        }
    }

    public function render()
    {
        return view('livewire.posyandu.dashboard')
        ->extends('layouts.posyandu')
        ->section('content');
    }
}
