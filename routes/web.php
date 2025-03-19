<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AppointmentController;

// Authentication Routes
require __DIR__ . '/auth.php';

// Public Route: Login Page
Route::redirect('/', '/login');

// Protected Routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // User Management
    // User Management (only accessible to super admin and HR Admin)
    Route::prefix('user')->name('user.')->middleware('can:view-users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}', [UserController::class, 'show'])->name('show');
        Route::get('/{user}/visitorLogs', [UserController::class, 'visitorLogs'])->name('visitorLogs');
        Route::patch('/{user}', [UserController::class, 'update'])->name('update');
        Route::put('/{user}/password', [UserController::class, 'updatePassword'])->name('password.update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    });



    // Visitor Management
    Route::prefix('visitors')->name('visitors.')->group(function () {
        Route::get('/', [VisitorController::class, 'index'])->name('index')->middleware('can:view-all-visitors');
        Route::get('/create', [VisitorController::class, 'create'])->name('create');
        Route::post('/', [VisitorController::class, 'store'])->name('store')->middleware('can:create-visitor');
        Route::get('/{visitor}/edit', [VisitorController::class, 'edit'])
            ->name('edit')
            ->middleware('can:update-visitor,visitor');
        Route::patch('/{visitor}', [VisitorController::class, 'update'])
            ->name('update')
            ->middleware('can:update-visitor,visitor');
        Route::get('/{visitor}/timeline', [VisitorController::class, 'timeline'])
            ->name('timeline')
            ->middleware('can:update-visitor,visitor');
    });


    // Appointment
    Route::get('/appointment', [AppointmentController::class, 'index'])->name('appointment');

    // Profile Management
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });
});
