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


    //manajemen->user
    Route::get('/indexUser', [App\Http\Controllers\ManajemenController::class, 'indexUser'])->name('index.User');
    Route::get('/getUser', [App\Http\Controllers\ManajemenController::class, 'getUser'])->name('get.User');
    Route::get('/createUser', [App\Http\Controllers\ManajemenController::class, 'createUser'])->name('create.User');
    Route::post('/storeUser', [App\Http\Controllers\ManajemenController::class, 'storeUser'])->name('store.User');
    Route::get('/editUser/{id}', [App\Http\Controllers\ManajemenController::class, 'editUser'])->name('edit.User');
    Route::put('/updateUser/{id}', [App\Http\Controllers\ManajemenController::class, 'updateUser'])->name('update.User');
    Route::delete('/deleteUser/{id}', [App\Http\Controllers\ManajemenController::class, 'deleteUser'])->name('delete.User');

    //manajemen->sifat surat
    Route::get('/indexSifatSurat', [App\Http\Controllers\ManajemenController::class, 'indexSifatSurat'])->name('index.SifatSurat');
    Route::get('/getSifatSurat', [App\Http\Controllers\ManajemenController::class, 'getSifatSurat'])->name('get.SifatSurat');
    Route::get('/createSifatSurat', [App\Http\Controllers\ManajemenController::class, 'createSifatSurat'])->name('create.SifatSurat');
    Route::post('/storeSifatSurat', [App\Http\Controllers\ManajemenController::class, 'storeSifatSurat'])->name('store.SifatSurat');
    Route::get('/editSifatSurat/{id}', [App\Http\Controllers\ManajemenController::class, 'editSifatSurat'])->name('edit.SifatSurat');
    Route::put('/updateSifatSurat/{id}', [App\Http\Controllers\ManajemenController::class, 'updateSifatSurat'])->name('update.SifatSurat');
    Route::delete('/deleteSifatSurat/{id}', [App\Http\Controllers\ManajemenController::class, 'deleteSifatSurat'])->name('delete.SifatSurat');

    //manajemen->sifat surat
    Route::get('/indexInstansi', [App\Http\Controllers\ManajemenController::class, 'indexInstansi'])->name('index.Instansi');
    Route::get('/getInstansi', [App\Http\Controllers\ManajemenController::class, 'getInstansi'])->name('get.Instansi');
    Route::get('/createInstansi', [App\Http\Controllers\ManajemenController::class, 'createInstansi'])->name('create.Instansi');
    Route::post('/storeInstansi', [App\Http\Controllers\ManajemenController::class, 'storeInstansi'])->name('store.Instansi');
    Route::get('/editInstansi/{id}', [App\Http\Controllers\ManajemenController::class, 'editInstansi'])->name('edit.Instansi');
    Route::put('/updateInstansi/{id}', [App\Http\Controllers\ManajemenController::class, 'updateInstansi'])->name('update.Instansi');
    Route::delete('/deleteInstansi/{id}', [App\Http\Controllers\ManajemenController::class, 'deleteInstansi'])->name('delete.Instansi');


});
