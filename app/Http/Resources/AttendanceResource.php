<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'date' => $this->date?->format('Y-m-d'),
            'status' => $this->status,
            'time_in' => $this->time_in,
            'time_out' => $this->time_out,
            'time_break' => $this->time_break,
            'time_return' => $this->time_return,
            'notes' => $this->notes,
            'attachment' => $this->attachment,
            'user' => new UserResource($this->whenLoaded('user')),
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
