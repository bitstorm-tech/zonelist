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

        $this->products = $this->getProducts();

        return view('livewire.bestsellers', [
            'categories' => $categories,
            'productGroups' => $this->products,
        ]);
    }

    private function getProducts(): array
    {
        return Product::all()->mapToGroups(function ($product) {
            return [
                $product['category'] => $product,
            ];
        })->all();

    }
}
