<?php

namespace App\Services;

use App\Models\Product;
use DOMDocument;
use DOMElement;
use DOMXPath;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class BestsellersScraperService
{
    private $amazonBaseUrl = 'https://www.amazon.de/gp/bestsellers';

    private $categorySubUrls = [
        'Amazon Renewed' => '/amazon-renewed',
        // 'Amazon-Geräte & Zubehör' => '/amazon-devices',
        // 'Auto & Motorrad' => '/automotive',
        // 'Baby' => '/baby',
        // 'Baumarkt' => '/diy',
        // 'Beleuchtung' => '/lighting',
        // 'Bücher' => '/books',
        // 'Bürobedarf & Schreibwaren' => '/officeproduct',
        // 'Climate Pledge Friendly' => '/climate-pledge',
        // 'Computer & Zubehör' => '/computers',
        // 'Drogerie & Körperpflege' => '/drugstore',
        // 'DVD & Blu-ray' => '/dvd-de',
        // 'Elektro-Großgeräte' => '/appliances',
        // 'Elektronik & Foto' => '/fashion',
        // 'Fashion' => '/fashion',
        // 'Games' => '/videogames',
        // 'Garten' => '/garden',
        // 'Geschenkgutscheine' => '/gift-cards',
        // 'Gewerbe, Industrie & Wissenschaft' => '/industrial',
        // 'Handmade-Produkte' => '/handmade',
        // 'Haustier' => '/pet-supplies',
        // 'Kamera & Foto' => '/photo',
        // 'Kosmetik' => '/beauty',
        // 'Küche, Haushalt & Wohnen' => '/kitchen',
        // 'Lebensmittel & Getränke' => '/grocery',
        // 'Musik-CDs & Vinyl' => '/music',
        // 'Musikinstrumente & DJ-Equipment' => '/musical-instruments',
        // 'Neue Fundstücke' => '/boost',
        // 'Prime Video' => '/instant-video',
        // 'Software' => '/software',
        // 'Spielzeug' => '/toys',
        // 'Sport & Freizeit' => '/sports',
    ];

    public function __construct()
    {
        libxml_use_internal_errors(true);
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

    public function getBestsellers(): array
    {
        $products = [];

        foreach ($this->categorySubUrls as $categoryName => $subUrl) {
            $url = "{$this->amazonBaseUrl}{$subUrl}";
            $html = $this->fetchPage($url);
            $dom = new DOMDocument;
            $dom->loadHTML($html);
            $xpath = new DOMXPath($dom);
            $productsOfCategory = $this->getProductsOfCategory($categoryName, $xpath);

            $count = count($productsOfCategory);

            Log::info("Got {$count} from category: {$categoryName}");

            array_push($products, ...$productsOfCategory);
        }

        return $products;
    }

    private function fetchPage(string $url): string
    {
        $client = new Client([
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

        $response = $client->get($url);

        return $response->getBody()->getContents();
    }

    private function getProductsOfCategory(string $categoryName, DOMXPath $xpath): array
    {
        $products = [];

        $productNodes = $xpath->query('//div[@id="gridItemRoot"]');

        foreach ($productNodes as $productNode) {
            $product = new Product;
            $product->category = $categoryName;
            $product->rank = $this->extractProductRanking($productNode, $xpath);
            $product->title = $this->extractProductTitle($productNode, $xpath);
            $product->price = $this->extractProductPrice($productNode, $xpath);

            array_push($products, $product);
        }

        return $products;
    }

    private function extractProductRanking(DOMElement $productNode, DOMXPath $xpath): int
    {
        $rankString = $xpath->query('./div/div/div[1]/div[1]/span', $productNode)->item(0)->nodeValue;

        if (strlen($rankString) == 0) {
            Log::warning('No product rank found!');
        }

        return (int) str_replace('#', '', $rankString);
    }

    private function extractProductTitle(DOMElement $productNode, DOMXPath $xpath): string
    {
        $titleString = $xpath->query('./div/div/div[2]/span/div/div/div/a/span/div', $productNode)->item(0)->nodeValue;

        if (strlen($titleString) == 0) {
            Log::warning('No product title found!');
        }

        return $titleString;
    }

    private function extractProductPrice(DOMElement $productNode, DOMXPath $xpath): int
    {
        $priceNode = $xpath->query('./div/div/div[2]/span/div/div/div/div[2]/div/div/a/div/span/span', $productNode);

        if ($priceNode->length === 0) {
            Log::warning('Product has no price!');

            return 0;
        }

        $priceString = $priceNode->item(0)->nodeValue;

        if (strlen($priceString) == 0) {
            Log::warning('No product price found!');

            return 0;
        }

        $priceString = trim(str_replace([' ', ',', '.', '€'], '', $priceString));

        Log::info("Price string: [$priceString]");

        return (int) $priceString;
    }
}
