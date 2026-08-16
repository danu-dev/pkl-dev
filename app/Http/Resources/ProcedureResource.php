<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProcedureResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'step_number' => $this->step_number,
            'title' => $this->title,
            'description' => $this->description,
            'icon' => $this->icon,
            'is_visible' => (bool) $this->is_visible,
        ];
    }
}
