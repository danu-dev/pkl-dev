<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class School extends Model
{
    protected $fillable = ['name', 'code', 'address'];

    public function majors(): HasMany
    {
        return $this->hasMany(Major::class);
    }
}
