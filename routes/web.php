<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DataAbsenController;
use App\Http\Controllers\MenuAdminController;

use App\Models\Presensi;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// auth
Route::get('login', [AuthController::class, 'index'])->name('auth.index');
Route::post('login', [AuthController::class, 'login'])->name('auth.login');
Route::get('daftar', [AuthController::class, 'create'])->name('auth.daftar');
Route::post('daftar', [AuthController::class, 'store'])->name('auth.store');
Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');

//Route::get ('pegawai', [PegawaiController::class, 'pegawai'])->name('admin.pegawai');

// home
Route::get('/', function () {
    $count  = \Illuminate\Support\Facades\DB::table('users')->count();
    $presensi = '0';
    $hadir  = '0';
    $izin   = '0';
    $telat  = '0';
    $alpa   = '0';
    $usr_id = \Illuminate\Support\Facades\Auth::user()->id;

    return view('index')->with([
        'title' => 'Admin Absensi Dosen',
        'count' => $count,
        'hadir' => $hadir,
        'izin' => $izin,
        'telat' => $telat,
        'alpa' => $alpa,
        'usr_id' => $usr_id,
        'presensi' => $presensi,
    ]);
})->name('menu.home')->middleware('auth');



    //Route Pegawi
    Route::get ('/pegawai',                         [MenuAdminController::class, 'pegawai'])->name('pegawai');
    Route::post('pegawai',                          [MenuAdminController::class, 'createPegawai'])->name('pegawai.createPegawai');
    Route::post('pegawai/update/{id}',              [MenuAdminController::class, 'updatePegawai'])->name('pegawai.updatePegawai');
    Route::get ('pegawai/delete/{id}',              [MenuAdminController::class, 'deletePegawai'])->name('pegawai.deletePegawai');
    Route::post ('pegawai/passwordupdate/{id}',     [MenuAdminController::class, 'updatePegawaiPassword'])->name('pegawai.updatePegawaiPassword');


    //Route Rekap Data
    Route::get('dataPresensi',                      [DataAbsenController::class, 'dataPresensi'])->name('dataPresensi');
    Route::post('editDataPresensi/update/{id}',     [DataAbsenController::class, 'editDataPresensi'])->name('presensi.editDataPresensi');
    Route::get('deleteDataPresensi/delete/{id}',    [DataAbsenController::class, 'deleteDataPresensi'])->name('presensi.deleteDataPresensi');

