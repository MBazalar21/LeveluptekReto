<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Swapi\PeopleController;
use Illuminate\Support\Facades\Route;


// Rutas públicas
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Rutas protegidas con Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->prefix('people')->group(function () {
    Route::get('/', [PeopleController::class, 'list']);      // Listar personajes
    Route::get('/{id}', [PeopleController::class, 'show']);   // Detalle de un personaje
    Route::post('/import/{id}', [PeopleController::class, 'importPeople']);
});