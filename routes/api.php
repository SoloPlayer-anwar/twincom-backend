<?php

use App\Http\Controllers\API\AbsensiController;
use App\Http\Controllers\API\CabangController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\KeteranganController;
use App\Http\Controllers\API\OptionsController;
use App\Http\Controllers\API\PengaturanController;
use App\Http\Controllers\API\ProsuderController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\WaktuController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [UserController::class, 'Register']);
Route::post('login', [UserController::class, 'Login']);
Route::post('updateUser/{id}', [UserController::class, 'updateUser']);
Route::post('deleteUser/{id}', [UserController::class, 'deleteUser']);
Route::get('getUser', [UserController::class, 'userList']);


Route::post('createCategory', [CategoryController::class, 'createCategory']);
Route::post('updateCategory/{id}', [CategoryController::class, 'updateCategory']);
Route::post('deleteCategory/{id}', [CategoryController::class, 'deleteCategory']);
Route::get('getCategory', [CategoryController::class, 'getCategory']);


// Pengaturan Absen
Route::post('createPengaturan', [PengaturanController::class, 'createPengaturan']);
Route::post('updatePengaturan/{id}', [PengaturanController::class, 'updatePengaturan']);
Route::post('deletePengaturan/{id}', [PengaturanController::class, 'deletePengaturan']);
Route::get('getPengaturan', [PengaturanController::class, 'getPengaturan']);

// ABSENSI
Route::post('createAbsensi', [AbsensiController::class, 'createAbsensi']);
Route::post('deleteAbsensi/{id}', [AbsensiController::class, 'deleteAbsensi']);
Route::post('uploadPhoto/{id}', [AbsensiController::class, 'uploadPhoto']);
Route::get('getAbsensi', [AbsensiController::class, 'getAbsensi']);

// Cabang
Route::post('createCabang', [CabangController::class, 'createCabang']);
Route::post('updateCabang/{id}', [CabangController::class, 'updateCabang']);
Route::post('deleteCabang/{id}', [CabangController::class, 'deleteCabang']);
Route::get('getCabang', [CabangController::class, 'getCabang']);

// Waktu
Route::post('createWaktu', [WaktuController::class, 'createWaktu']);
Route::post('deleteWaktu/{id}', [WaktuController::class, 'deleteWaktu']);
Route::get('getWaktu', [WaktuController::class, 'getWaktu']);

// Keterangan
Route::post('createKeterangan', [KeteranganController::class, 'createKeterangan']);
Route::get('getKeterangan', [KeteranganController::class, 'getKeterangan']);

// Options
Route::post('createOptions', [OptionsController::class, 'createOptions']);
Route::get('getOptions', [OptionsController::class, 'getOptions']);
Route::post('updateOptions/{id}', [OptionsController::class, 'updateOptions']);
Route::post('deleteOptions/{id}', [OptionsController::class, 'deleteOptions']);

// PROSUDER
Route::post('createProsuder', [ProsuderController::class, 'createProsuder']);
Route::get('getProsuder', [ProsuderController::class, 'getProsuder']);
Route::post('updateProsuder/{id}', [ProsuderController::class, 'updateProsuder']);
Route::post('deleteProsuder/{id}', [ProsuderController::class, 'deleteProsuder']);
Route::post('pdfGenerate/{id}', [ProsuderController::class, 'pdfGenerate']);

