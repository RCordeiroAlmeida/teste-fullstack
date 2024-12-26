<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;

Route::get('/', function () {
    return view('index');
});


Route::get('/forecast', [WeatherController::class, 'getWeather'])->name('forecast');
//Route::get('/forecast', [WeatherController::class, 'clima'])->name('clima');  // rota de teste para não utilizar a API

Route::get('/saved', [WeatherController::class, 'show'])->name('show');

Route::post('/save', [WeatherController::class, 'save'])->name('save');