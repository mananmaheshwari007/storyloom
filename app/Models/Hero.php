<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    protected $table = 'heros';

    protected $fillable = [
        'heading',
        'subheading',
        'description',
        'button_text',
        'button_link',
        'background_image',
        'hero_image'
    ];
}
