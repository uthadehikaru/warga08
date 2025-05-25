<?php

namespace App\Livewire\Posyandu;

use Livewire\Component;

class Laporan extends Component
{
    public $type;

    public function mount($type)
    {
        $this->type = $type;
    }

    public function render()
    {
        return view('livewire.posyandu.laporan')
        ->extends('layouts.posyandu')
        ->section('content');
    }
}
