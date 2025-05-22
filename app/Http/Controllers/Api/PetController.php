<?php

namespace App\Http\Controllers\Api;

use App\Models\Pet;
use App\Models\Disease;
use App\Models\Treatment;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePetRequest;

class PetController extends Controller
{
    /**
     * Store a newly created pet in storage.
     *
     * @param StorePetRequest $request
     * @return JsonResponse
     */
    public function store(StorePetRequest $request): JsonResponse
    {
        return DB::transaction(function () use ($request) {
            // Crear la mascota
            $pet = new Pet($request->only([
                'name',
                'species',
                'breed',
                'gender',
                'birth_date',
                'description',
                'sterilized',
            ]));

            // Asignar el usuario autenticado
            $pet->user_id = Auth::id();
            $pet->save();

            // Sincronizar condiciones (padecimientos)
            $this->syncConditions($request, $pet);

            // Sincronizar tratamientos
            $this->syncTreatments($request, $pet);

            // Cargar las relaciones para la respuesta
            $pet->load('diseases', 'treatments');

            return response()->json([
                'message' => 'Mascota registrada exitosamente',
                'data' => $pet,
            ], 201);
        });
    }

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
     * Sincroniza las condiciones (padecimientos) de la mascota
     *
     * @param StorePetRequest $request
     * @param Pet $pet
     * @return void
     */
    private function syncConditions(StorePetRequest $request, Pet $pet): void
    {
        if (! $request->has('conditions') || ! is_array($request->conditions)) {
            // Si no hay condiciones nuevas, eliminar todas las existentes
            $pet->diseases()->sync([]);
            return;
        }

        // Obtener solo los nombres de las condiciones
        $conditionNames = collect($request->conditions)
            ->filter(fn(array $condition) => ! empty($condition['name']))
            ->pluck('name')
            ->unique()
            ->toArray();

        // Obtener o crear las enfermedades y sincronizarlas
        $diseases = collect($conditionNames)->map(function($name) {
            return Disease::firstOrCreate(['name' => $name]);
        });

        // Sincronizar las enfermedades con la mascota
        $pet->diseases()->sync($diseases->pluck('id')->toArray());
    }

    /**
     * Sincroniza los tratamientos de la mascota
     *
     * @param StorePetRequest $request
     * @param Pet $pet
     * @return void
     */
    private function syncTreatments(StorePetRequest $request, Pet $pet): void
    {
        if (! $request->has('treatments') || ! is_array($request->treatments)) {
            // Si no hay tratamientos nuevos, eliminar todos los existentes
            $pet->treatments()->sync([]);
            return;
        }

        // Obtener solo los nombres de los tratamientos
        $treatmentNames = collect($request->treatments)
            ->filter(fn(array $treatment) => ! empty($treatment['name']))
            ->pluck('name')
            ->unique()
            ->toArray();

        // Obtener o crear los tratamientos y sincronizarlos
        $treatments = collect($treatmentNames)->map(function($name) {
            return Treatment::firstOrCreate(['name' => $name]);
        });

        // Sincronizar los tratamientos con la mascota
        $pet->treatments()->sync($treatments->pluck('id')->toArray());
    }

    /**
     * Update the specified pet in storage.
     *
     * @param StorePetRequest $request
     * @param Pet $pet
     * @return JsonResponse
     */
    public function update(StorePetRequest $request, Pet $pet): JsonResponse
    {
        if ($pet->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'No autorizado para actualizar esta mascota'
            ], 403);
        }

        return DB::transaction(function () use ($request, $pet) {
            // Actualizar los datos básicos de la mascota
            $pet->update($request->only([
                'name',
                'species',
                'breed',
                'gender',
                'birth_date',
                'description',
                'sterilized',
            ]));

            // Sincronizar condiciones (padecimientos)
            $this->syncConditions($request, $pet);

            // Sincronizar tratamientos
            $this->syncTreatments($request, $pet);

            // Cargar las relaciones para la respuesta
            $pet->load('diseases', 'treatments');

            return response()->json([
                'message' => 'Mascota actualizada exitosamente',
                'data' => $pet,
            ]);
        });
    }
}
