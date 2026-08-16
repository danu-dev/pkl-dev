<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupervisorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'nip' => ['nullable', 'string'],
            'email' => ['nullable', 'email'],
            'phone_number' => ['nullable', 'string'],
            'company_agency' => ['nullable', 'string'],
        ];
    }
}
