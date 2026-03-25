<?php

use App\Http\Controllers\AdministrasiController;
use App\Http\Controllers\Api\EtalaseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

require __DIR__.'/auth.php';

Route::middleware('guest')->group(function () {
    Route::get('auth/google', [\App\Http\Controllers\Auth\GoogleController::class, 'redirectToGoogle'])->name('google.login');
    Route::get('auth/google/callback', [\App\Http\Controllers\Auth\GoogleController::class, 'handleGoogleCallback'])->name('google.callback');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [\App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password.update');

    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/api/etalases', [EtalaseController::class, 'index'])->name('api.etalases.index');
    Route::get('/api/administrasi/next-no', [\App\Http\Controllers\Api\AdministrasiNoController::class, 'nextNo'])->name('api.administrasi.next-no');

    Route::get('sub-kegiatan/{subKegiatan}', [\App\Http\Controllers\SubKegiatanController::class, 'show'])->name('sub-kegiatan.show');
    Route::get('sub-kegiatan/{subKegiatan}/kode-rekenings', [\App\Http\Controllers\SubKegiatanKodeRekeningController::class, 'index'])->name('sub-kegiatan.kode-rekenings.index');
    Route::get('sub-kegiatan/{subKegiatan}/npd', [\App\Http\Controllers\SubKegiatanController::class, 'npd'])->name('sub-kegiatan.npd');
    Route::post('sub-kegiatan/{subKegiatan}/npd', [\App\Http\Controllers\SubKegiatanController::class, 'storeNpd'])->name('sub-kegiatan.npd.store');
    Route::get('sub-kegiatan/{subKegiatan}/npd/{npd}', [\App\Http\Controllers\SubKegiatanController::class, 'showNpd'])->name('sub-kegiatan.npd.show');
    Route::get('sub-kegiatan/{subKegiatan}/npd/{npd}/print', [\App\Http\Controllers\SubKegiatanController::class, 'printNpd'])->name('sub-kegiatan.npd.print');
    Route::get('sub-kegiatan/{subKegiatan}/npd/{npd}/edit', [\App\Http\Controllers\SubKegiatanController::class, 'editNpd'])->name('sub-kegiatan.npd.edit');
    Route::put('sub-kegiatan/{subKegiatan}/npd/{npd}', [\App\Http\Controllers\SubKegiatanController::class, 'updateNpd'])->name('sub-kegiatan.npd.update');

    Route::resource('administrasi', AdministrasiController::class);

    Route::get('administrasi/{administrasi}/kwitansi', [PdfController::class, 'kwitansi'])
        ->name('administrasi.kwitansi');
    Route::get('administrasi/{administrasi}/nota-persetujuan', [PdfController::class, 'notaPersetujuan'])
        ->name('administrasi.nota-persetujuan');

    Route::middleware('role:admin')->prefix('admin')->group(base_path('routes/admin.php'));
});
