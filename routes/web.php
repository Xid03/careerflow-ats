<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReminderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/applications/export/csv', [ApplicationController::class, 'exportCsv'])
        ->name('applications.export');
    Route::resource('applications', ApplicationController::class);
    Route::post('/applications/{application}/interviews', [InterviewController::class, 'store'])
        ->name('applications.interviews.store');
    Route::get('/interviews/{interview}/edit', [InterviewController::class, 'edit'])
        ->name('interviews.edit');
    Route::put('/interviews/{interview}', [InterviewController::class, 'update'])
        ->name('interviews.update');
    Route::delete('/interviews/{interview}', [InterviewController::class, 'destroy'])
        ->name('interviews.destroy');
    Route::post('/applications/{application}/reminders', [ReminderController::class, 'store'])
        ->name('applications.reminders.store');
    Route::patch('/reminders/{reminder}/complete', [ReminderController::class, 'complete'])
        ->name('reminders.complete');
    Route::delete('/reminders/{reminder}', [ReminderController::class, 'destroy'])
        ->name('reminders.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
