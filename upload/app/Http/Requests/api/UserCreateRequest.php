<?php

namespace App\Http\Requests\api;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends BaseRequest
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
             * @example tester 1
             */
            'name' => ['required', 'string', 'max:100'],
            /**
             * The email of the user.
             * @example test@mail.com
             */
            'email' => ['required', 'email:dns', 'unique:users'],
            /**
             * The email confirmation. Must be same with email.
             * @example test@mail.com
             */
            'confirm_email' => ['required', 'same:email'],
            /**
             * The password of the user.
             * @example password
             */
            'password' => ['required', 'min:8'],
            /**
             * The password confirmation. Must be same with password.
             * @example password
             */
            'confirm_password' => ['required', 'same:password'],
        ];
    }
}
