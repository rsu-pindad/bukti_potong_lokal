<?php

use App\Http\Controllers\Admin\{AksesController, PermissionController, RoleController};
use App\Http\Controllers\Auth\{LoginController, LogoutController};
use App\Http\Controllers\Daftar\{CariController, DaftarController};
use App\Http\Controllers\Pajak\PajakEpinEmployeeController;
use App\Http\Controllers\Pajak\PajakFileController;
use App\Http\Controllers\Pajak\PajakPublishedController;
use App\Http\Controllers\Personal\ParserController;
use App\Http\Controllers\Personal\PersonalController;
use App\Http\Controllers\Personalia\PersonaliaEmployeeController;
use App\Http\Controllers\Tables\PajakTablesEmployeeController;
use App\Http\Controllers\Tables\PersonaliaTablesEmployeeController;
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
        Route::get('/', 'index')->name('auth-login');
        Route::get('/login', 'index')->name('login');
        Route::post('/authenticate', 'authenticate')->name('auth-authenticate');
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
        // Route::get('/versi', function () {
        //     return phpinfo();
        // });

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
            Illuminate\Support\Facades\Cache::flush();
            \UniSharp\LaravelFilemanager\Lfm::routes();
        });
    });

    // Personalia-Employee
    Route::group(['prefix' => 'personalia-employee'], function () {
        // Api Datatable
        Route::get('/', [PersonaliaTablesEmployeeController::class, 'index'])->name('personalia-employee-index');

        // Normal Controller
        Route::get('/edit/{id}', [PersonaliaEmployeeController::class,       'edit'])->name('personalia-employee-edit');
        Route::patch('/edit/{id}', [PersonaliaEmployeeController::class,     'update'])->name('personalia-employee-update');
        Route::delete('/destroy/{id}', [PersonaliaEmployeeController::class, 'destroy'])->name('personalia-employee-destroy');
        Route::post('/import', [PersonaliaEmployeeController::class,         'import'])->name('personalia-employee-import');
        Route::get('/export', [PersonaliaEmployeeController::class,          'export'])->name('personalia-employee-export');
        Route::get('/template', [PersonaliaEmployeeController::class,        'template'])->name('personalia-employee-template');
    })->middleware('role:personalia');

    // Pajak
    Route::group(['middleware' => 'role:pajak'], function () {
        // Pajak-Employee
        Route::group(['prefix' => 'pajak-employee'], function () {
            // Api Datatable
            Route::get('/', [PajakTablesEmployeeController::class, 'index'])->name('pajak-employee-index');

            // Epin Employee
            Route::group(['prefix' => 'epin'], function () {
                Route::get('/edit/{id}', [PajakEpinEmployeeController::class,   'edit'])->name('pajak-employee-epin-edit');
                Route::patch('/edit/{id}', [PajakEpinEmployeeController::class, 'update'])->name('pajak-employee-epin-update');
                Route::post('/import', [PajakEpinEmployeeController::class,     'import'])->name('pajak-employee-epin-import');
                Route::get('/export', [PajakEpinEmployeeController::class,      'export'])->name('pajak-employee-epin-export');
                Route::get('/template', [PajakEpinEmployeeController::class,    'template'])->name('pajak-employee-epin-template');
            });
        });

        Route::group(['prefix' => 'pajak-file'], function () {
            Route::get('/', [PajakFileController::class,                                'index'])->name('pajak-file-index');
            Route::get('/target/{filename}', [PajakFileController::class,               'publish'])->name('pajak-file-publish');
            Route::post('/target', [PajakFileController::class,                         'published'])->name('pajak-file-published');
            Route::post('/unpublish', [PajakFileController::class,                      'unPublish'])->name('pajak-file-unpublish');
            Route::post('/pajak-file-upload-bukti-potong', [PajakFileController::class, 'uploadBuktiPotong'])->name('pajak-file-upload-bukti-potong');
            Route::post('/pajak-file-remove-bukti-potong', [PajakFileController::class, 'removeBuktiPotong'])->name('pajak-file-remove-bukti-potong');
        });

        Route::group(['prefix' => 'pajak-publised-file'], function () {
            // Api Datatable
            Route::get('/', [PajakPublishedController::class, 'index'])->name('pajak-published-file-index');

            Route::post('/cari-data-pajak', [PajakPublishedController::class,                    'cariDataPajak'])->name('pajak-published-file-cari-data-pajak');
            Route::get('/file-data-pajak/{file?}{cari?}', [PajakPublishedController::class,      'fileDataPajak'])->name('pajak-published-file-data-pajak');
            Route::get('/cari-file-pajak/{folder}/{filename}', [PajakPublishedController::class, 'publishedCariFilePajak'])->name('pajak-published-cari-file-pajak');
        });
    });

    Route::group(['middleware' => 'role:employee', 'prefix' => 'personal'], function () {
        // Route::controller(EmployeeController::class)->group(function () {
        Route::get('/', [PersonalController::class,       'index'])->name('personal');
        Route::put('/edit', [PersonalController::class,   'edit'])->name('personal-edited');
        Route::patch('/edit', [PersonalController::class, 'update'])->name('personal-update');
        // Route::get('employee/pajak/', 'lihatDokumen')->name('pajak')->middleware('signed');
        // });

        Route::group(['prefix' => 'personal-parser'], function () {
            Route::post('/bulan', [ParserController::class, 'pdfParser'])
                ->name('personal-parser-bp')
                ->middleware('signed');
            Route::post('/search', [ParserController::class, 'pdfParserSearch'])
                ->name('personal-parser-bp-search')
                ->middleware('signed');
        });
    });

    Route::get('auth/logout', [LogoutController::class, 'logout'])->name('logout');
});
