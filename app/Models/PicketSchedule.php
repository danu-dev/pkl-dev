<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PicketSchedule extends Model
{
    protected $fillable = [
        'user_id',
        'day',
        'shift',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
