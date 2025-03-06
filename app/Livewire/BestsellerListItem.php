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
        return $this->product['ratings'];
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
        $rankString = "$rank";

        if ($rank < 10) {
            $rankString = "0$rankString";
        }

        return $rankString;
    }

    public function render()
    {
        return view('livewire.bestseller-list-item');
    }
}
