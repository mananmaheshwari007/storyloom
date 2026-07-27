<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'discount_price',
        'main_image',
        'gallery_images',
        'category',
        'status'
    ];

    protected $casts = [
        'gallery_images' => 'array',
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2'
    ];
}
