<?php

use App\Http\Controllers\WorkspaceController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')
        ->name('dashboard');

    Route::view('profile', 'profile')
        ->name('profile');

    // Workspace Management
    Route::get('workspaces/create', [WorkspaceController::class, 'create'])
        ->name('workspaces.create');

    Route::get('workspaces/switch/{workspace}', [WorkspaceController::class, 'switch'])
        ->name('workspaces.switch');
});

require __DIR__.'/auth.php';
