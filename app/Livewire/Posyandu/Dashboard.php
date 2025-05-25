<?php

namespace App\Livewire\Posyandu;

use App\Models\HealthRecord;
use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{
    public $search;
    public $menu;
    public $type;
    public $steps = HealthRecord::STEP;

    public function mount()
    {
        $this->menu = request()->get('menu');
        $this->type = request()->get('type');
    }
    
    public function search()
    {
        return redirect()->route('posyandu.teens.index',['search' => $this->search]);
    }

    public function selectMenu($menu)
    {
        $this->menu = $menu;
    }

    public function selectType($type)
    {
        $this->type = $type;
        if($this->menu == 'laporan'){
            return redirect()->route('posyandu.laporan', ['type' => $type]);
        }
    }

    public function resetMenu()
    {
        $this->menu = null;
        $this->type = null;
    }

    public function selectStep($step)
    {
        if($this->menu && $this->type && $step == 1){
            return redirect()->route('posyandu.teens.form', ['type' => $this->type]);
        }else{
            return redirect()->route('posyandu.pos', ['type' => $this->type, 'step' => $step]);
        }
    }

    public function render()
    {
        return view('livewire.posyandu.dashboard')
        ->extends('layouts.posyandu')
        ->section('content');
    }
}
