<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'run',
        'category',
        'rank',
        'title',
        'price',
        'imageUrl',
        'stars',
        'reviews',
        'url',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'run' => -1,
        'category' => '',
        'rank' => -1,
        'title' => '',
        'price' => 0,
        'imageUrl' => '',
        'stars' => 0,
        'reviews' => 0,
        'url' => '',
    ];
}
