<?php

use App\Http\Controllers\Api\AmazonScraperController;
use Illuminate\Support\Facades\Route;

Route::get('/bestsellers', [AmazonScraperController::class, 'getBestsellers'])->middleware('api.key');
