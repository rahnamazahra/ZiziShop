<?php

namespace App\Http\Requests\panel;

use App\Models\User;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

class UserStoreRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:255'],
            'mobile'   => ['required', 'string', Rule::unique(User::class)],
            'password' => ['required', 'string', 'confirmed', 'min:6'],
        ];
    }
}
