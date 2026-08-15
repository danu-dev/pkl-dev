<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentProfile extends Model
{
    protected $fillable = [
        'user_id',
        'school_id',
        'major_id',
        'pkl_batch_id',
        'division_id',
        'nisn_nim',
        'phone_number',
        'cv_path',
        'session_type',
        'school_name',
        'major_name',
        'division_name',
    ];

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function major(): BelongsTo
    {
        return $this->belongsTo(Major::class);
    }

    public function pklBatch(): BelongsTo
    {
        return $this->belongsTo(PklBatch::class);
    }
}
