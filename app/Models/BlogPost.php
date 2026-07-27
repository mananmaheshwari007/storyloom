<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogPost extends Model
{
    use SoftDeletes;

    protected $table = 'blog_posts';

    protected $fillable = [
        'title',
        'slug',
        'featured_image',
        'short_description',
        'content',
        'meta_title',
        'meta_description',
        'keywords',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];
}
