<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Api\PetController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PublicPetController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;

// Rutas protegidas por autenticación
Route::middleware('auth:sanctum')->group(function () {
    Route::get('user/{user}', [UserController::class, 'show']);
    Route::put('user/{user}', [UserController::class, 'update']);
    Route::get('user/{user}/pets', [UserController::class, 'getPets']);
    Route::post('pets', [PetController::class, 'store']);
    Route::put('pets/{pet}', [PetController::class, 'update']);

    Route::apiResource('roles', RoleController::class)->only(['index', 'show', 'store', 'update']);
});

// Rutas públicas
Route::get('pets/{id}', [PublicPetController::class, 'show']);
Route::post('pets/nfc', [PublicPetController::class, 'findByNfc']);
Route::get('user/{user}/profile_picture', [UserController::class, 'getImage'])->name('profile_picture');

// Rutas de autenticación
Route::post('register', RegisterController::class);
Route::post('login', LoginController::class);
