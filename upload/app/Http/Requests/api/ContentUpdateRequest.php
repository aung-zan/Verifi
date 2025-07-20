<?php

namespace App\Http\Requests\api;

use App\Services\ContentService;

class ContentUpdateRequest extends BaseRequest
{
    private ?ContentService $contentService = null;

    public function authorize(): bool
    {
        if (! $this->contentService) {
            $this->contentService = app(ContentService::class);
        }

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
            /**
             * The content that is on the internet will be verified.
             * @example Last night someone is died in the car accident.
             */
            'content' => ['required']
        ];
    }
}
