<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $attributes = [
        'run' => -1,
        'category' => '',
        'rank' => -1,
        'title' => '',
        'price' => 0,
        'imageUrl' => '',
        'stars' => 0,
        'ratings' => 0,
        'url' => '',
    ];

    protected $guarded = [];
}
