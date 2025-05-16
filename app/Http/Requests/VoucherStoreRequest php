<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VoucherStoreRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code'=> ['required', 'string', 'max:255'],
            'discount'=> ['required', 'integer'],
            'comment' => ['nullable', 'string'],
            'shipping_discount' => ['nullable', 'integer'],
            'mininum_purchase_total' => ['nullable', 'integer'],
            'maximum_discount' => ['nullable', 'integer'],
            'maximum_shipping_discount' => ['nullable', 'integer'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
            'remaining' => ['nullable', 'integer']
        ];
    }
}
