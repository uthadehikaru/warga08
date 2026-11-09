<?php

use App\Livewire\LoginForm;
use App\Livewire\Posyandu\LoginForm as PosyanduLoginForm;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;

it('records the login time when a user signs in', function () {
    $user = User::factory()->create([
        'email' => 'rt@warga08.test',
        'role' => 'rt',
    ]);

    Livewire::test(LoginForm::class)
        ->set('email', 'rt@warga08.test')
        ->set('password', 'password')
        ->call('submit')
        ->assertHasNoErrors();

    expect($user->fresh()->last_login_at)->not->toBeNull();
});

it('leaves the login time empty when sign in fails', function () {
    $user = User::factory()->create([
        'email' => 'rt@warga08.test',
        'role' => 'rt',
    ]);

    Livewire::test(LoginForm::class)
        ->set('email', 'rt@warga08.test')
        ->set('password', 'salah')
        ->call('submit')
        ->assertHasErrors('error');

    expect($user->fresh()->last_login_at)->toBeNull();
});

it('records the login time for a posyandu kader', function () {
    $user = User::factory()->create([
        'email' => 'kader1@warga08.test',
        'password' => Hash::make('posyandu123'),
        'role' => 'posyandu',
    ]);

    Livewire::test(PosyanduLoginForm::class)
        ->set('username', 'kader1')
        ->set('password', 'posyandu123')
        ->call('submit')
        ->assertHasNoErrors();

    expect($user->fresh()->last_login_at)->not->toBeNull();
});
