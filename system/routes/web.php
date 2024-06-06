<?php

use App\Http\Controllers\Ade\FlowRateController;
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

Route::get('/debit-dan-tekanan', [FlowRateController::class, 'flowPressure']);
Route::get('/getDataDebit', [FlowRateController::class, 'chartDebit']);
Route::get('/getBilanganDebit', [FlowRateController::class, 'getBilanganDebit']);
