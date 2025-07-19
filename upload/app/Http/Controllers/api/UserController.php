<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\UserUpdateRequest;
use App\Services\UserService;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function show()
    {
        $userId = auth()->guard('api')->id();
        $user = $this->userService->getUser($userId);

        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }

    public function update(UserUpdateRequest $request)
    {
        $userId = auth()->guard('api')->id();
        $filteredData = $request->validated();

        $user = $this->userService->updateUser($userId, $filteredData);

        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }
}
