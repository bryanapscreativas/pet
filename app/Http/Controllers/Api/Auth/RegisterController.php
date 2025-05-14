<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\RegisterStoreRequest;

class RegisterController extends Controller
{
    public function __invoke(RegisterStoreRequest $request): JsonResponse
    {
        $user = User::create([
            'full_name' => $request->validated('full_name'),
            'email' => $request->validated('email'),
            'password' => Hash::make($request->validated('password')),
            'phone' => $request->validated('phone'),
            'whatsapp' => $request->validated('whatsapp'),
            'profile_picture_path' => $request->validated('profile_picture') ? $request->validated('profile_picture')->store('pet/users') : null,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'User registered successfully',
            'data' => [
                'user' => $user,
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]
        ], JsonResponse::HTTP_OK);
    }
}
