<?php

use App\Http\Controllers\Ade\FlowPressureController;
use App\Http\Controllers\Ari\QualityController;
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

Route::get('/flow_data', [FlowPressureController::class, 'apiChartFlow']);
Route::get('/flow_text', [FlowPressureController::class, 'apiTextFlow']);
Route::get('/pressure_data', [FlowPressureController::class, 'apiChartPressure']);
Route::get('/pressure_text', [FlowPressureController::class, 'apiTextPressure']);



Route::get('/turbi_data', [QualityController::class, 'apiChartTurbi']);
Route::get('/turbi_last', [QualityController::class, 'apiLastTurbi']);
