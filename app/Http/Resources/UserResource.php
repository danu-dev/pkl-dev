<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'role' => $this->role,
            'status' => $this->status,
            'is_approved' => (bool) $this->is_approved,
            'avatar' => $this->avatar,
            'profile' => new StudentProfileResource($this->whenLoaded('profile')),
            'grade' => new StudentGradeResource($this->whenLoaded('grade')),
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
