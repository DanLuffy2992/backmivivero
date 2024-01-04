<?php

use App\Http\Controllers\API\PlantasController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Rutas públicas sin autenticación
Route::prefix('plantas')->group(function () {
    Route::get('/', [PlantasController::class, 'index']); // Mostrar todas las plantas
    Route::get('/{id}', [PlantasController::class, 'show']); // Mostrar detalles de una planta específica
});

// Rutas protegidas que requieren autenticación
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/plantas', [PlantasController::class, 'store']); // Crear una nueva planta
    Route::put('/plantas/{id}', [PlantasController::class, 'update']); // Actualizar detalles de una planta
    Route::delete('/plantas/{id}', [PlantasController::class, 'destroy']); // Eliminar una planta

    // Otras rutas protegidas si las tienes...
    
    // Ruta para obtener el usuario autenticado
    Route::get('/user', function () {
        return auth()->user();
    });
});
Route::post('signup',[AuthController::class,'signup']);

Route::post('login',[AuthController::class,'login']);

