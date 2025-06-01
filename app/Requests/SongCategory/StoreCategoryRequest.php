<?php

namespace App\Requests\SongCategory;

use Rcalicdan\Ci4Larabridge\Validation\FormRequest;
use App\Rules\IsAppropriate;
use App\Rules\NoObsceneWord;
use Illuminate\Validation\Rule;

class StoreCategoryRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:40', 'min:3', Rule::unique('song_categories', 'name'), new IsAppropriate],
        ];
    }

    public function messages()
    {
        return [
            "name." . IsAppropriate::class => 'The category name is inappropriate'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'category name',
        ];
    }
}
