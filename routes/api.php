<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SensorController;

// Endpoint Sensor Gas
Route::post('/sensor/gas', [SensorController::class, 'storeGas']);

// Endpoint Sensor Suhu & Kelembaban
Route::post('/sensor/temperature', [SensorController::class, 'storeTemperature']);