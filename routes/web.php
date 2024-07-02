<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Daftar\CariController;
use App\Http\Controllers\Daftar\DaftarController;
use App\Http\Controllers\Employee\EmployeeController;
use App\Http\Controllers\GajiController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PPH21Controller;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

/*
 * |--------------------------------------------------------------------------
 * | Web Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register web routes for your application. These
 * | routes are loaded by the RouteServiceProvider and all of them will
 * | be assigned to the "web" middleware group. Make something great!
 * |
 */

Route::middleware(['guest'])->group(function () {
    Route::controller(LoginController::class)->group(function () {
        Route::get('/', 'index')->name('auth/login');
        Route::get('/login', 'index')->name('login');

        Route::post('authenticate', 'authenticate')->name('auth/authenticate');
    });

    Route::controller(DaftarController::class)->group(function () {
        Route::prefix('daftar')->group(function () {
            Route::get('/', 'index')->name('daftar-index');
            // Route::get('/', 'create')->name('daftar-create');
            Route::post('/', 'store')->name('daftar-store');
        });
    });
    Route::controller(CariController::class)->group(function () {
        Route::prefix('cari')->group(function () {
            Route::get('/', 'index')->name('cari-index');
            Route::post('/', 'search')->name('cari-npp');
        });
    });
});

Route::middleware(['auth'])->group(function () {
    Route::controller(EmployeeController::class)->group(function () {
        Route::get('employee', 'index')->name('employee');
        Route::patch('employee', 'edit')->name('employee-edit');
        Route::patch('employee/pribadi', 'editPribadi')->name('employee-edit-pribadi');
    });

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

        Route::post('gaji/pph21new', 'calculatePPH21New')->name('gaji/pph21new');

        Route::get('gaji/export', 'export')->name('gaji/export');
    });

    Route::controller(PPH21Controller::class)->group(function () {
        Route::get('pph21', 'index')->name('pph21');

        Route::get('pph21/detail/{pph21}', 'show')->name('pph21/detail');

        Route::get('pph21/export', 'export')->name('pph21/export');

        Route::get('pph21/export-detail/{id}', 'detailExport')->name('pph21/export-detail');

        Route::get('pph21/export-detail/{id}', 'detailExport')->name('pph21/export-detail');

        Route::delete('pph21/delete', 'destroy')->name('pph21/delete');
    });

    Route::get('auth/logout', [LogoutController::class, 'logout'])->name('auth/logout');
});
