<?php

namespace App\Requests\Artist;

use Illuminate\Validation\Rule;
use Rcalicdan\Ci4Larabridge\Validation\FormRequest;

class UpdateArtistRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $artistId = service('uri')->getSegment(4);

        return [
            "name" => ["required", "string", "max:50", Rule::unique('artists', 'name')->ignore($artistId)],
            "about" => ["nullable", "string", "min:10", "max:500",],
            "image" => ["nullable", "ci_image", "ci_file_size:2048"],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            // Define your custom validation messages here (optional)
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            // Define your custom attribute names here (optional)
        ];
    }
}
