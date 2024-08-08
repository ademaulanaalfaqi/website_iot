<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Ari\PhController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\Ade\DebitController;
use App\Http\Controllers\Ari\TurbiController;
use App\Http\Controllers\Ade\TekananController;
use App\Http\Controllers\Jupi\PelangganController;


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

    //arii
    Route::get('/kekeruhan', [TurbiController::class, 'turbi']);
    Route::post('/tambah-sensor-kekeruhan', [TurbiController::class, 'menambahkanSensorTurbi']);
    Route::get('/detail-sensor-kekeruhan/{turbi}', [TurbiController::class, 'detailSensorTurbi']);
    Route::put('/edit-sensor-kekeruhan/{turbi}', [TurbiController::class, 'updateSensorTurbi']);
    Route::delete('/hapus-sensor-kekeruhan/{turbi}', [TurbiController::class, 'hapusSensorTurbi']);
    Route::get('/download-today-report-turbi/{turbi}', [TurbiController::class, 'downloadTodayReportTurbi']);
    // Route::get('/download/reports/turbi', [TurbiController::class, 'downloadReportsTurbi'])->name('download.reportsTurbi');

    //Jupi
    // route::get('/detail-sensor-meteran/{id}', [MeteranController::class, 'detailSensorMeteran']);
    Route::get('/meteran', [PelangganController::class, 'meteran']);
    Route::get('/meter-data/{id}', [PelangganController::class, 'chartMeter']);
    Route::get('relay', [PelangganController::class, 'relay']);
    Route::get('/pelanggan', [PelangganController::class, 'index']);
    Route::get('/tambah-pelanggan', [PelangganController::class, 'create']);
    Route::post('/tambah-pelanggan', [PelangganController::class, 'store']);
    Route::get('/detail-pelanggan/{id}', [PelangganController::class, 'detail']);
    Route::get('/edit-pelanggan/{id}', [PelangganController::class, 'edit']);
    Route::post('/edit-pelanggan/{id}', [PelangganController::class, 'update']);
    Route::get('/hapus-data-pelanggan/{id}', [PelangganController::class, 'destroy']);
    Route::post('export-data-sensor-pelanggan/{id}', [PelangganController::class, 'exportDataPelanggan']);
});


Route::get('/ph', [PhController::class, 'ph']);
Route::post('/tambah-sensor-ph', [PhController::class, 'menambahkanSensorPh']);
Route::get('/detail-sensor-ph/{ph}', [PhController::class, 'detailSensorPh']);
Route::put('/edit-sensor-ph/{ph}', [PhController::class, 'updateSensorPh']);
Route::delete('/hapus-sensor-ph/{ph}', [PhController::class, 'hapusSensorPh']);
Route::get('/download-today-report-ph/{ph}', [PhController::class, 'downloadTodayReportPh']);
// Route::get('/download/reports/ph', [PhController::class, 'downloadReportsPh'])->name('download.reportsPh');
