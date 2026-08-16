<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreAlumniRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => ['nullable', 'integer'],
            'name' => ['required', 'string', 'max:255'],
            'username' => ['nullable', 'string', 'max:255'],
            'school_name' => ['required', 'string', 'max:255'],
            'major_name' => ['nullable', 'string', 'max:255'],
            'division_name' => ['nullable', 'string', 'max:255'],
            'graduation_year' => ['nullable', 'string', 'max:10'],
            'current_position' => ['nullable', 'string', 'max:255'],
            'quote' => ['required', 'string'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'order' => ['nullable', 'integer'],
            'is_visible' => ['nullable', 'boolean'],
        ];
    }
}
