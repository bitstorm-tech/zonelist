<?php

use App\Services\BestsellersScraperService;
use Illuminate\Support\Facades\Route;

Route::get('/bestsellers', [BestsellersScraperService::class, 'getBestsellers'])->middleware('api.key');
