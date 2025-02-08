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

    /**
     * @throws GuzzleException
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

            $products[] = new Product($categoryName);

            // $product = [
            //     'category' => $this->getNodeValue($xpath, './/span[contains(@class, "a-size-small")]', $item),
            //     'position' => $this->getNodeValue($xpath, './/span[contains(@class, "zg-badge-text")]', $item),
            //     'title' => $this->getNodeValue($xpath, './/div[contains(@class, "p13n-sc-truncate")]', $item),
            //     'price' => $this->getNodeValue($xpath, './/span[contains(@class, "p13n-sc-price")]', $item),
            //     'image' => $this->getNodeAttribute($xpath, './/img', 'src', $item),
            //     'rating' => $this->getNodeValue($xpath, './/span[contains(@class, "a-icon-alt")]', $item),
            //     'url' => $this->getNodeAttribute($xpath, './/a[contains(@class, "a-link-normal")]', 'href', $item),
            // ];

            // // Clean up position number
            // if ($product['position']) {
            //     $product['position'] = (int) str_replace('#', '', $product['position']);
            // }

            // // Convert relative URLs to absolute
            // if ($product['url'] && strpos($product['url'], 'http') !== 0) {
            //     $product['url'] = 'https://www.amazon.de'.$product['url'];
            // }

            // if (! empty($product['title'])) {
            //     $products[] = $product;
            // }
        }

        dd($products);

        return $products;
    }

    private function getNodeValue(DOMXPath $xpath, string $query, $contextNode): ?string
    {
        $node = $xpath->query($query, $contextNode)->item(0);

        return $node ? trim($node->nodeValue) : null;
    }

    private function getNodeAttribute(DOMXPath $xpath, string $query, string $attribute, $contextNode): ?string
    {
        $node = $xpath->query($query, $contextNode)->item(0);

        return $node ? $node->getAttribute($attribute) : null;
    }
}
