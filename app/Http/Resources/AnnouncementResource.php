<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnnouncementResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'is_pinned' => (bool) $this->is_pinned,
            'target_role' => $this->target_role,
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
