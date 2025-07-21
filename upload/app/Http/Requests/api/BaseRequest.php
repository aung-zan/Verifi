<?php

namespace App\Http\Requests\api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Customize the api validation response.
     */
    protected function failedValidation(Validator $validator): void
    {
        $errors = $validator->errors();

        $response = [
            'success' => false,
            'message' => 'Validation failed.',
            'errors' => $this->formatErrors($errors->toArray()),
        ];

        throw new HttpResponseException(response()->json($response, 422));
    }

    /**
     * Format the api error messages.
     *
     * @return array $formatted
     */
    private function formatErrors(array $errors): array
    {
        $formatted = [];

        foreach ($errors as $field => $message) {
            $formatted[] = [
                'field' => $field,
                'message' => $message[0],
            ];
        }

        return $formatted;
    }
}
