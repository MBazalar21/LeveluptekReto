<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


// Rutas públicas
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
