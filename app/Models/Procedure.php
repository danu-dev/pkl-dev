<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Procedure extends Model
{
    protected $fillable = [
        'step_number',
        'title',
        'description',
        'icon',
        'is_visible',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'step_number' => 'integer',
    ];
}
