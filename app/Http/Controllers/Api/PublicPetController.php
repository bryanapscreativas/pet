<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PublicPetController extends Controller
{
    /**
     * Obtener los datos de una mascota por su ID (ULID)
     *
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $pet = Pet::with(['diseases', 'treatments', 'user'])
            ->findOrFail($id);

        return response()->json($pet);
    }

    /**
     * Buscar mascota por tag NFC
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function findByNfc(Request $request): JsonResponse
    {
        $request->validate([
            'nfc_tag' => 'required|string|max:255',
        ]);

        $pet = Pet::with(['diseases', 'treatments'])
            ->where('id', $request->nfc_tag)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => $pet
        ]);
    }
}
