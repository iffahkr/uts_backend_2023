<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// menggunakan group middleware untuk memprotect resource patient dengan token
Route::middleware('auth:sanctum')->group(function () {
    // membuat route untuk menampilkan semua data pasien
    Route::get('/patients', [PatientController::class, 'index']);

    // membuat route untuk memasukkan data pasien baru
    Route::post('/patients', [PatientController::class, 'store']);

    // membuat route untuk menampilkan detail data pasien
    Route::get('/patients/{id}', [PatientController::class, 'show']);

    // membuat route untuk meng-update data pasien
    Route::put('/patients/{id}', [PatientController::class, 'update']);

    // membuat route untuk menghapus data pasien
    Route::delete('/patients/{id}', [PatientController::class, 'destroy']);
});

// membuat route untuk mencari data pasien
Route::get('/patients/search/{name}', [PatientController::class, 'search']);

// membuat route untuk menampilkan data pasien yang positif covid
Route::get('/patients/status/positive', [PatientController::class, 'positive']);

// membuat route untuk menampilkan data pasien yang sembuh
Route::get('/patients/status/recovered', [PatientController::class,'recovered']);

// membuat route untuk menampilkan data pasien yang meninggal
Route::get('/patients/status/dead', [PatientController::class,'dead']);

// membuat authorization untuk mengakses resource pasien
Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);
