<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlumniStory extends Model
{
    protected $fillable = [
        'name',
        'username',
        'school_name',
        'major_name',
        'division_name',
        'graduation_year',
        'current_position',
        'quote',
        'photo_path',
        'order',
        'is_visible',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'order' => 'integer',
    ];
}
