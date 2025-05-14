<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class UserController extends Controller
{
    /**
     * Obtener el perfil del usuario autenticado
     *
     * @return JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        return response()->json([
            'data' => $user,
        ]);
    }

    /**
     * Obtener el perfil del usuario autenticado con sus mascotas, enfermedades y tratamientos
     *
     * @return JsonResponse
     */
    public function getPets(User $user): JsonResponse
    {
        // Cargar las relaciones necesarias con eager loading
        $user->load([
            'pets' => function ($query) {
                $query->latest('created_at')
                    ->with([
                        'diseases' => function ($q) {
                            $q->select('diseases.id', 'name', 'description')
                                ->withPivot(['diagnosis_date', 'treatment', 'notes']);
                        },
                        'treatments' => function ($q) {
                            $q->select('treatments.id', 'name', 'description')
                                ->withPivot(['start_date', 'end_date', 'dosage', 'frequency', 'notes', 'is_completed']);
                        }
                    ]);
            }
        ]);

        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }

    public function getImage(User $user): StreamedResponse
    {
        return Storage::response($user->profile_picture_path);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $user->update($request->only([
            'full_name',
            'email',
            'phone',
            'address',
        ]));
        
        if ($request->has('password')) {
            $user->update([
                'password' => bcrypt($request->password),
            ]);
        }

        if ($request->hasFile('profile_picture')) {
            $request->merge([
                'profile_picture_path' => $request->file('profile_picture')->store('pet/users'),
            ]);

            if (Storage::exists($user->profile_picture_path)) {
                Storage::delete($user->profile_picture_path);
            }
        }
        
        return response()->json($user->load(['pets']));
    }
}
