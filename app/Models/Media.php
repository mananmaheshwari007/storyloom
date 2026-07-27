<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    protected $table = 'media';

    protected $fillable = [
        'filename',
        'filepath',
        'file_size',
        'file_type',
        'folder'
    ];

    public function getUrlAttribute()
    {
        return Storage::url($this->filepath);
    }
}
