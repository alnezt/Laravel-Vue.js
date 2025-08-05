<?php

use App\Http\Controllers\OcrController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OfferController;


Route::post('/offer', [OfferController::class, 'store'])->middleware('api');


Route::get('/offer', [OfferController::class, 'index'])->middleware('api');
Route::post('/process-talon', [OcrController::class, 'processTalon'])->middleware('api');
