<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Services\AmazonScraperService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AmazonScraperControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        
        // Setup mock service for all tests
        $mockService = $this->mock(AmazonScraperService::class);
        $mockService->shouldReceive('getBestsellers')
            ->andReturn([
                new Product(
                    category: 'Electronics',
                    position: 1,
                    title: 'Test Product',
                    price: 9999,
                    imageUrl: 'http://example.com/image.jpg',
                    stars: 4.5,
                    ratings: 100,
                    url: 'http://example.com/product'
                )
            ]);
    }

    /** @test */
    public function it_returns_200_for_bestsellers_route()
    {
        $response = $this->getJson('/api/bestsellers');
        
        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    '*' => [
                        'category',
                        'position',
                        'title',
                        'price',
                        'imageUrl',
                        'stars',
                        'ratings',
                        'url'
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_returned_products_have_required_fields()
    {
        $response = $this->getJson('/api/bestsellers');
        $responseData = $response->json('data.0');

        $this->assertArrayHasKey('category', $responseData);
        $this->assertArrayHasKey('title', $responseData);
        $this->assertArrayHasKey('price', $responseData);
        $this->assertArrayHasKey('imageUrl', $responseData);
    }

    /** @test */
    public function it_handles_service_errors_gracefully()
    {
        // Override mock to throw exception
        $this->mock(AmazonScraperService::class)
            ->shouldReceive('getBestsellers')
            ->andThrow(new \Exception('Test error'));

        $response = $this->getJson('/api/bestsellers');

        $response->assertStatus(500)
            ->assertJson([
                'success' => false,
                'message' => 'Failed to fetch bestsellers: Test error'
            ]);
    }
}
