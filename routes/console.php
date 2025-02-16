<?php

use App\Services\TestService;
use Illuminate\Support\Facades\Schedule;

// Schedule::call(new AmazonScraperService)->everyMinute();
Schedule::call(new TestService)->everyMinute();
