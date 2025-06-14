<?php

namespace App\Livewire\Posyandu;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class TeenRecords extends Component
{
    use WithPagination;

    public $search = '';

    public function mount()
    {
        $this->search = request()->get('search');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function clearSearch()
    {
        $this->search = '';
        $this->resetPage();
    }

    public function render()
    {
        $teens = User::warga()->where(function($query){
            $query->where('name','like','%'.$this->search.'%')->orWhere('nik','like','%'.$this->search.'%');
        })->paginate(12);
        return view('livewire.posyandu.teen-records',[
            'teens' => $teens,
        ])
        ->extends('layouts.posyandu');
    }
}
