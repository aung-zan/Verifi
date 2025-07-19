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
            'name' => ['required', 'string', 'max:100'],
            'password' => ['sometimes', 'required', 'min:8'],
            'confirm_password' => ['required_with:password', 'same:password']
        ];
    }
}
