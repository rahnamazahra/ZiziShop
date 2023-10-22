<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'alpha_dash:ascii', Rule::unique(Product::class)->ignore($this->id)],
            'sku' => ['nullable', 'string', Rule::unique(Product::class)->ignore($this->id)],
            'barcode'=> ['nullable', 'string', Rule::unique(Product::class)->ignore($this->id)],
            'price' => ['required', 'integer'],
            'discount' => ['nullable', 'string'],
            'inventory' => ['integer'],
            'is_healthy' => ['required'],
            'is_published' => ['required'],
            'category_id' => ['required', Rule::exists('categories', 'id')],
            'weight' => ['nullable', 'integer'],
            'width' => ['nullable', 'integer'],
            'Height' => ['nullable', 'integer'],
            'length' => ['nullable', 'integer'],
            'features' => ['nullable', 'json'],
            'description' => ['nullable', 'string'],
        ];
    }
}
