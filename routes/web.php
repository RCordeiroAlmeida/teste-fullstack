<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;

Route::get('/', function () {
    return view('index');
});


// Route::get('/forecast', [WeatherController::class, 'getWeather'])->name('forecast');
Route::get('/forecast', [WeatherController::class, 'clima'])->name('clima');

Route::post('/save', [WeatherController::class, 'store'])->name('save');