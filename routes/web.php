<?php

use App\Http\Controllers\OfferController;
use Illuminate\Support\Facades\Route;

// Redirecționează rădăcina către /quotes
// routes/web.php

Route::view('api/offer', 'welcome'); // Frontend Vue.js
Route::view('api/process-talon', 'welcome');
