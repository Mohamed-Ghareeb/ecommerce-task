<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\LoginRequest;
use App\Http\Requests\Api\V1\RegisterRequest;
use App\Http\Resources\Api\V1\UserResource;
use App\Services\AuthService;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService) {}

    /**
     * @unauthenticated
     */
    public function register(RegisterRequest $request)
    {
        $user = $this->authService->register($request->validated());

        return response()->json([
            'message' => 'Registered successfully',
            'data'    => new UserResource($user),
        ]);
    }

    /**
     * @unauthenticated
     */
    public function login(LoginRequest $request)
    {
        $token = $this->authService->attemptLogin($request->validated());

        if (!$token) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return response()->json([
            'message'    => 'Logged in successfully',
            'token'      => $token,
            'type'       => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ]);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Logged out successfully']);
    }

    public function me()
    {
        return new UserResource(auth()->user());
    }
}
