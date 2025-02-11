<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Services\AmazonScraperService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class AmazonScraperController extends Controller
{
    public function __construct(
        private readonly AmazonScraperService $scraperService
    ) {}

    public function getBestsellers(): JsonResponse
    {
        try {
            $products = $this->scraperService->getBestsellers();

            // dd($products);

            Product::unguard();
            foreach ($products as $product) {
                $product->save();
            }

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
