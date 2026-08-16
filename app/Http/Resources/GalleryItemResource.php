<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GalleryItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'category' => $this->category,
            'image_path' => $this->image_path,
            'caption' => $this->caption,
            'order' => $this->order,
            'is_visible' => (bool) $this->is_visible,
        ];
    }
}
