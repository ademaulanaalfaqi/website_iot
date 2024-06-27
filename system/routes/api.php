<?php

use App\Http\Controllers\Ade\DebitController;
use App\Http\Controllers\Ade\TekananController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/data_debit', [DebitController::class, 'apiDebit']);
Route::get('/flow_data/{id}', [DebitController::class, 'apiChartFlow']);
Route::get('/flow_text/{id}', [DebitController::class, 'apiTextFlow']);
Route::get('/data_tekanan', [TekananController::class, 'apiTekanan']);
Route::get('/pressure_data/{id}', [TekananController::class, 'apiChartPressure']);
Route::get('/pressure_text/{id}', [TekananController::class, 'apiTextPressure']);
