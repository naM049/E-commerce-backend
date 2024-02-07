<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'email', 'max:254'],
            'password' => ['required','confirmed',Password::defaults()],
            'birthday' => ['nullable', 'date'],
            'country' => ['required', 'string'],
            'city' => ['required'],
            'postcode' => ['required'],
            'address_line_1' => ['required'],
            'address_line_2' => ['nullable'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
