<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    protected $fillable = [
        'user_id',
        'date',
        'status',
        'time_in',
        'time_break',
        'time_return',
        'time_out',
        'notes',
        'attachment',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
