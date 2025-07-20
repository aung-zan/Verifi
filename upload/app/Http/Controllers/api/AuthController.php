<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\LoginRequest;
use App\Http\Requests\api\UserCreateRequest;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Register the users.
     *
     * @unauthenticated.
     *
     * @param UserCreateRequest $request
     */
    public function register(UserCreateRequest $request)
    {
        $filteredData = $request->validated();

        $user = $this->userService->createUser($filteredData);

        return response()->json([
            'success' => true,
            'data' => $user
        ], 201);
    }

    /**
     * Authenticate and login the user.
     *
     * @unauthenticated.
     *
     * @param LoginRequest $request
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if ($token = Auth::guard('api')->attempt($credentials)) {
            $user = auth()->guard('api')->user();

            return response()->json([
                'success' => true,
                'data' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => config('jwt.ttl')
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Email or password is wrong.'
        ], 401);
    }

    /**
     * Logout the authenticated user.
     */
    public function logout()
    {
        Auth::guard('api')->logout();

        return response()->json([
            'success' => true,
            'message' => 'Successfully logout.'
        ]);
    }
}
