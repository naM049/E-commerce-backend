<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required','max:255'],
            'description' => ['required'],
            'price' => ['required','numeric'],
            'units_in_stock' => ['required','numeric'],
            'category_id' => ['required', 'numeric','exists:categories,id'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
