<?php

use App\Services\BestsellersScraperService;
use Illuminate\Support\Facades\Schedule;

Schedule::call(new BestsellersScraperService)->dailyAt('23:00');
