<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ManageKasController;
use App\Http\Controllers\ManageUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RiwayatKasController;
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
Route::permanentRedirect('/', '/login');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('dashboard', DashboardController::class)->middleware('can:Dashboard');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('can:Dashboard');
    Route::resource('manage-user', ManageUserController::class)->middleware('can:Manage User');
    Route::resource('manage-kas', ManageKasController::class)->middleware('can:Manage Kas');
    Route::resource('riwayat-kas', RiwayatKasController::class)->middleware('can:Riwayat Kas');
});

require __DIR__ . '/auth.php';
