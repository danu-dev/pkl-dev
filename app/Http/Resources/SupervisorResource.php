<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupervisorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'nip' => $this->nip,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'company_agency' => $this->company_agency,
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
