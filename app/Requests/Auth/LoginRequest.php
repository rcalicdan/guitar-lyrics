<?php

namespace App\Requests\Auth;

use Rcalicdan\Ci4Larabridge\Validation\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'remember' => ['boolean'],
        ];
    }

    public function messages()
    {
        return [
            // Define your custom messages here (optional)
        ];
    }

    public function attributes()
    {
        return [
            // Define your custom attribute names here (optional)
        ];
    }
}
