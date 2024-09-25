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
use App\Http\Controllers\Pajak\EpinKaryawanController;
use App\Http\Controllers\Pajak\PajakController;
use App\Http\Controllers\Pajak\PajakPublishedController;
use App\Http\Controllers\Personalia\KaryawanController;
use App\Http\Controllers\Personalia\PegawaiController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

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
            Route::post('/', 'store')->name('daftar-store');
            Route::post('/send-otp', 'sendOtp')->name('send-otp');
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
        Route::get('/versi', function () {
            return phpinfo();
        });

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

        Route::group(['prefix' => 'pajak_manager'], function () {
            Cache::flush();
            \UniSharp\LaravelFilemanager\Lfm::routes();
        });
    });

    Route::group(['middleware' => 'role:personalia|pajak'], function () {
        Route::controller(KaryawanController::class)->group(function () {
            Route::get('karyawan', 'index')->name('karyawan');
            Route::post('karyawan/store', 'store')->name('karyawan-store');
            Route::post('karyawan/import', 'import')->name('karyawan-import');
            Route::get('karyawan/export', 'export')->name('karyawan-export');
            Route::get('karyawan/template', 'template')->name('karyawan-template');
            Route::get('karyawan/{id}/edit', 'edit')->name('karyawan-edit');
            Route::patch('karyawan/{id}/edit', 'update')->name('karyawan-update');
            // Route::post('karyawan/soft', 'softDel')->name('karyawan-soft-delete');
        });

        Route::group(['middleware' => 'role:pajak'], function () {
            Route::controller(EpinKaryawanController::class)->group(function () {
                Route::get('karyawan/epin/{id}/edit', 'edit')->name('karyawan-epin-edit');
                Route::patch('karyawan/epin/{id}/edit', 'update')->name('karyawan-epin-update');
                Route::post('karyawan/epin/import', 'import')->name('karyawan-epin-import');
                Route::get('karyawan/epin/export', 'export')->name('karyawan-epin-export');
                Route::get('karyawan/epin/template', 'template')->name('karyawan-epin-template');
            });

            Route::controller(PegawaiController::class)->group(function () {
                Route::post('pegawai/store', 'store')->name('pegawai/store');

                Route::get('pegawai/export', 'export')->name('pegawai/export');

                Route::delete('pegawai/delete/{id}', 'destroy')->name('pegawai/delete');
            });

            Route::group(['prefix' => 'pajak_file'], function () {
                Route::controller(PajakController::class)->group(function () {
                    Route::get('/', 'index')->name('pajak-index');
                    Route::get('/target/{filename}', 'publish')->name('pajak-publish');
                    Route::post('/target', 'published')->name('pajak-published');
                    Route::post('/unpublish', 'unPublish')->name('pajak-unpublish');
                    Route::post('/upload-bukti-potong', 'uploadBuktiPotong')->name('upload-bukti-potong');
                    Route::post('/remove-bukti-potong', 'removeBuktiPotong')->name('remove-bukti-potong');
                });
            });

            Route::group(['prefix' => 'pajak_publised_file'], function () {
                Route::controller(PajakPublishedController::class)->group(function () {
                    Route::get('/', 'index')->name('pajak-published-index');
                    Route::post('/cari-data-pajak', 'cariDataPajak')->name('cari-data-pajak');
                    Route::get('/file-data-pajak/{file?}{cari?}', 'fileDataPajak')->name('published-file-data-pajak');
                    Route::get('/published-cari-file-pajak/{folder}/{filename}', 'publishedCariFilePajak')->name('published-cari-file-pajak');
                });
            });
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
