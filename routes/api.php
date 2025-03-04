<?php

use App\Http\Controllers\Api\BestsellersScraperController;
use Illuminate\Support\Facades\Route;

Route::get('/bestsellers', [BestsellersScraperController::class, 'getBestsellers'])->middleware('api.key');
