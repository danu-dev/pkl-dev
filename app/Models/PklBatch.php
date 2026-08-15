<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PklBatch extends Model
{
    protected $fillable = ['name', 'start_date', 'end_date', 'quota', 'is_active'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }
}
