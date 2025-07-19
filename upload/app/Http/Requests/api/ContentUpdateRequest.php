<?php

namespace App\Http\Requests\api;

use App\Services\ContentService;

class ContentUpdateRequest extends BaseRequest
{
    public function __construct(private ContentService $contentService)
    {
        //
    }

    public function authorize(): bool
    {
        $contentId = $this->route('id');
        $userId = (int) auth()->guard('api')->id();

        return (bool) $this->contentService->getContentWithUserId($contentId, $userId);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'content' => ['required']
        ];
    }
}
