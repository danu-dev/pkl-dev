<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Division extends Model
{
    protected $fillable = ['name', 'code', 'description'];

    public function studentProfiles(): HasMany
    {
        return $table->hasMany(StudentProfile::class);
    }
}
