<?php

namespace App\Livewire\Posyandu;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LoginForm extends Component
{
    public $username,$password;
    public $showPassword = false;

    public function mount()
    {
        if (Auth::check()) {
            return redirect(route('posyandu.dashboard'));
        }
    }

    public function togglePassword()
    {
        $this->showPassword = !$this->showPassword;
    }

    public function submit()
    {
        $this->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $credentials = [
            'email' => $this->username.'@warga08.test',
            'password' => $this->password,
        ];

        if (Auth::attempt($credentials)) {
            if (Auth::user()->role !== 'posyandu') {
                Auth::logout();
                $this->addError('error', 'Akses dibatasi hanya untuk kader posyandu');
                return;
            }
            session()->regenerate();
            return redirect(route('posyandu.teens.form'));
        }

        $this->addError('error', 'Email atau password yang Anda masukkan salah');
    }
    
    public function render()
    {
        return view('livewire.posyandu.login-form')
        ->extends('layouts.blank')
        ->section('main');
    }
}
