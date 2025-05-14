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
     * Sincroniza las condiciones (padecimientos) de la mascota
     *
     * @param StorePetRequest $request
     * @param Pet $pet
     * @return void
     */
    private function syncConditions(StorePetRequest $request, Pet $pet): void
    {
        if (! $request->has('conditions') || ! is_array($request->conditions)) {
            // Si no hay condiciones nuevas, sincronizar con las existentes
            $pet->diseases()->sync([]);
            return;
        }

        $conditions = collect($request->conditions)
            ->filter(fn(array $condition) => ! empty($condition['name']))
            ->mapWithKeys(fn(array $condition) => [
                $condition['name'] => [
                    'treatment' => $condition['treatment'] ?? null,
                    'diagnosis_date' => $condition['diagnosis_date'] ?? now(),
                    'notes' => $condition['notes'] ?? null,
                ],
            ]);

        // Obtener IDs de enfermedades existentes
        $existingDiseases = $pet->diseases->pluck('id')->toArray();
        
        // Crear nuevas enfermedades y obtener todas las IDs necesarias
        $diseaseIds = collect($conditions)->map(function($data, $name) {
            $disease = Disease::firstOrCreate(['name' => $name]);
            return $disease->id;
        })->toArray();

        // Sincronizar las enfermedades con los datos pivote
        $pet->diseases()->sync($diseaseIds, false);

        // Actualizar los datos pivote para cada enfermedad
        foreach ($conditions as $name => $data) {
            $disease = Disease::firstWhere('name', $name);
            if ($disease) {
                $pet->diseases()->updateExistingPivot($disease->id, $data);
            }
        }

        // Eliminar enfermedades que ya no están en la lista
        $diseasesToRemove = array_diff($existingDiseases, $diseaseIds);
        if (!empty($diseasesToRemove)) {
            $pet->diseases()->detach($diseasesToRemove);
        }
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
            // Si no hay tratamientos nuevos, sincronizar con los existentes
            $pet->treatments()->sync([]);
            return;
        }

        $treatments = collect($request->treatments)
            ->filter(fn(array $treatment) => ! empty($treatment['name']))
            ->mapWithKeys(fn(array $treatmentData) => [
                $treatmentData['name'] => [
                    'start_date' => $treatmentData['start_date'] ?? now(),
                    'end_date' => $treatmentData['end_date'] ?? null,
                    'dosage' => $treatmentData['dosage'] ?? null,
                    'frequency' => $treatmentData['frequency'] ?? null,
                    'notes' => $treatmentData['notes'] ?? null,
                    'is_completed' => $treatmentData['is_completed'] ?? false,
                ],
            ]);

        // Obtener IDs de tratamientos existentes
        $existingTreatments = $pet->treatments->pluck('id')->toArray();
        
        // Crear nuevos tratamientos y obtener todas las IDs necesarias
        $treatmentIds = collect($treatments)->map(function($data, $name) {
            $treatment = Treatment::firstOrCreate([
                'name' => $name,
            ]);
            return $treatment->id;
        })->toArray();

        // Sincronizar los tratamientos con los datos pivote
        $pet->treatments()->syncWithoutDetaching($treatmentIds);

        // Actualizar los datos pivote para cada tratamiento
        foreach ($treatmentIds as $treatmentId) {
            $pet->treatments()->updateExistingPivot($treatmentId, [
                'start_date' => now(),
                'is_completed' => false,
                'notes' => null,
            ]);
        }

        // Actualizar los datos pivote para cada tratamiento
        foreach ($treatments as $name => $data) {
            $treatment = Treatment::firstWhere('name', $name);
            if ($treatment) {
                $pet->treatments()->updateExistingPivot($treatment->id, $data);
            }
        }

        // Eliminar tratamientos que ya no están en la lista
        $treatmentsToRemove = array_diff($existingTreatments, $treatmentIds);
        if (!empty($treatmentsToRemove)) {
            $pet->treatments()->detach($treatmentsToRemove);
        }
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
