<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class TestService
{
    public function __invoke(): mixed
    {
        Log::info('This log came from TestService');
    }
}
