<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerkasController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KategoriDetailController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TahunKategoriDetailController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KartografiController;
use App\Http\Controllers\ArsipInputController;
use Illuminate\Support\Facades\Storage;

Route::get('/tes-drive', function () { Storage::disk('google')->put('test.txt', 'Hello Google Drive!'); return '✅ Google Drive CONNECTED'; });


// Route Authentication
Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'proses_login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Route Protected Area
Route::middleware('auth')->group(function () {
    // Route Dashboard (tampilan)
    Route::get('/dashboard', [KategoriController::class, 'dashboard'])->name('dashboard');

    // mengarah ke kategori detail
    Route::get('/kategori/{kategori}', [KategoriController::class, 'show'])->name('show');

    // API Routes untuk AJAX
    Route::prefix('api/kategori')->name('api.kategori.')->group(function () {
        Route::get('/', [KategoriController::class, 'index'])->name('index');
        Route::get('/stats', [KategoriController::class, 'getStats'])->name('stats');
        Route::post('/', [KategoriController::class, 'store'])->name('store');
        Route::get('/{kategori}/edit', [KategoriController::class, 'edit'])->name('edit');
        Route::put('/{kategori}', [KategoriController::class, 'update'])->name('update');
        Route::delete('/{kategori}', [KategoriController::class, 'destroy'])->name('destroy');
    });

    // Route Kategori Detail (tampilan)
    Route::get('/kategori/{kategori}/detail', [KategoriDetailController::class, 'index'])->name('kategori.detail.index');

    // API Routes untuk Kategori Detail AJAX
    Route::prefix('api/kategori/{kategori}/detail')->name('api.kategori.detail.')->group(function () {
        Route::get('/', [KategoriDetailController::class, 'getDetails'])->name('index');
        Route::get('/stats', [KategoriDetailController::class, 'getStats'])->name('stats');
        Route::post('/', [KategoriDetailController::class, 'store'])->name('store');
        Route::get('/{detail}/edit', [KategoriDetailController::class, 'edit'])->name('edit');
        Route::put('/{detail}', [KategoriDetailController::class, 'update'])->name('update');
        Route::delete('/{detail}', [KategoriDetailController::class, 'destroy'])->name('destroy');
    });

    // Route Tahun Kategori Detail (tampilan)
    Route::get('/kategori/{kategori}/detail/{detail}/tahun', [TahunKategoriDetailController::class, 'index'])->name('kategori.detail.tahun.index');

    // API Routes untuk Tahun Kategori Detail AJAX
    Route::prefix('api/kategori/{kategori}/detail/{detail}/tahun')->name('api.kategori.detail.tahun.')->group(function () {
        Route::get('/', [TahunKategoriDetailController::class, 'getTahunDetails'])->name('index');
        Route::get('/stats', [TahunKategoriDetailController::class, 'getStats'])->name('stats');
        Route::post('/', [TahunKategoriDetailController::class, 'store'])->name('store');
        Route::get('/{tahun}/edit', [TahunKategoriDetailController::class, 'edit'])->name('edit');
        Route::put('/{tahun}', [TahunKategoriDetailController::class, 'update'])->name('update');
        Route::delete('/{tahun}', [TahunKategoriDetailController::class, 'destroy'])->name('destroy');
    });

    // Route Berkas (tampilan)
    Route::get('/kategori/{kategori}/detail/{detail}/tahun/{tahun}/berkas', [BerkasController::class, 'index'])->name('kategori.detail.tahun.berkas.index');

    // API Routes untuk Berkas AJAX
    Route::prefix('api/kategori/{kategori}/detail/{detail}/tahun/{tahun}/berkas')->name('api.kategori.detail.tahun.berkas.')->group(function () {
        Route::get('/', [BerkasController::class, 'getBerkas'])->name('index');
        Route::get('/stats', [BerkasController::class, 'getStats'])->name('stats');
        Route::post('/', [BerkasController::class, 'store'])->name('store');
        Route::get('/{berkas}', [BerkasController::class, 'show'])->name('show');
        Route::get('/{berkas}/edit', [BerkasController::class, 'edit'])->name('edit');
        Route::post('/{berkas}', [BerkasController::class, 'update'])->name('update'); // Using POST for file upload
        Route::delete('/{berkas}', [BerkasController::class, 'destroy'])->name('destroy');
        Route::get('/{berkas}/download', [BerkasController::class, 'download'])->name('download');
    });

    // Route Arsip Kartografi (type: direct)
    Route::get('/kategori/{kategori}/kartografi', [KartografiController::class, 'index'])
        ->name('kategori.kartografi.index');

    // API Routes Kartografi
    Route::prefix('api/kategori/{kategori}/kartografi')->name('api.kategori.kartografi.')->group(function () {
        Route::get('/', [KartografiController::class, 'getKartografi'])->name('index');
        Route::get('/stats', [KartografiController::class, 'getStats'])->name('stats');
        Route::post('/', [KartografiController::class, 'store'])->name('store');
        Route::get('/{kartografi}/edit', [KartografiController::class, 'edit'])->name('edit');
        Route::post('/{kartografi}', [KartografiController::class, 'update'])->name('update');
        Route::delete('/{kartografi}', [KartografiController::class, 'destroy'])->name('destroy');
        Route::get('/{kartografi}/download', [KartografiController::class, 'download'])->name('download');
    });

    // Route Arsip Input (type: input — Usul Musnah, Vital, Permanen)
    Route::get('/kategori/{kategori}/detail/{detail}/tahun/{tahun}/input', [ArsipInputController::class, 'index'])
        ->name('kategori.detail.tahun.input.index');

    // API Routes Arsip Input
    Route::prefix('api/kategori/{kategori}/detail/{detail}/tahun/{tahun}/input')->name('api.kategori.detail.tahun.input.')->group(function () {
        Route::get('/', [ArsipInputController::class, 'getInputs'])->name('index');
        Route::get('/stats', [ArsipInputController::class, 'getStats'])->name('stats');
        Route::post('/', [ArsipInputController::class, 'store'])->name('store');
        Route::get('/{input}/edit', [ArsipInputController::class, 'edit'])->name('edit');
        Route::put('/{input}', [ArsipInputController::class, 'update'])->name('update');
        Route::delete('/{input}', [ArsipInputController::class, 'destroy'])->name('destroy');
    });

    // Route Role
    Route::middleware('permission:role.create')->group(function () {
        Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
        Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
        Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
        Route::delete('/roles/{id}', [RoleController::class, 'delete'])->name('roles.delete');
        Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
        Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    });

    
    // Route User
    Route::middleware('permission:user.create')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [UserController::class, 'delete'])->name('users.delete')->middleware('permission:user.read'); 
    });
});
