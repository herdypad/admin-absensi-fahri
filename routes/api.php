<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileStorageController;
use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\ApiUserController;
use App\Http\Controllers\Api\ApiPresensiController;

Route::get('file/{FILE}', [FileStorageController::class, 'DownloadFile']);
Route::post('login', [ApiAuthController::class, 'login']);
Route::post('register', [ApiAuthController::class, 'register']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [ApiAuthController::class, 'logout']);
});


Route::post('clockin', [ApiUserController::class, 'absen']);
Route::post('updatefoto', [ApiUserController::class, 'ajukanFoto']);


Route::get('dataabsen/{id}', [ApiPresensiController::class, 'dataPresensiApi']);



