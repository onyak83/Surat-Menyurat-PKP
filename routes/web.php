<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['guest']], function () {
    Route::get('/', [App\Http\Controllers\AuthController::class, 'viewLogin'])->name('login');
    Route::post('/login', [App\Http\Controllers\AuthController::class, 'authenticate'])->name('authenticate');
});

Route::group(['middleware' => ['auth']], function () {
    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
});

Route::group(['middleware' => ['auth', 'role:1']], function () {
    Route::get('/surat', [App\Http\Controllers\DashboardController::class, 'indexSurat'])->name('index.Surat');
    Route::get('/getsurat', [App\Http\Controllers\DashboardController::class, 'getSurat'])->name('get.Surat');
    Route::get('/createsurat', [App\Http\Controllers\DashboardController::class, 'createSurat'])->name('create.Surat');
    Route::post('/storesurat', [App\Http\Controllers\DashboardController::class, 'storeSurat'])->name('store.Surat');
    Route::get('/editsurat/{id}', [App\Http\Controllers\DashboardController::class, 'editSurat'])->name('edit.Surat');
    Route::put('/updatesurat/{id}', [App\Http\Controllers\DashboardController::class, 'updateSurat'])->name('update.Surat');
    Route::delete('/deletesurat/{id}', [App\Http\Controllers\DashboardController::class, 'deleteSurat'])->name('delete.Surat');

    Route::get('/agendasuratmasuk', [App\Http\Controllers\DashboardController::class, 'indexAgendaSuratMasuk'])->name('index.AgendaSuratMasuk');
    Route::get('/getagendasuratmasuk', [App\Http\Controllers\DashboardController::class, 'getAgendaSuratMasuk'])->name('get.AgendaSuratMasuk');
    Route::post('/downloadagendasuratmasuk', [App\Http\Controllers\DashboardController::class, 'downloadAgendaSuratMasuk'])->name('download.AgendaSuratMasuk');

    Route::get('/ekpedisisuratkeluar', [App\Http\Controllers\DashboardController::class, 'indexEkpedisiSuratKeluar'])->name('index.EkpedisiSuratKeluar');
    Route::get('/getekpedisisuratkeluar', [App\Http\Controllers\DashboardController::class, 'getEkpedisiSuratKeluar'])->name('get.EkpedisiSuratKeluar');
    Route::post('/downloadekpedisisuratkeluar', [App\Http\Controllers\DashboardController::class, 'downloadEkpedisiSuratKeluar'])->name('download.EkpedisiSuratKeluar');
});
