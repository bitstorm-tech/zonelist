<?php

namespace App\Livewire;

use Livewire\Component;

class RatingStars extends Component
{
    public float $stars;

    public function mount(float $stars)
    {
        $this->stars = round($stars * 2) / 2;
    }
}
