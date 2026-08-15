<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentGrade extends Model
{
    protected $fillable = [
        'user_id',
        'discipline_score',
        'technical_score',
        'journal_score',
        'attendance_score',
        'attitude_score',
        'final_score',
        'grade_letter',
        'notes',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
