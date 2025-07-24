<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display the authenticated user's info.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {
        $userId = auth()->guard('api')->id();
        $user = $this->userService->getUser($userId);

        // User info.
        return response()->json([
            'success' => true,
            'data' => new UserResource($user),
        ], 200);
    }

    /**
     * Update the authenticated user's info.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserUpdateRequest $request)
    {
        $userId = auth()->guard('api')->id();
        $filteredData = $request->validated();

        $user = $this->userService->updateUser($userId, $filteredData);

        // Updated successfully.
        return response()->json([
            'success' => true,
            'data' => new UserResource($user),
        ], 200);
    }
}
