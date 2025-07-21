<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\LoginRequest;
use App\Http\Requests\api\UserCreateRequest;
use App\Http\Resources\UserResource;
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(UserCreateRequest $request)
    {
        $filteredData = $request->validated();

        $user = $this->userService->createUser($filteredData);

        // Created successfully.
        return response()->json([
            'success' => true,
            'data' => new UserResource($user),
        ], 201);
    }

    /**
     * Authenticate and login the user.
     *
     * @unauthenticated.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if ($token = Auth::guard('api')->attempt($credentials)) {
            $user = auth()->guard('api')->user();

            // Login successfully.
            return response()->json([
                'success' => true,
                'data' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => config('jwt.ttl'),
                ],
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Email or password is wrong.',
        ], 401);
    }

    /**
     * Logout the authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::guard('api')->logout();

        // Logout successfully.
        return response()->json([
            'success' => true,
            'message' => 'Successfully logout.',
        ]);
    }
}
