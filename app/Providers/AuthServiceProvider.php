<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [];

    public function boot(): void
    {
        Gate::define('manage-school', fn ($user) => $user->isAdmin());
        Gate::define('teach', fn ($user) => $user->isAdmin() || $user->isTeacher());
        Gate::define('view-own-data', fn ($user, $ownerId) => $user->id === $ownerId || $user->isAdmin());
    }
}
