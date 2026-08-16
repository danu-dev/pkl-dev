<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreManualAttendanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'date' => ['required', 'date'],
            'status' => ['required', 'in:hadir,izin,sakit,alpha'],
            'time_in' => ['nullable'],
            'time_out' => ['nullable'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
