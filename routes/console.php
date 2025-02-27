<?php

use App\Services\AmazonScraperService;
use Illuminate\Support\Facades\Schedule;

Schedule::call(new AmazonScraperService)->everyMinute();
