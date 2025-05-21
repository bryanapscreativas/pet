<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\RegisterStoreRequest;

class RegisterController extends Controller
{
    public function __invoke(RegisterStoreRequest $request): JsonResponse
    {
        // User::create() automáticamente dispara el evento creating que generará el ULID
        $user = User::create([
            'full_name' => $request->validated('full_name'),
            'email' => $request->validated('email'),
            'password' => $request->validated('password'), // Se hashea automáticamente por el cast
            'phone' => $request->validated('phone'),
            'whatsapp' => $request->validated('whatsapp'),
            'profile_picture_path' => $request->validated('profile_picture') ? $request->validated('profile_picture')->store('pet/users') : null,
        ]);

        // Asignar el rol de usuario
        $role = Role::where('name', Role::USER)->first();
        $user->roles()->attach($role->id);

        return response()->json([
            'message' => 'User registered successfully',
            'data' => $user->load(['pets', 'roles']),
        ]);
    }
}
