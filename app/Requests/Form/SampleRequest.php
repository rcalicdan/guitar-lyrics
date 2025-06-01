<?php

namespace App\Requests\Form;

use Rcalicdan\Ci4Larabridge\Validation\FormRequest;

class SampleRequest extends FormRequest
{
    public function rules()
    {
        return [
            // Define your validation rules here
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
