<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Bestsellers extends Component
{
    private $products = [];

    public function render(): View
    {
        $categories = Product::select('category')->distinct()->get()->map(function ($product) {
            return $product['category'];
        });

        $this->products = $this->products();

        $lastUpdate = $this->lastUpdate();

        return view('livewire.bestsellers', [
            'categories' => $categories,
            'productGroups' => $this->products,
            'lastUpdate' => $lastUpdate,
        ]);
    }

    private function products(): array
    {
        return Product::where('created_at', Product::max('created_at'))->get()->mapToGroups(function ($product) {
            return [
                $product['category'] => $product,
            ];
        })->all();

    }

    private function lastUpdate(): string
    {
        return Product::select('created_at')->orderByDesc('created_at')->limit(1)->value('created_at');
    }
}
