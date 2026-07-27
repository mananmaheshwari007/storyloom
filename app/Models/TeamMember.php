<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    protected $table = 'team_members';

    protected $fillable = [
        'name',
        'designation',
        'photo',
        'social_links',
        'description',
        'status'
    ];

    protected $casts = [
        'social_links' => 'array'
    ];
}
