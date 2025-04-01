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

        $this->lastUpdate = $this->lastUpdate();

    }

    public function productsOfActiveCategory(): Collection
    {
        Log::debug('productsOfActiveCategory: '.$this->activeCategory);

        $products = Product::select()
            ->where('created_at', Product::max('created_at'))
            ->where('category', $this->activeCategory)
            ->get();

        Log::debug('Products: '.$products->count());

        return $products;
    }

    public function lastUpdate(): string
    {
        return Product::select('created_at')->orderByDesc('created_at')->limit(1)->value('created_at');
    }
}
