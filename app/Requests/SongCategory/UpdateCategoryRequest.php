<?php

namespace App\Requests\SongCategory;

use App\Rules\NoObsceneWord;
use Illuminate\Validation\Rule;
use Rcalicdan\Ci4Larabridge\Validation\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    public function rules()
    {
        $id = service('uri')->getSegment(4);

        return [
            'name' => ['required', 'string', 'max:40', 'min:3', Rule::unique('song_categories', 'name')->ignore($id), new NoObsceneWord],
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
            'name' => 'Category Name',
        ];
    }
}
