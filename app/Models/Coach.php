<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coach extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'photo',
        'joined_date',
        'qualification',
        'specialization',
        'experience_years',
        'bio',
        'is_active',
        'phone',
        'email'
    ];
}
