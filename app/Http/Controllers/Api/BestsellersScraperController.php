<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Services\BestsellersScraperService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class BestsellersScraperController extends Controller
{
    public function __construct(
        private readonly BestsellersScraperService $scraperService
    ) {}

    public function getBestsellers(): Response|JsonResponse
    {
        try {
            $products = $this->scraperService->getBestsellers();

            Product::unguard();
            foreach ($products as $product) {
                $product->save();
            }

            return response()->noContent();
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch bestsellers: '.$e->getMessage(),
            ], 500);
        }
    }
}
