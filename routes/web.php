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

// Public routes
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Routes for authenticated users
Route::middleware(['auth', 'verified'])->group(function () {
    // Admin dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // User dashboard
    Route::get('/dashboarduser', [DashboardController::class, 'userDashboard'])
        ->name('dashboarduser');

    // Devices - View only for regular users
    Route::get('/devices', [DeviceController::class, 'index'])->name('devices.index');
    Route::get('/devices/{device}', [DeviceController::class, 'show'])->name('devices.show');

    // Borrowings
    Route::resource('borrowings', BorrowingController::class)->except(['edit', 'update']);
    Route::patch('borrowings/{borrowing}/return', [BorrowingController::class, 'return'])
        ->name('borrowings.return');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin only routes
Route::middleware(['auth', 'verified'])->group(function () {
    // User Management
    Route::resource('users', UserController::class);
    Route::patch('/users/{user}/toggle-active', [UserController::class, 'toggleActive'])
        ->name('users.toggle-active');

    // Device Management
    Route::resource('devices', DeviceController::class)->except(['index', 'show']);
    Route::get('/damaged-devices', [DeviceController::class, 'damagedDevices'])
        ->name('damaged-devices');

    // Borrowing Management
    Route::get('/borrowings/report', [BorrowingController::class, 'exportReport'])
        ->name('borrowings.report');
    Route::post('/borrowings/{borrowing}/approve', [BorrowingController::class, 'approve'])
        ->name('borrowings.approve');
    Route::post('/borrowings/{borrowing}/reject', [BorrowingController::class, 'reject'])
        ->name('borrowings.reject');
});

require __DIR__.'/auth.php';
