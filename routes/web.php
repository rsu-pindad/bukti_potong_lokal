<?php

use App\Http\Controllers\GajiController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PPH21Controller;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::controller(PegawaiController::class)->group(function () {
    Route::get('pegawai', 'index')->name('pegawai');

    Route::post('pegawai/store', 'store')->name('pegawai/store');

    Route::post('pegawai/import', 'import')->name('pegawai/import');

    Route::get('pegawai/export', 'export')->name('pegawai/export');
});

Route::controller(GajiController::class)->group(function () {
    Route::get('gaji', 'index')->name('gaji');
    Route::post('gaji/import', 'import')->name('gaji/import');
    Route::get('gaji/pph21', 'calculatePPH21')->name('gaji/pph21');

    Route::get('gaji/import-template', 'import_template')->name('gaji/import-template');
    Route::get('gaji/pph21', 'calculatePPH21')->name('gaji/pph21');
    Route::get('gaji/pph21/calculated', 'calculatedPPH21')->name('gaji/pph21/calculated');
});


Route::get('pph21', [PPH21Controller::class, 'calculate']);


Route::controller(GajiController::class)->group(function () {
    Route::get('gaji', 'index')->name('gaji');
});
