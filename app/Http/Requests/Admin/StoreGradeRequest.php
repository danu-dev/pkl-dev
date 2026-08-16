<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreGradeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'discipline_score' => ['required', 'numeric', 'min:0', 'max:100'],
            'technical_score' => ['required', 'numeric', 'min:0', 'max:100'],
            'journal_score' => ['required', 'numeric', 'min:0', 'max:100'],
            'attendance_score' => ['required', 'numeric', 'min:0', 'max:100'],
            'attitude_score' => ['required', 'numeric', 'min:0', 'max:100'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
