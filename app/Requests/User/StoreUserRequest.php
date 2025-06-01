<?php

namespace App\Requests\User;

use App\Enums\UserRoles;
use Rcalicdan\Ci4Larabridge\Validation\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')],
            'role' => ['required', 'string', 'max:40', Rule::in(UserRoles::getRolesExcept([UserRoles::ADMIN->value]))],
            'password' => ['required', 'string', 'min:8'],
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
