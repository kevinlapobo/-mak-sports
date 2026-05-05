<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsUpdate extends Model
{
    protected $fillable = [
        'title',
        'body',
        'category',
        'photo',
        'author',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];
}
