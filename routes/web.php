<?php

use App\Http\Controllers\Admin\DosenController;
use App\Http\Controllers\Admin\JadwalController as AdminJadwalController;
use App\Http\Controllers\Admin\KrsController as AdminKrsController;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Admin\MataKuliahController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Mahasiswa\JadwalController as MahasiswaJadwalController;
use App\Http\Controllers\Mahasiswa\KrsController as MahasiswaKrsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('profil')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('show');
        Route::patch('/nama', [ProfileController::class, 'updateName'])->name('name.update');
        Route::patch('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    });
});

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {
        Route::resource('dosen', DosenController::class)->except('show');
        Route::resource('mahasiswa', MahasiswaController::class)->except('show');
        Route::resource('mata-kuliah', MataKuliahController::class)
            ->parameters(['mata-kuliah' => 'mataKuliah'])
            ->except('show');
        Route::resource('jadwal', AdminJadwalController::class)->except('show');
        Route::get('krs', [AdminKrsController::class, 'index'])->name('krs.index');
        Route::get('krs/tambah', [AdminKrsController::class, 'create'])->name('krs.create');
        Route::post('krs', [AdminKrsController::class, 'store'])->name('krs.store');
        Route::delete('krs/{krs}', [AdminKrsController::class, 'destroy'])->name('krs.destroy');
    });

Route::prefix('mahasiswa')
    ->name('mahasiswa.')
    ->middleware(['auth', 'role:mahasiswa'])
    ->group(function () {
        Route::get('jadwal', [MahasiswaJadwalController::class, 'index'])->name('jadwal.index');
        Route::get('krs', [MahasiswaKrsController::class, 'index'])->name('krs.index');
        Route::get('krs/ambil', [MahasiswaKrsController::class, 'create'])->name('krs.create');
        Route::post('krs', [MahasiswaKrsController::class, 'store'])->name('krs.store');
        Route::delete('krs/{krs}', [MahasiswaKrsController::class, 'destroy'])->name('krs.destroy');
    });
