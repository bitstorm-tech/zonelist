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

    public function reviews(): string
    {
        return number_format($this->product['reviews'], thousands_separator: '.');
    }

    public function stars(): string
    {
        return $this->product['stars'];
    }

    public function title(): string
    {
        return $this->product['title'];
    }

    public function imageUrl(): string
    {
        return $this->product['imageUrl'];
    }

    public function productUrl(): string
    {
        return 'https://amazon.de'.$this->product['url'];
    }

    public function rank(): string
    {
        $rank = $this->product['rank'];

        if ($rank < 10) {
            return "0$rank";
        }

        return $rank;
    }
}
