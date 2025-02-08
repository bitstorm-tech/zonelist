<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AmazonScraperService;
use Illuminate\Http\JsonResponse;

class AmazonScraperController extends Controller
{
    public function __construct(
        private readonly AmazonScraperService $scraperService
    ) {}

    public function getBestsellers(): JsonResponse
    {
        try {
            $products = $this->scraperService->getBestsellers();

            return response()->json([
                'success' => true,
                'data' => $products,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch bestsellers: '.$e->getMessage(),
            ], 500);
        }
    }
}
