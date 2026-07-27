<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSection extends Model
{
    protected $fillable = [
        'heading',
        'subheading',
        'description',
        'button_text',
        'button_link',
        'bg_image',
        'hero_image'
    ];
}
