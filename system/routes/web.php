<?php

use App\Http\Controllers\Ade\DebitController;
use App\Http\Controllers\Ade\TekananController;
use App\Http\Controllers\Ari\QualityController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/debit', [DebitController::class, 'debit']);
Route::get('/tambah-sensor-debit', [DebitController::class, 'tambahSensorDebit']);
Route::post('/tambah-sensor-debit', [DebitController::class, 'tambahkanSensorDebit']);
Route::get('/detail-sensor-debit/{id}', [DebitController::class, 'detailSensorDebit']);
Route::get('/edit-sensor-debit/{id}', [DebitController::class, 'editSensorDebit']);
Route::post('/edit-sensor-debit/{id}', [DebitController::class, 'updateSensorDebit']);
Route::delete('/hapus-sensor-debit/{id}', [DebitController::class, 'hapusSensorDebit']);

Route::get('/tekanan', [TekananController::class, 'tekanan']);
Route::get('/tambah-sensor-tekanan', [TekananController::class, 'tambahSensorTekanan']);
Route::post('/tambah-sensor-tekanan', [TekananController::class, 'tambahkanSensorTekanan']);
Route::get('/detail-sensor-tekanan/{id}', [TekananController::class, 'detailSensorTekanan']);
Route::get('/edit-sensor-tekanan/{id}', [TekananController::class, 'editSensorTekanan']);
Route::post('/edit-sensor-tekanan/{id}', [TekananController::class, 'updateSensorTekanan']);
Route::delete('/hapus-sensor-tekanan/{id}', [TekananController::class, 'hapusSensorTekanan']);

Route::get('/quality', [QualityController::class, 'quality']);

