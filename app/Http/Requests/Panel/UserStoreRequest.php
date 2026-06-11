<?php

namespace App\Http\Requests\Panel;

use App\Models\User;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

class UserStoreRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name'  => ['required', 'string', 'max:100'],
            'mobile'     => ['required', 'string', Rule::unique(User::class)],
            'password'   => ['required', 'string', 'confirmed', 'min:6'],
        ];
    }
}
