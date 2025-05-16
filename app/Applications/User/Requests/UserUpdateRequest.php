<?php

namespace App\Applications\User\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', Rule::unique(User::class)->ignore($this->user)],
        ];
    }
}

