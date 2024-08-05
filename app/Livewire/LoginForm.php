<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LoginForm extends Component
{

    public $email,$password;

    public function submit()
    {
        $credentials = [
            'email' => $this->email,
            'password' => $this->password,
        ];

        if (Auth::attempt($credentials)) {
            session()->regenerate();
            return redirect(route('pengurus.dashboard'));
        }

        $this->addError("error","Login Gagal");
    }

    public function render()
    {
        return view('livewire.login.form')
        ->extends('layouts.web');
    }
}
