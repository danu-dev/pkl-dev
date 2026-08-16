<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentGradeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'discipline_score' => (float) $this->discipline_score,
            'technical_score' => (float) $this->technical_score,
            'journal_score' => (float) $this->journal_score,
            'attendance_score' => (float) $this->attendance_score,
            'attitude_score' => (float) $this->attitude_score,
            'final_score' => (float) $this->final_score,
            'grade_letter' => $this->grade_letter,
            'notes' => $this->notes,
            'user' => new UserResource($this->whenLoaded('user')),
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
