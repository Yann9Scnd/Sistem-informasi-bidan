<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\AnamnesaController;
use App\Http\Controllers\PemeriksaanController;

/*
|--------------------------------------------------------------------------
| Web Routes - PMB Bidan Klinik
|--------------------------------------------------------------------------
*/

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// ─── AUTH ROUTES ──────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ─── AUTHENTICATED ROUTES ─────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Pasien
    Route::prefix('pasien')->name('pasien.')->group(function () {
        Route::get('/',          [PasienController::class, 'index'])->name('index');
        Route::get('/create',    [PasienController::class, 'create'])->name('create');
        Route::post('/',         [PasienController::class, 'store'])->name('store');
        Route::get('/{pasien}',  [PasienController::class, 'show'])->name('show');
        Route::get('/{pasien}/edit', [PasienController::class, 'edit'])->name('edit');
        Route::put('/{pasien}',  [PasienController::class, 'update'])->name('update');
        Route::delete('/{pasien}', [PasienController::class, 'destroy'])->name('destroy');
    });

    // Anamnesa — stepper 3 langkah
    Route::prefix('anamnesa/{pasien}')->name('anamnesa.')->group(function () {
        Route::get('/step/1',  [AnamnesaController::class, 'step1'])->name('step1');
        Route::post('/step/1', [AnamnesaController::class, 'storeStep1'])->name('step1.store');
        Route::get('/step/2',  [AnamnesaController::class, 'step2'])->name('step2');
        Route::post('/step/2', [AnamnesaController::class, 'storeStep2'])->name('step2.store');
        Route::get('/step/3',  [AnamnesaController::class, 'step3'])->name('step3');
        Route::post('/step/3', [AnamnesaController::class, 'storeStep3'])->name('step3.store');
        Route::get('/selesai', [AnamnesaController::class, 'selesai'])->name('selesai');
    });

    // Pemeriksaan
    Route::resource('pemeriksaan', PemeriksaanController::class)->except(['create', 'edit']);
});