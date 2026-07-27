<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $table = 'portfolios';

    protected $fillable = [
        'title',
        'category',
        'description',
        'thumbnail',
        'gallery',
        'status'
    ];

    protected $casts = [
        'gallery' => 'array'
    ];
}
