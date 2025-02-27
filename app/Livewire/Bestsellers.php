<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Bestsellers extends Component
{
    public function render(): View
    {
        $categories = Product::select('category')->distinct()->get();

        return view('livewire.bestsellers', ['categories' => $categories]);
    }
}
