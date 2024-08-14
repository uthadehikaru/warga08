<?php

namespace App\Livewire;

use App\Models\Request;
use App\Models\User;
use App\Notifications\RequestCreated;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Illuminate\Support\Str;

class RequestForm extends Component
{
    public $request = [];

    public $step = 1;

    public function mount()
    {
        $this->request = [
            'rt' => '',
            'email' => '',
            'nik' => '',
            'name' => '',
            'phone' => '',
            'email' => '',
            'address' => '',
            'gender' => 'p',
            'work' => '',
            'religion' => '',
            'birth_place' => '',
            'birth_date' => '',
            'description' => '',
        ];

        $user = Auth::user();
        if($user){
            $this->request['rt'] = $user->rt;
        }
    }

    public function back()
    {
        $this->resetErrorBag();
        $this->step--;
    }

    public function next()
    {
        $this->validate([ 
            'request.rt' => 'required|numeric',
            'request.nik' => 'required|numeric|digits:16',
            'request.name' => 'required|min:3|max:255',
            'request.email' => 'required|email',
            'request.phone' => 'required|numeric',
            'request.gender' => 'required|in:p,w',
            'request.birth_place' => 'required|min:3|max:255',
            'request.birth_date' => 'required|date',
            'request.address' => 'required|min:3|max:255',
            'request.work' => 'required|min:3|max:255',
            'request.description' => 'required',
        ]);

        $this->step++;
    }

    public function submit()
    {

        DB::transaction(function() {
            $data = $this->request;
            $rt = User::rt()->where('rt',$data['rt'])->first();
            $rw = User::rw()->first();

            $warga = User::where('nik', $data['nik'])->first();
            if(!$warga){
                $warga = User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'nik' => $data['nik'],
                    'rt' => $data['rt'],
                    'address' => $data['address'],
                    'phone' => $data['phone'],
                    'work' => $data['work'],
                    'birth_date' => $data['birth_date'],
                    'birth_place' => $data['birth_place'],
                    'religion' => $data['religion'],
                    'password' => Hash::make($data['nik']),
                    'role' => 'warga',
                ]);
            }else{
                $warga->update([
                    'name' => $data['name'],
                    'rt' => $data['rt'],
                    'address' => $data['address'],
                    'phone' => $data['phone'],
                    'work' => $data['work'],
                    'birth_date' => $data['birth_date'],
                    'birth_place' => $data['birth_place'],
                    'religion' => $data['religion'],
                ]);
            }

            $data['code'] = strtoupper(Str::random(5));
            $data['rt_name'] = strtoupper($rt->name);
            $data['rw_name'] = strtoupper($rw->name);
            $data['user_id'] = $warga->id;
            $request = Request::create($data);
            $rt->notify(new RequestCreated($request));
            $this->redirect(route('request.show',$request->code));
        });
    }

    public function render()
    {
        $data['rt'] = User::rt()->orderBy('rt')->get();
        $data['religions'] = User::religion();
        return view('livewire.request.form', $data)
        ->extends('layouts.web');
    }
}
