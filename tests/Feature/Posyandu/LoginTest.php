<?php

use App\Livewire\Posyandu\LoginForm;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;

it('has login page', function () {
    $this->get($this->subdomainUrl('posyandu', '/login'))->assertStatus(200);
});

it('can access login page', function () {
    $response = $this->get($this->subdomainUrl('posyandu', '/login'));
    $response->assertStatus(200)
    ->assertSee('Posyandu ILP Melati');
});

it('can login as posyandu', function () {
    User::factory()->create([
        'email' => 'posyandu1@warga08.test',
        'password' => Hash::make('posyandu123'),
        'role' => 'posyandu',
    ]);
    Livewire::test(LoginForm::class)
        ->set('email', 'posyandu1@warga08.test')
        ->set('password', 'posyandu123')
        ->call('submit')
        ->assertHasNoErrors();
});

it('cant login as other', function () {
    User::factory()->create([
        'email' => 'warga1@warga08.test',
        'password' => Hash::make('warga123'),
        'role' => 'warga',
    ]);
    Livewire::test(LoginForm::class)
        ->set('email', 'warga1@warga08.test')
        ->set('password', 'warga123')
        ->call('submit')
        ->assertHasErrors('error');
});
