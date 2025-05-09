<?php

namespace App\Providers;

use App\Models\TaskAttachment;
use App\Policies\TaskAttachmentPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        TaskAttachment::class => TaskAttachmentPolicy::class,
    ];

    public function register(): void
    {

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Define additional gates if needed
        Gate::define('delete-attachment', function ($user, $attachment) {
            return $user->id === $attachment->user_id ||
                   $user->hasRole('admin') ||
                   $user->hasRole('team_lead');
        });

        Gate::define('admin', function ($user) {
            return $user->role_id == 1;
        });
    }
}
