<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StorePicketScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'day' => ['required', 'in:senin,selasa,rabu,kamis,jumat'],
            'shift' => ['required', 'in:pagi,sore'],
        ];
    }
}
