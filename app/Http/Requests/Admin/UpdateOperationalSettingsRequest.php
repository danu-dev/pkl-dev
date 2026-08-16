<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOperationalSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'journal_start_time' => ['required', 'string'],
            'journal_end_time' => ['required', 'string'],
            'attendance_in_start' => ['required', 'string'],
            'attendance_in_end' => ['required', 'string'],
            'attendance_out_start' => ['required', 'string'],
            'attendance_out_end' => ['required', 'string'],
            'is_holiday_mode' => ['nullable', 'string'],
        ];
    }
}
