<?php

namespace App\Http\Requests\api;

use App\Http\Requests\api\BaseRequest;
use App\Services\ContentService;

class ContentDeleteRequest extends BaseRequest
{
    private ?ContentService $contentService = null;

    public function authorize(): bool
    {
        if (! $this->contentService) {
            $this->contentService = app(ContentService::class);
        }

        $contentId = (int) $this->route('id');
        $userId = auth()->guard('api')->id();

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
            //
        ];
    }
}
