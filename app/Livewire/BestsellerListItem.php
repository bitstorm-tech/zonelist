<?php

namespace App\Livewire;

use Livewire\Component;

class BestsellerListItem extends Component
{
    public $product;

    public function price(): string
    {

        $priceString = "{$this->product['price']}";
        $splitPosition = strlen($priceString) - 2;

        return substr($priceString, 0, $splitPosition).','.substr($priceString, $splitPosition).' €';
    }

    public function ratings(): string
    {
        return number_format($this->product['ratings'], thousands_separator: '.');
    }

    public function stars(): string
    {
        return $this->product['stars'];
    }

    public function title(): string
    {
        return $this->product['title'];
    }

    public function rank(): string
    {
        $rank = $this->product['rank'];

        if ($rank < 10) {
            return "0$rank";
        }

        return $rank;
    }

    public function render()
    {
        return view('livewire.bestseller-list-item');
    }
}
