<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PicketReport extends Model
{
    protected $fillable = [
        'user_id',
        'picket_schedule_id',
        'date',
        'proof_file',
        'notes',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(PicketSchedule::class, 'picket_schedule_id');
    }
}
