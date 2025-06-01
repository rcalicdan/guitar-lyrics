<?php

namespace App\Requests\UserProfile;

use Rcalicdan\Ci4Larabridge\Validation\FormRequest;

class UpdateImageRequest extends FormRequest
{
    public function rules()
    {
        return [
            'profile_image' => ['required', 'ci_image', 'ci_file_size:5120', 'ci_mimes:jpg,jpeg,png,gif,webp'],
        ];
    }

    public function messages()
    {
        return [
            'profile_image.ci_file_size' => 'The uploaded file must be not exceed 5 megabytes'
        ];
    }

    public function attributes()
    {
        return [
            // Define your custom attribute names here (optional)
        ];
    }
}
