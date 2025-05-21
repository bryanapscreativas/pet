<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Role\StoreRequest;
use App\Http\Requests\Role\UpdateRequest;

class RoleController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $role = Role::paginate($request->get('per_page', 10));
        return response()->json($role);
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $role = Role::create($request->only('name'));
        return response()->json($role);
    }

    public function show(Role $role): JsonResponse
    {
        return response()->json($role);
    }

    public function update(UpdateRequest $request, Role $role): JsonResponse
    {
        $role->update($request->only('name'));
        return response()->json($role);
    }
}
