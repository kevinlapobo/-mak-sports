<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sport extends Model
{
    use HasFactory;
    protected $fillable =
    [
        'name',
        'slug',
        'icon',
        'banner_photo',
        'is_active',
        'display_order'
    ];
    protected $casts =
    [
        'is_active' => 'boolean'
    ];

    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }
    public function competitions(): HasMany
    {
        return $this->hasMany(Competition::class);
    }
}
