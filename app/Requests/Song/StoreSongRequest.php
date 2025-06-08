<?php

namespace App\Requests\Song;

use Illuminate\Validation\Rule;
use Rcalicdan\Ci4Larabridge\Validation\FormRequest;

class StoreSongRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:50'],
            'content' => ['required', 'string', 'max:10000'],
            'is_published' => ['boolean'],
            'image' => ['nullable', 'ci_image', 'ci_file_size:2048'],
            'category_id' => ['nullable', 'integer', Rule::exists('song_categories', 'id')],
            'artist_id' => ['nullable', 'integer', Rule::exists('artists', 'id')],
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
            // Define your custom messages here (optional)
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
