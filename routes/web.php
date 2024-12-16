<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\DashboardController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Admin only routes - ensure both auth and admin role
Route::middleware(['auth', 'verified'])->group(function(){
    // Dashboard access for all users
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Devices routes - index only for users, full access for admin
    Route::get('/devices', [DeviceController::class, 'index'])->name('devices.index');
    Route::patch('/users/{user}/toggle-active', [UserController::class, 'toggleActive'])
    ->name('users.toggle-active');

    // Admin only device management routes
    // Route::middleware(['admin'])->group(function() {
        Route::resource('devices', DeviceController::class)->except(['index']);
        Route::get('/damaged-devices', [DeviceController::class, 'damagedDevices'])->name('damaged-devices');
    
    // Rute baru untuk unduh laporan peminjaman
    Route::get('/borrowings/report', [BorrowingController::class, 'exportReport'])
    ->name('borrowings.report');

});

// Regular authenticated user routes - access for all authenticated users
Route::middleware(['auth', 'verified'])->group(function () {
    // Users
    Route::resource('users', UserController::class);
    Route::patch('/users/{user}/toggle-active', [UserController::class, 'toggleActive'])
        ->name('users.toggle-active');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('borrowings', BorrowingController::class);
    Route::patch('borrowings/{borrowing}/return', [BorrowingController::class, 'return'])
        ->name('borrowings.return');
});

require __DIR__.'/auth.php';
