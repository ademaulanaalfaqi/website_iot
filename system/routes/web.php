<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Ade\DebitController;
use App\Http\Controllers\Ari\TurbiController;
use App\Http\Controllers\Ade\TekananController;
use App\Http\Controllers\Ari\PhController;

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

//arii
Route::get('/kekeruhan', [TurbiController::class, 'turbi']);
Route::post('/tambah-sensor-kekeruhan', [TurbiController::class, 'menambahkanSensorTurbi']);
Route::get('/detail-sensor-kekeruhan/{turbi}', [TurbiController::class, 'detailSensorTurbi']);
Route::put('/edit-sensor-kekeruhan/{turbi}', [TurbiController::class, 'updateSensorTurbi']);
Route::delete('/hapus-sensor-kekeruhan/{turbi}', [TurbiController::class, 'hapusSensorTurbi']);
Route::get('/download-today-report-turbi/{turbi}', [TurbiController::class, 'downloadTodayReportTurbi']);
// Route::get('/download/reports/turbi', [TurbiController::class, 'downloadReportsTurbi'])->name('download.reportsTurbi');


Route::get('/ph', [PhController::class, 'ph']);
Route::post('/tambah-sensor-ph', [PhController::class, 'menambahkanSensorPh']);
Route::get('/detail-sensor-ph/{ph}', [PhController::class, 'detailSensorPh']);
Route::put('/edit-sensor-ph/{ph}', [PhController::class, 'updateSensorPh']);
Route::delete('/hapus-sensor-ph/{ph}', [PhController::class, 'hapusSensorPh']);
Route::get('/download-today-report-ph/{ph}', [PhController::class, 'downloadTodayReportPh']);
// Route::get('/download/reports/ph', [PhController::class, 'downloadReportsPh'])->name('download.reportsPh');
