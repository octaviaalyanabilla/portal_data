<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DataUtamaController;
use App\Http\Controllers\JenisDataController;
use App\Http\Controllers\TahunDataController;
use App\Http\Controllers\InputDataController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\CekDataController;
use Illuminate\Http\Request;

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

Auth::routes();

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/', [CekDataController::class, 'index']);
Route::get('getJenisCekData/{id}', [CekDataController::class, 'getJenis']);
Route::get('getKategoriCekData/{id}', [CekDataController::class, 'getKategori']);

Route::resource('/user', UserController::class);

Route::resource('/data_utama', DataUtamaController::class);

Route::resource('/jenis_data', JenisDataController::class);

Route::resource('/tahun_data', TahunDataController::class);

Route::resource('/input_data', InputDataController::class);

Route::get('/laporan/data', [LaporanController::class, 'data']);
Route::get('/laporan/data/pdf', [LaporanController::class, 'dataPdf']);

Route::get('getJenis/{id}', [DataUtamaController::class, 'getJenis']);

Route::get('getKategori/{id}', [JenisDataController::class, 'getKategori']);