<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Bestsellers extends Component
{
    public array $orderOptions = [
        'Rang ↑',
        'Rang ↓',
        'Preis ↑',
        'Preis ↓',
        'Sterne ↑',
        'Sterne ↓',
        'Bewertungen ↑',
        'Bewertungen ↓',
    ];

    public $allCategories = [];

    public string $orderBy;

    public string $activeCategory;

    public string $lastUpdate;

    public function mount()
    {
        $this->allCategories = Product::select('category')
            ->orderBy('category')
            ->distinct()
            ->pluck('category')
            ->toArray() ?? [];

        $this->activeCategory = $this->allCategories[0] ?? '';

        $this->orderBy = $this->orderOptions[0];

        $this->lastUpdate = $this->lastUpdate();
    }

    public function productsOfActiveCategory(): Collection
    {
        Log::debug('productsOfActiveCategory: '.$this->activeCategory);

        $query = Product::select()
            ->where('run', Product::max('run'))
            ->where('category', $this->activeCategory)
            ->orderBy('category');

        [$orderColumn, $orderDirection] = match ($this->orderBy) {
            'Rang ↑' => ['rank', 'asc'],
            'Rang ↓' => ['rank', 'desc'],
            'Preis ↑' => ['price', 'asc'],
            'Preis ↓' => ['price', 'desc'],
            'Sterne ↑' => ['stars', 'asc'],
            'Sterne ↓' => ['stars', 'desc'],
            'Bewertungen ↑' => ['reviews', 'asc'],
            'Bewertungen ↓' => ['reviews', 'desc'],
            default => ['rank', 'asc'],
        };
        $query->orderBy($orderColumn, $orderDirection);

        $products = $query->get();

        Log::debug('Products: '.$products->count());

        return $products;
    }

    public function lastUpdate(): string
    {
        return Product::select('created_at')->orderByDesc('created_at')->limit(1)->value('created_at') ?? 'n/a';
    }
}
