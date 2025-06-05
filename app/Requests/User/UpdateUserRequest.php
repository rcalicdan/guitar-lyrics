<?php

namespace App\Requests\User;

use Illuminate\Validation\Rule;
use Rcalicdan\Ci4Larabridge\Validation\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function rules()
    {
        $userId = service('uri')->getSegment(3);

        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'password' => ['sometimes', 'nullable', 'string', 'min:8'],
        ];
    }

    protected function prepareForValidation()
    {
        $data = $this->getData();
        if (isset($data['password']) && empty($data['password'])) {
            unset($data['password']);
        }

        $this->setData($data);
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
