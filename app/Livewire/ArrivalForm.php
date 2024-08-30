<?php

namespace App\Livewire;

use App\Models\Arrival;
use App\Models\User;
use App\Notifications\ArrivalCreated;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class ArrivalForm extends Component
{
    use WithFileUploads;

    public $step = 1;
    
    #[Validate('image|max:15024')] // 15MB Max
    public $ktp;
    
    #[Validate('image|max:15024')] // 15MB Max
    public $kk;
    
    #[Validate('image|max:15024')] // 15MB Max
    public $bukunikah;

    public $request = [];

    public function mount()
    {
        $this->request = [
            'rt' => '',
            'nik' => '',
            'name' => '',
            'phone' => '',
            'old_address' => '',
            'home_owner' => '',
            'home_address' => '',
            'is_married' => 'tidak',
        ];
    }

    private function valid()
    {
        $params = [ 
            'request.rt' => 'required|numeric',
            'request.nik' => 'required|numeric|digits:16',
            'request.name' => 'required|min:3|max:255',
            'request.phone' => 'required|numeric',
            'request.old_address' => 'required|min:3|max:255',
            'request.home_owner' => 'required|min:3|max:255',
            'request.home_address' => 'required|min:3|max:255',
            'request.is_married' => 'required|in:tidak,sudah',
            'request.foto_ktp' => 'nullable|image',
            'request.foto_kk' => 'nullable|image',
            'request.foto_buku_nikah' => 'nullable|image',
        ];

        if($this->step==2){
            $params = array_merge($params, [
                'ktp' => 'required_if:request.is_married,tidak|nullable|image|max:15024',
                'kk' => 'required|image|max:15024',
                'bukunikah' => 'required_if:request.is_married,sudah|nullable|image|max:15024',
            ]);
        }
        return $this->validate($params);
    }

    public function previous()
    {
        $this->resetErrorBag();
        $this->step--;
    }

    public function next()
    {
        $this->valid();
        $this->resetErrorBag();
        $this->step++;
    }

    public function submit()
    {
        $data = $this->valid();
        $arrival = $data['request'];
        unset($arrival['ktp'], $arrival['kk'], $arrival['bukunikah']);
        $arrival['is_married'] = $arrival['is_married']=='sudah';
        if($this->ktp)
            $arrival['foto_ktp'] = $this->ktp->store('ktp', 'public');
        if($this->kk)
            $arrival['foto_kk'] = $this->kk->store('kk', 'public');
        if($this->bukunikah)
            $arrival['foto_bukunikah'] = $this->bukunikah->store('bukunikah', 'public');
        
        $rt = User::rt()->where('rt',$arrival['rt'])->first();
        $arrival = Arrival::create($arrival);
        $rt->notify(new ArrivalCreated($arrival));
        $this->redirect(route('arrival.show',$arrival->nik));
    }

    public function render()
    {
        $data['rt'] = User::rt()->orderBy('rt')->get();
        return view('livewire.arrival.form', $data)
        ->extends('layouts.web');
    }
}
