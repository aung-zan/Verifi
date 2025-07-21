<?php

namespace App\Http\Requests\api;

use App\Enums\ContentStatus;
use Illuminate\Validation\Rule;

class ContentListRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => ['sometimes', Rule::enum(ContentStatus::class)],
        ];
    }
}
