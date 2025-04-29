<?php

use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\DashboardController;

// Authentication Routes
require __DIR__ . '/auth.php';

// Public Route: Login Page
Route::redirect('/', '/login');

// Protected Routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/search', [SearchController::class, 'dashboardSearch'])->name('dashboardSearch');
    // routes/web.php
    Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit')->middleware('can:access-settings');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update')->middleware('can:access-settings');
    Route::delete('/settings/locations/{location}', [SettingController::class, 'destroyLocation'])
        ->name('settings.locations.destroy')
        ->middleware('can:access-settings');
    Route::post('/settings/locations', [\App\Http\Controllers\SettingController::class, 'storeLocation'])
        ->name('settings.locations.store')
        ->middleware('can:access-settings');

    // User Management (only accessible to super admin and HR Admin)
    Route::prefix('user')->name('user.')->middleware('can:view-users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::get('/{user}/visitorLogs', [UserController::class, 'visitorLogs'])->name('visitorLogs');
        Route::patch('/{user}', [UserController::class, 'update'])->name('update');
        Route::get('/users/search', [UserController::class, 'search'])->name('search');
        Route::put('/{user}/password', [UserController::class, 'updatePassword'])->name('password.update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    });

// Let any user view their own profile (or an admin see others)
// via the dedicated `view-profile` gate
    Route::get('/user/{user}', [UserController::class, 'show'])
        ->name('user.show')
        ->middleware('can:view-profile,user');



    // Visitor Management
    Route::prefix('visitors')->name('visitors.')->group(function () {
        // GET routes first
        Route::get('/', [VisitorController::class, 'index'])->name('index');
        Route::get('/create', [VisitorController::class, 'create'])->name('create');
        Route::get('/scan', [VisitorController::class, 'scan'])->name('scan'); // Changed from '/visitor/scan'
        Route::get('/{visitor}/edit', [VisitorController::class, 'edit'])->name('edit');
        Route::get('/{visitor}/qr', [VisitorController::class, 'show'])->name('show');
        Route::get('/{visitor}/timeline', [VisitorController::class, 'timeline'])->name('timeline');
        Route::get('/users/search', [VisitorController::class, 'search'])->name('search');

        // POST/PATCH routes after
        Route::post('/', [VisitorController::class, 'store'])->name('store');
        Route::post('/scan-process', [VisitorController::class, 'processScan'])->name('scan-process');
        Route::patch('/{visitor}', [VisitorController::class, 'update'])->name('update');
        Route::patch('/{visitor}/check-in', [VisitorController::class, 'checkIn'])->name('checkin');
        Route::patch('/{visitor}/approve', [VisitorController::class, 'approve'])->name('approve');
        Route::patch('/{visitor}/deny', [VisitorController::class, 'deny'])->name('deny');
        Route::patch('/{visitor}/checkout', [VisitorController::class, 'checkout'])->name('checkout');
        Route::patch('/{visitor}/auto-checkin', [VisitorController::class, 'autoCheckIn'])->name('autoCheckin');
    });


    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index')->middleware('can:view-inventory');
    Route::get('/inventory/search', [InventoryController::class, 'search'])->name('inventory.search');
    Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
    Route::get('/{inventory}/edit', [InventoryController::class, 'edit'])
        ->name('inventory.edit');
    Route::get('/inventory/{inventory}', [InventoryController::class, 'show'])->name('inventory.show');
    Route::patch('inventory/{inventory}', [InventoryController::class, 'update'])->name('inventory.update');
    Route::get('inventory/{inventory}/timeline', [InventoryController::class, 'timeline'])
        ->name('inventory.timeline');




    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');




    // Profile Management
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });
});
