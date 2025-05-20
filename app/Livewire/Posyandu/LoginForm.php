<?php

namespace App\Livewire\Posyandu;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LoginForm extends Component
{
    public $email,$password;
    public $showPassword = false;

    public function togglePassword()
    {
        $this->showPassword = !$this->showPassword;
    }

    public function submit()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = [
            'email' => $this->email,
            'password' => $this->password,
        ];

        if (Auth::attempt($credentials)) {
            session()->regenerate();
            return redirect(route('posyandu.dashboard'));
        }

        $this->addError('error', 'Email atau password yang Anda masukkan salah');
    }
    
    public function render()
    {
        return view('livewire.posyandu.login-form')
        ->extends('layouts.posyandu');
    }
}
