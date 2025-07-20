<?php

namespace App\Http\Requests\api;

class UserUpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            /**
             * The name of the user.
             * @example tester 11
             */
            'name' => ['required', 'string', 'max:100'],
            /**
             * The password of the user.
             * @example password123
             */
            'password' => ['sometimes', 'required', 'min:8'],
            /**
             * The password confirmation. Must be same with password.
             * @example password123
             */
            'confirm_password' => ['required_with:password', 'same:password']
        ];
    }
}
