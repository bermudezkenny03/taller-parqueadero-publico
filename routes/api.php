<?php
use App\Http\Controllers\VehiculoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TarifaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Route::get('/vehiculos', [VehiculoController::class, 'index']);
// Route::post('/vehiculos', [VehiculoController::class, 'store']);

// Route::post('/calcular-tarifa', [TarifaController::class, 'calcular']);

// Route::get('/vehiculos/{placa}', [TarifaController::class, 'get']);

// Route::get('/vehiculos-todo', [TarifaController::class, 'todosGet']);


Route::post('/vehiculos/entrada', [TarifaController::class, 'registrarEntrada']);

// Registrar la salida de un vehículo
Route::post('/vehiculos/salida', [TarifaController::class, 'registrarSalida']);

// Obtener un vehículo por placa
Route::get('/vehiculos/{placa}', [TarifaController::class, 'get']);

// Listar todos los vehículos con paginación
Route::get('/vehiculos', [TarifaController::class, 'todosGet']);

