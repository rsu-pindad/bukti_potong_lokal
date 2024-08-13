<?php

use App\Http\Controllers\Admin\AksesController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Daftar\CariController;
use App\Http\Controllers\Daftar\DaftarController;
use App\Http\Controllers\Employee\EmployeeController;
use App\Http\Controllers\Employee\ParserController;
use App\Http\Controllers\GajiController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PPH21Controller;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Pajak\PajakController;
use App\Http\Controllers\Pajak\KaryawanController;
use Illuminate\Support\Facades\Cache;

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
    Route::group(['middleware' => 'role:super-admin'], function () {
    Route::controller(AksesController::class)->group(function () {
        Route::get('akses', 'index')->name('akses');
        Route::prefix('akses/role')->group(function () {
            Route::get('/{id}', 'showRole')->name('akses-role-show');
            Route::post('/{id}', 'assignRole')->name('akses-role-assign');
        });
        });

        Route::controller(PermissionController::class)->group(function () {
            Route::get('permission', 'index')->name('permission');
            Route::post('permission', 'store')->name('permission-store');
            Route::delete('permission', 'destroy')->name('permission-destroy');
            Route::get('permission/edit/{id}', 'edit')->name('permission-edit');
            Route::patch('permission/edit/{id}', 'update')->name('permission-update');
        });

        Route::controller(RoleController::class)->group(function () {
            Route::get('role', 'index')->name('role');
            Route::post('role', 'store')->name('role-store');
            Route::delete('role', 'destroy')->name('role-destroy');
            Route::get('role/edit/{id}', 'edit')->name('role-edit');
            Route::patch('role/edit/{id}', 'update')->name('role-update');
            Route::prefix('role/assign')->group(function () {
                Route::get('/{id}', 'showPermission')->name('role-show-permission');
                Route::post('/{id}', 'assignPermission')->name('role-assign-permission');
            });
        });
    });

    Route::group(['middleware' => 'role:pajak'], function () {

        Route::get('/versi', function(){
            return phpinfo();
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

        Route::group(['prefix' => 'pajak_manager'], function () {
            Cache::flush();
            \UniSharp\LaravelFilemanager\Lfm::routes();
        });

        Route::group(['prefix' => 'pajak_file'], function(){
            Route::controller(PajakController::class)->group(function(){
                Route::get('/', 'index')->name('pajak-index');
                Route::get('/target/{filename}', 'publish')->name('pajak-publish');
                Route::post('/target', 'published')->name('pajak-published');
                Route::post('/unpublish', 'unPublish')->name('pajak-unpublish');
            });
        });

        Route::controller(KaryawanController::class)->group(function () {
            Route::get('karyawan', 'index')->name('karyawan');
            // Route::patch('pegawai', 'edit')->name('pegawai-edit');
        });
    });

    Route::group(['middleware' => 'role:employee'], function () {
        Route::controller(EmployeeController::class)->group(function () {
            Route::get('employee', 'index')->name('employee');
            Route::patch('employee', 'edit')->name('employee-edit');
            Route::patch('employee/pribadi', 'editPribadi')->name('employee-edit-pribadi');
            // Route::get('employee/pajak/', 'lihatDokumen')->name('pajak')->middleware('signed');
        });

        Route::controller(ParserController::class)->group(function () {
            Route::group(['prefix' => 'employee/pajak/parser'], function () {
                Route::post('/bulan', 'pdfParser')->name('pajak-parser')->middleware('signed');
                Route::post('/', 'pdfParserSearch')->name('pajak-parser-search')->middleware('signed');
            });
        });
    });

    Route::get('auth/logout', [LogoutController::class, 'logout'])->name('logout');
});
