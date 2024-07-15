<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\Ade\DebitController;
use App\Http\Controllers\Ade\TekananController;
use App\Http\Controllers\Ari\QualityController;
use App\Http\Controllers\AuthController;

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

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/loginProses', [AuthController::class, 'loginProses']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::middleware(['auth'])->group(function () {
    Route::get('/beranda', [BerandaController::class, 'beranda']);
    Route::get('/pengguna', [UserController::class, 'index']);
    Route::post('/tambah-pengguna', [UserController::class, 'store']);
    Route::post('/edit-pengguna/{id}', [UserController::class, 'update']);
    Route::delete('/hapus-pengguna/{id}', [UserController::class, 'delete']);
    
    
    Route::get('/debit', [DebitController::class, 'debit']);
    Route::get('/tambah-sensor-debit', [DebitController::class, 'tambahSensorDebit']);
    Route::post('/tambah-sensor-debit', [DebitController::class, 'tambahkanSensorDebit']);
    Route::get('/detail-sensor-debit/{id}', [DebitController::class, 'detailSensorDebit']);
    Route::get('/edit-sensor-debit/{id}', [DebitController::class, 'editSensorDebit']);
    Route::post('/edit-sensor-debit/{id}', [DebitController::class, 'updateSensorDebit']);
    Route::delete('/hapus-sensor-debit/{id}', [DebitController::class, 'hapusSensorDebit']);
    Route::post('export-data-sensor-debit/{id}', [DebitController::class, 'exportDataSensorDebit']);
    
    Route::get('/tekanan', [TekananController::class, 'tekanan']);
    Route::get('/tambah-sensor-tekanan', [TekananController::class, 'tambahSensorTekanan']);
    Route::post('/tambah-sensor-tekanan', [TekananController::class, 'tambahkanSensorTekanan']);
    Route::get('/detail-sensor-tekanan/{id}', [TekananController::class, 'detailSensorTekanan']);
    Route::get('/edit-sensor-tekanan/{id}', [TekananController::class, 'editSensorTekanan']);
    Route::post('/edit-sensor-tekanan/{id}', [TekananController::class, 'updateSensorTekanan']);
    Route::delete('/hapus-sensor-tekanan/{id}', [TekananController::class, 'hapusSensorTekanan']);
    Route::post('export-data-sensor-tekanan/{id}', [TekananController::class, 'exportDataSensorTekanan']);
    
    Route::get('/quality', [QualityController::class, 'turbi']);    
});

