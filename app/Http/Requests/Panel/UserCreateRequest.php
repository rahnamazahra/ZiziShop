<?php

namespace App\Http\Requests\panel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserCreateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:255'],
            'mobile'   => ['required', 'string', 'unique:users'],
            'password' => ['required', 'string', 'confirmed', 'min:6'],
        ];
    }
}
