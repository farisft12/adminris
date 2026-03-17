<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\EtalaseController;
use App\Http\Controllers\Admin\KodeRekeningController;
use App\Http\Controllers\Admin\PerpajakanController;
use App\Http\Controllers\Admin\PptkController;
use App\Http\Controllers\Admin\SubKegiatanController;
use App\Http\Controllers\Admin\YearController;
use Illuminate\Support\Facades\Route;

Route::get('/', AdminDashboardController::class)->name('admin.dashboard');

Route::resource('years', YearController::class)->except(['show'])->names('admin.years');
Route::put('sub-kegiatans/{subKegiatan}/anggaran-kode-rekening', [SubKegiatanController::class, 'updateAnggaranKodeRekening'])->name('admin.sub-kegiatans.anggaran-kode-rekening.update');
Route::resource('sub-kegiatans', SubKegiatanController::class)->except(['show'])->names('admin.sub-kegiatans');
Route::resource('kode-rekenings', KodeRekeningController::class)->except(['show'])->names('admin.kode-rekenings');
Route::post('kode-rekenings/{kode_rekening}/etalases', [EtalaseController::class, 'store'])->name('admin.etalases.store');
Route::delete('etalases/{etalase}', [EtalaseController::class, 'destroy'])->name('admin.etalases.destroy');
Route::resource('pptks', PptkController::class)->except(['show'])->names('admin.pptks');

Route::get('perpajakan', [PerpajakanController::class, 'edit'])->name('admin.perpajakan.edit');
Route::put('perpajakan', [PerpajakanController::class, 'update'])->name('admin.perpajakan.update');

Route::get('pptk-assign', [PptkController::class, 'assignIndex'])->name('admin.pptk.assign');
Route::post('pptk-assign', [PptkController::class, 'assignStore'])->name('admin.pptk.assign.store');
