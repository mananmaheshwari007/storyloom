<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibraryBook extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'type',
        'relation_tag',
        'occasion_tag',
        'spreads_count',
        'read_time',
        'synopsis',
        'caption',
        'cover_image',
        'back_image',
        'pages_json',
        'order',
        'status',
    ];

    protected $casts = [
        'pages_json' => 'array',
        'status' => 'boolean',
        'order' => 'integer',
    ];
}
