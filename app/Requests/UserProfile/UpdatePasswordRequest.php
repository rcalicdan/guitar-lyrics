<?php

namespace App\Requests\UserProfile;

use Rcalicdan\Ci4Larabridge\Validation\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    public function rules()
    {
        return [
            'old_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8'],
            'confirm_password' => ['required', 'string', 'same:new_password'],
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