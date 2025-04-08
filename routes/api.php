<?php

use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\FanaticoController;
use App\Http\Controllers\Swapi\PlanetController;
use App\Http\Controllers\Swapi\PeopleController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middlewares\RoleMiddleware;


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

Route::middleware('auth:sanctum')->prefix('planet')->group(function () {
    Route::get('/', [PlanetController::class, 'list']);      // Listar personajes
    Route::get('/{id}', [PlanetController::class, 'show']);   // Detalle de un personaje
    Route::post('/import/{id}', [PlanetController::class, 'import']);
});

Route::middleware('auth:sanctum')->get('/query-logs', function () {
    return response()->json([
        'logs' => auth()->user()->queryLogs()->latest()->get()
    ]);
});

Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/consultas', [AdminController::class, 'todasConsultas']);
    Route::get('/usuarios', [AdminController::class, 'listarUsuarios']);
    Route::put('/usuarios/{id}', [AdminController::class, 'editarUsuario']);
    Route::delete('/usuarios/{id}', [AdminController::class, 'eliminarUsuario']);
});

Route::middleware(['auth:sanctum', 'role:fanatico'])->group(function () {
    Route::get('/mis-consultas', [FanaticoController::class, 'misConsultas']);
    Route::put('/mi-perfil', [FanaticoController::class, 'editarPerfil']);
});