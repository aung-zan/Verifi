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
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email:dns', 'unique:users'],
            'confirm_email' => ['required', 'same:email'],
            'password' => ['required', 'min:8'],
            'confirm_password' => ['required', 'same:password'],
        ];
    }
}
