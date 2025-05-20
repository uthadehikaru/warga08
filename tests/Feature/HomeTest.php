<?php

use Database\Seeders\UserSeeder;

beforeEach(function () {
    $this->seed(UserSeeder::class);
});

it('has a welcome page', function () {
    $this->get('/')->assertStatus(200);
});
