<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class RatingStars extends Component
{
    public float $stars;

    public function mount(float $stars)
    {
        $this->stars = round($stars * 2) / 2;
    }

    public function render(): View
    {
        return view('livewire.rating-stars');
    }
}
