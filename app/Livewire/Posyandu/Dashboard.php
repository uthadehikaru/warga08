<?php

namespace App\Livewire\Posyandu;

use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{
    public $search;

    public function search()
    {
        return redirect()->route('posyandu.teens.index',['search' => $this->search]);
    }

    public function render()
    {
        return view('livewire.posyandu.dashboard')
        ->extends('layouts.posyandu')
        ->section('content');
    }
}
