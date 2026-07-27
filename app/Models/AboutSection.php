<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutSection extends Model
{
    protected $fillable = [
        'heading',
        'description',
        'image',
        'experience',
        'skills',
        'statistics'
    ];

    protected $casts = [
        'skills' => 'array',
        'statistics' => 'array'
    ];
}
