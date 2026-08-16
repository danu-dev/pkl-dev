<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,'.$this->route('user')->id],
            'session_type' => ['required', 'in:full_day,persesi_pagi,persesi_sore'],
            'division_id' => ['nullable', 'exists:divisions,id'],
            'status' => ['required', 'in:pending,approved,rejected'],
        ];
    }
}
