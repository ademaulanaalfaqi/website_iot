<?php


use App\Http\Controllers\Ari\PhController;
use App\Http\Controllers\Ari\TurbiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\Ade\DebitController;
use App\Http\Controllers\Ade\TekananController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


//arii
Route::get('/data_turbi', [TurbiController::class, 'apiTurbi']);
Route::get('/data_last_turbi/{id}', [TurbiController::class, 'apiLastTurbi']);
Route::get('/data_turbi_chart/{id}', [TurbiController::class, 'apiChartTurbi']);
Route::get('/data_ph', [PhController::class, 'apiPh']);
Route::get('/data_last_ph/{id}', [PhController::class, 'apiLastPh']);
Route::get('/data_ph_chart/{id}', [PhController::class, 'apiChartPh']);


Route::get('/data-para-sensor', [BerandaController::class, 'getDataParaSensor']);

//ade
Route::get('/data_debit', [DebitController::class, 'apiDebit']);
Route::get('/flow_data/{id}', [DebitController::class, 'apiChartFlow']);
Route::get('/flow_text/{id}', [DebitController::class, 'apiTextFlow']);
Route::get('/data_tekanan', [TekananController::class, 'apiTekanan']);
Route::get('/pressure_data/{id}', [TekananController::class, 'apiChartPressure']);
Route::get('/pressure_text/{id}', [TekananController::class, 'apiTextPressure']);
