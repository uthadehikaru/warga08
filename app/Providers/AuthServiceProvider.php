<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Arrival;
use App\Models\Request;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('list rt', function (User $user) {
            return $user->role=='rw';
        });
        Gate::define('edit request', function (User $user, Request $request) {
            return $user->role=='rw' || ($user->role=='rt' && $request->rt==$user->rt);
        });
        Gate::define('approve rt', function (User $user, Request $request) {
            return $user->role=='rt' && $request->rt==$user->rt && $request->status=='new';
        });
        Gate::define('approve rw', function (User $user, Request $request) {
            return $user->role=='rw' && $request->status=='approve_rt';
        });
        Gate::define('cancel', function (User $user, Request $request) {
            return $user->role=='rt' && $request->status=='new' && $request->rt==$user->rt;
        });
        Gate::define('approve arrival', function (User $user, Arrival $arrival) {
            return !$arrival->is_valid && ($user->role=='rw' || ($user->role=='rt' && $arrival->rt==$user->rt));
        });
    }
}
