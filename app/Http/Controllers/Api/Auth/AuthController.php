<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Response;
use App\Actions\Auth\LoginAction;
use Illuminate\Http\JsonResponse;
use App\Actions\Auth\RegisterAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;

class AuthController extends Controller
{
    public function register(RegisterRequest $request, RegisterAction $action): JsonResponse
    {
        $user = $action->execute($request->validated());
        $token = $user->createToken('auth_token')->plainTextToken;

        return apiResponse(
            Response::HTTP_CREATED,
            'success',
            'User registered successfully',
            [
                'user' => new UserResource($user),
                'token' => $token
            ]
        );
    }

    public function login(LoginRequest $request, LoginAction $action): JsonResponse
    {
        $result = $action->execute($request->validated());

        return apiResponse(
            Response::HTTP_OK,
            'success',
            'Logged in successfully',
            [
                'user' => new UserResource($result['user']),
                'token' => $result['token']
            ]
        );
    }

    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return apiResponse(
            Response::HTTP_OK,
            'success',
            'Logged out successfully'
        );
    }

}