<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePetRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'breed' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'description' => 'nullable|string',
            'sterilized' => 'required|boolean',
            'conditions' => 'sometimes|array',
            'conditions.*.name' => 'required_with:conditions|string|max:255',
            'treatments' => 'sometimes|array',
            'treatments.*.name' => 'required_with:treatments|string|max:255',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'conditions.*.name.required_with' => 'El nombre del padecimiento es obligatorio',
            'treatments.*.name.required_with' => 'El nombre del tratamiento es obligatorio',
        ];
    }
}
