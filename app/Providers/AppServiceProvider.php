<?php

namespace App\Providers;

use App\Notifications\Channels\WhatsappChannel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();

        $this->app->make(ChannelManager::class)->extend('whatsapp', function ($app) {
            return new WhatsappChannel();
        });
    }
}
