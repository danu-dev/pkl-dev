<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AlumniStoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'school_name' => $this->school_name,
            'major_name' => $this->major_name,
            'division_name' => $this->division_name,
            'graduation_year' => $this->graduation_year,
            'current_position' => $this->current_position,
            'quote' => $this->quote,
            'photo_path' => $this->photo_path,
            'order' => $this->order,
            'is_visible' => (bool) $this->is_visible,
        ];
    }
}
