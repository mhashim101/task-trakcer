<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskAttachmentController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskHistoryController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TeamLeadController;
use App\Http\Controllers\TeamMemberController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;





Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->isTeamLead()) {
        return redirect()->route('team-lead.dashboard');
    } else {
        return redirect()->route('team-member.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::resource('teams', TeamController::class);
    Route::get('/member-analytics', [AdminController::class, 'memberAnalytics'])->name('admin.member-analytics');
    Route::get('/analytics/generate-report', [AdminController::class, 'generateReport'])->name('admin.generate-report');
    Route::get('/analytics/member-performance', [AnalyticsController::class, 'memberPerformance'])->name('admin.analytics.member-performance');
    Route::post('/analytics/generate-report', [AnalyticsController::class, 'generateReport'])->name('admin.analytics.generate-report');

    //user Management
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    Route::put('/admin/users/{user}/update-role', [UserController::class, 'updateRole'])->name('admin.users.updateRole');

});

// Team Lead Routes
Route::prefix('team-lead')->middleware(['auth', 'role:team_lead'])->group(function () {
    Route::get('/dashboard', [TeamLeadController::class, 'dashboard'])->name('team-lead.dashboard');
    // Route::resource('tasks', TaskController::class)->except(['index', 'show']);
    Route::get('/analytics/member-performance', [AnalyticsController::class, 'memberPerformance'])->name('analytics.member-performance');
    Route::post('/analytics/generate-report', [AnalyticsController::class, 'generateReport'])->name('team-lead.analytics.generate-report');
    Route::get('/member-analytics', [TeamLeadController::class, 'memberAnalytics'])->name('team-lead.member-analytics');
    Route::get('/analytics/generate-report', [TeamLeadController::class, 'generateReport'])->name('team-lead.generate-report');
});

// Team Member Routes
Route::prefix('team-member')->middleware(['auth', 'role:team_member'])->group(function () {
    Route::get('/dashboard', [TeamMemberController::class, 'dashboard'])->name('team-member.dashboard');
    Route::post('/tasks/{task}/update-status', [TaskController::class, 'updateStatus'])
        ->name('tasks.update-status');
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('team-member.tasks-show');
    Route::get('/tasks/{task}/upload', [TaskController::class, 'showUploadForm'])->name('tasks.upload');


});

Route::prefix('analytics')->middleware(['auth', 'role:admin,team_lead'])->group(function () {
    Route::post('/download-report', [AnalyticsController::class, 'downloadReport'])->name('analytics.download-report');
    Route::post('/generate-report', [AnalyticsController::class, 'generateReport']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/task-history', [TaskHistoryController::class, 'index'])->name('task-history.index');
    Route::get('/tasks/{task}/history', [TaskHistoryController::class, 'taskHistory'])->name('tasks.history');
    Route::get('/my-task-history', [TaskHistoryController::class, 'userHistory'])->name('my-task-history');
    Route::patch('/tasks/{task}/complete', [TaskController::class, 'complete'])
        ->name('tasks.complete');
    Route::resource('tasks', TaskController::class);
    Route::delete('/attachments/{attachment}', [TaskAttachmentController::class, 'destroy'])
        ->name('attachments.destroy');
    Route::get('/attachments/{attachment}', [TaskAttachmentController::class, 'show'])
    ->name('attachments.show');
});


require __DIR__.'/auth.php';
