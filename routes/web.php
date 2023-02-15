<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

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

// Route::resource('mahasiswa', AdminController::class);

Route::get('mahasiswa', [AdminController::class, 'index']);
Route::get('mahasiswa/create', [AdminController::class, 'create']);
Route::post('mahasiswa', [AdminController::class, 'store']);
Route::delete('mahasiswa/{mahasiswa}', [AdminController::class, 'destroy']);
Route::GET('mahasiswa/{mahasiswa}/edit', [AdminController::class, 'edit']);
Route::post('mahasiswa/{id}', [AdminController::class, 'update']);

Route::get('mahasiswa/kota/{id}', [AdminController::class, 'select_kota']);
Route::get('mahasiswa/laporan', [AdminController::class, 'laporan']);

Route::get('/', function () {
    return redirect('/mahasiswa');
});
