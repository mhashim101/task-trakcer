<?php

namespace App\Providers;

use App\Models\AttendanceRecord;
use App\Models\Task;
use App\Models\TaskAttachment;
use App\Observers\TaskObserver;
use App\Policies\AttendancePolicy;
use App\Policies\TaskAttachmentPolicy;
use Illuminate\Support\Facades\Gate;
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
        Task::observe(TaskObserver::class);
        Gate::policy(TaskAttachment::class, TaskAttachmentPolicy::class);
        Gate::policy(AttendanceRecord::class, AttendancePolicy::class);
    }
}
