<?php

namespace App\Http\Requests\api;

class LoginRequest extends BaseRequest
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
             * The email of the user.
             *
             * @example test@mail.com
             */
            'email' => ['required', 'email:dns'],
            /**
             * The password of the user.
             *
             * @example password
             */
            'password' => ['required', 'min:8'],
        ];
    }
}
