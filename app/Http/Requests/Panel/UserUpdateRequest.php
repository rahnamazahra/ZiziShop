<?php

namespace App\Http\Requests\panel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:255'],
            'mobile'   => ['required', 'string', 'unique:users', Rule::unique(User::class)->ignore($this->user()->id)],
        ];
    }
}
