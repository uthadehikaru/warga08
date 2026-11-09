<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;

class RecordUserLogin
{
    public function handle(Login $event): void
    {
        $user = $event->user;
        $user->timestamps = false;
        $user->forceFill([
            'last_login_at' => now(),
        ])->saveQuietly();
    }
}
