<?php

namespace App\Applications\Auth\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mobile' => 'required|string|max:11',
            'password' => 'required|string|min:6',
        ];
    }
}
