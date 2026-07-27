<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'description',
        'images',
        'client_name',
        'project_url',
        'completion_date',
        'technologies_used',
        'featured',
        'status'
    ];

    protected $casts = [
        'images' => 'array',
        'featured' => 'boolean',
        'completion_date' => 'date'
    ];
}
