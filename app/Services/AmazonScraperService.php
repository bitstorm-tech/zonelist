<?php

namespace App\Services;

use App\Models\Product;
use DOMDocument;
use DOMElement;
use DOMXPath;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class AmazonScraperService
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
                'Accept-Language' => 'en-US,en;q=0.9',
                'Connection' => 'keep-alive',
                'Upgrade-Insecure-Requests' => '1',
                'Sec-Fetch-Dest' => 'document',
                'Sec-Fetch-Mode' => 'navigate',
                'Sec-Fetch-Site' => 'none',
                'Sec-Fetch-User' => '?1',
            ],
            'cookies' => true,
        ]);
    }

    public function __invoke(): void
    {
        Log::info('Running scraper task ...');

        $products = $this->getBestsellers();

        Log::info("Got {count($products)}");

        Product::unguard();
        foreach ($products as $product) {
            $product->save();
        }

        Log::info('Scraping done');
    }

    /**
     * @return Product[]
     *
     * @throws GuzzleException*
     */
    public function getBestsellers(): array
    {
        $url = 'https://www.amazon.de/gp/bestsellers';
        $html = $this->fetchPage($url);

        return $this->parseProducts($html);
    }

    /**
     * @throws GuzzleException
     */
    private function fetchPage(string $url): string
    {
        $response = $this->client->get($url);

        return $response->getBody()->getContents();
    }

    /**
     * @return Product[]
     */
    private function parseProducts(string $html): array
    {
        libxml_use_internal_errors(true);
        $dom = new DOMDocument;
        $dom->loadHTML($html);
        $xpath = new DOMXPath($dom);

        $products = [];

        // Get all product containers
        $categories = $xpath->query("//*[starts-with(@id,'CardInstance')]/div/div/div");

        foreach ($categories as $category) {
            if (! $category instanceof DOMElement) {
                Log::warning('DOM type of category is not DOMElement', ['category' => $category]);

                continue;
            }

            $categoryName = trim(str_replace('Bestseller in', '', $category->getElementsByTagName('h2')->item(0)->nodeValue));
            // *[@id="anonCarousel1"]/ol/li[1]/div/div[1]/div[1]/span
            $product = new Product;
            $product->category = $categoryName;

            $products[] = $product;
        }

        return $products;
    }
}
