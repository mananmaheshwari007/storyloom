<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    protected $table = 'abouts';

    protected $fillable = [
        'heading',
        'description',
        'image',
        'experience_years',
        'skills',
        'statistics'
    ];

    protected $casts = [
        'skills' => 'array',
        'statistics' => 'array'
    ];
}
