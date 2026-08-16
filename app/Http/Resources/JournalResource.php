<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JournalResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'date' => $this->date?->format('Y-m-d'),
            'title' => $this->title,
            'description' => $this->description,
            'proof_file' => $this->proof_file,
            'status' => $this->status,
            'admin_note' => $this->admin_note,
            'user' => new UserResource($this->whenLoaded('user')),
            'created_at' => $this->created_at?->format('H:i'),
        ];
    }
}
