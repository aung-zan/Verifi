<?php

namespace App\Http\Requests\api;

class ContentCreateRequest extends BaseRequest
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
             * The content that is on the internet will be verified.
             * @example Last night someone is died in the car accident.
             */
            'content' => ['required']
        ];
    }
}
