<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Bestsellers extends Component
{
    public $allCategories = [];

    public string $orderBy;

    public string $activeCategory;

    public string $lastUpdate;

    public function mount()
    {
        $this->allCategories = Product::select('category')->distinct()->pluck('category')->toArray();

        $this->activeCategory = $this->allCategories[0];
        $this->orderBy = 'Rang ↑';

        $this->lastUpdate = $this->lastUpdate();
    }

    public function productsOfActiveCategory(): Collection
    {
        Log::debug('productsOfActiveCategory: '.$this->activeCategory);

        $query = Product::select()
            ->where('created_at', Product::max('created_at'))
            ->where('category', $this->activeCategory);

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
        return Product::select('created_at')->orderByDesc('created_at')->limit(1)->value('created_at');
    }
}
