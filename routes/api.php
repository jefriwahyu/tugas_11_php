<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Karyawan;

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
Route::get('/getData', [Karyawan::class, 'getData']);
Route::post('/simpanData', [Karyawan::class, 'store']);
Route::post('/ubahData', [Karyawan::class, 'update']);
Route::get('/hapusData/{id}', [Karyawan::class, 'hapus']);
Route::get('/bacaData/{id}', [Karyawan::class, 'bacaData']);