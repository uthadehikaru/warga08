<?php

namespace App\Livewire;

use App\Models\Request;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;

class RequestForm extends Component
{
    public $request = [];

    public function mount()
    {
        $this->request = [
            'rt' => '',
            'nik' => '',
            'name' => '',
            'phone' => '',
            'email' => '',
            'address' => '',
            'description' => '',
        ];
    }

    public function submit()
    {
        $data = $this->request;
        $data['code'] = strtoupper(Str::random(5));
        $request = Request::create($data);
        $this->redirect(route('request.show',$request->code));
    }

    public function render()
    {
        $data['rt'] = User::rt()->orderBy('rt')->get();
        return view('livewire.request.form', $data)
        ->extends('layouts.web');
    }
}
