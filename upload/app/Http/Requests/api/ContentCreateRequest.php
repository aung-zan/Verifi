<?php

namespace App\Http\Requests\api;

use App\Services\UserService;

class ContentCreateRequest extends BaseRequest
{
    private ?UserService $userService = null;

    public function authorize(): bool
    {
        if (! $this->userService) {
            $this->userService = app(UserService::class);
        }

        $userId = (int) auth()->guard('api')->id();
        $user = $this->userService->getUser($userId);

        return ! empty($user->sonar_key);
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
             *
             * @example Last night someone is died in the car accident.
             */
            'content' => ['required'],
        ];
    }
}
