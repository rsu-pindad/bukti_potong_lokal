<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
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

Route::controller(LoginController::class)->middleware('guest')->group(function () {
    Route::get('/', 'index')->name('auth/login');

    Route::post('authenticate', 'authenticate')->name('auth/authenticate');
});

Route::middleware(['auth'])->group(function () {
    Route::controller(PegawaiController::class)->group(function () {
        Route::get('pegawai', 'index')->name('pegawai');

        Route::post('pegawai/store', 'store')->name('pegawai/store');

        Route::post('pegawai/import', 'import')->name('pegawai/import');

        Route::get('pegawai/export', 'export')->name('pegawai/export');

        Route::delete('pegawai/delete/{id}', 'destroy')->name('pegawai/delete');
    });

    Route::controller(GajiController::class)->group(function () {
        Route::get('gaji', 'index')->name('gaji');

        Route::get('gaji/detail/{gaji}', 'show')->name('gaji/detail');

        Route::delete('gaji/delete/{gaji}', 'destroy')->name('gaji/delete');

        Route::post('gaji/import', 'import')->name('gaji/import');

        Route::post('gaji/store', 'store')->name('gaji/store');

        Route::post('gaji/pph21', 'calculatePPH21')->name('gaji/pph21');

        Route::get('gaji/export', 'export')->name('gaji/export');
    });

    Route::controller(PPH21Controller::class)->group(function () {
        Route::get('pph21', 'index')->name('pph21');

        Route::get('pph21/detail/{pph21}', 'show')->name('pph21/detail');

        Route::get('pph21/export', 'export')->name('pph21/export');

        Route::get('pph21/export-detail/{id}', 'detailExport')->name('pph21/export-detail');

        Route::delete('pph21/delete', 'destroy')->name('pph21/delete');
    });

    Route::get('auth/logout', [LogoutController::class, 'logout'])->name('auth/logout');
});
