<?php

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
    return 'Welcome to Ashcourt';
});

Route::prefix('/rates')->group(function(){
    Route::get('/all', [\App\Http\Controllers\CurrencyController::class, 'getAllRates']);
    Route::get('/json', [\App\Http\Controllers\CurrencyController::class, 'getJsonRates']);
    Route::get('/{symbol}', [\App\Http\Controllers\CurrencyController::class, 'getRateBySymbol']);
});

Route::prefix('/currency')->group( function () {
    Route::get('/american-dollars', [\App\Http\Controllers\CurrencyController::class, 'getAmericanDollars']);
    Route::get('/australian-dollars', [\App\Http\Controllers\CurrencyController::class, 'getAustralianDollars']);
});
