<?php

namespace App\Requests\SongCategory;

use App\Rules\IsAppropriate;
use Illuminate\Validation\Rule;
use Rcalicdan\Ci4Larabridge\Validation\FormRequest;

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
            'name.'.IsAppropriate::class => 'The category name is inappropriate',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'category name',
        ];
    }
}
