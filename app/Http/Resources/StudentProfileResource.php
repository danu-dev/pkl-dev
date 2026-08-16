<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'nisn_nim' => $this->nisn_nim,
            'phone_number' => $this->phone_number,
            'cv_path' => $this->cv_path,
            'session_type' => $this->session_type,
            'school_id' => $this->school_id,
            'school_name' => $this->school_name,
            'major_id' => $this->major_id,
            'major_name' => $this->major_name,
            'division_id' => $this->division_id,
            'division_name' => $this->division_name,
            'pkl_batch_id' => $this->pkl_batch_id,
            'school' => new SchoolResource($this->whenLoaded('school')),
            'major' => new MajorResource($this->whenLoaded('major')),
            'pkl_batch' => new PklBatchResource($this->whenLoaded('pklBatch')),
        ];
    }
}
