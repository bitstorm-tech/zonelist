<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function __construct(
        protected string $category,
        protected int $position = -1,
        protected string $title = '',
        protected int $price = 0,
        protected string $imageUrl = '',
        protected float $stars = 0,
        protected int $ratings = 0,
        protected string $url = ''
    ) {}
}
