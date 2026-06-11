<?php

namespace App\Http\Requests\Panel;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name'  => ['required', 'string', 'max:100'],
            'mobile'     => ['required', Rule::unique(User::class)->ignore($this->user)],
        ];
    }
}

