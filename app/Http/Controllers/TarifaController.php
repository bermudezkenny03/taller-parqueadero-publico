<?php

namespace App\Http\Controllers;

use App\Services\TarifaService;
use Illuminate\Http\Request;
use App\Models\Vehiculo;


class TarifaController extends Controller
{
    protected $tarifaService;

    public function __construct(TarifaService $tarifaService)
    {
        $this->tarifaService = $tarifaService;
    }

    // public function calcular(Request $request)
    // {
    //     $tipo = $request->input('tipo'); // 'moto', 'carro', 'camion'
    //     $placa = $request->input('placa'); // Placa del vehículo
    //     $horas = $request->input('horas'); // Horas de estacionamiento

    //     // Validar que las horas estén presentes
    //     if (!$horas) {
    //         return response()->json(['error' => 'Las horas de estacionamiento son requeridas'], 400);
    //     }

    //     // Calcular la tarifa
    //     $tarifa = $this->tarifaService->calcularTarifa($tipo, $horas);

    //     return response()->json([
    //         'tipo' => $tipo,
    //         'placa' => $placa,
    //         'horas' => $horas,
    //         'tarifa' => $tarifa,
    //     ]);
    // }

    public function calcular(Request $request)
{
    $tipo = $request->input('tipo');
    $placa = $request->input('placa');
    $horas = $request->input('horas');

    if (!$horas) {
        return response()->json(['error' => 'Las horas de estacionamiento son requeridas'], 400);
    }

    // Calcular la tarifa
    $tarifa = $this->tarifaService->calcularTarifa($tipo, $horas);

    // Buscar el vehículo por placa o crearlo si no existe
    $vehiculo = Vehiculo::firstOrNew(['placa' => $placa]);
    $vehiculo->tipo = $tipo;
    $vehiculo->horas = $horas;
    $vehiculo->tarifa = $tarifa;
    $vehiculo->save(); // Guarda el vehículo con la tarifa actualizada

    return response()->json([
        'tipo' => $tipo,
        'placa' => $placa,
        'horas' => $horas,
        'tarifa' => $tarifa,
    ]);
}


    public function get($placa)
{
    // Buscar el vehículo por placa
    $vehiculo = Vehiculo::where('placa', $placa)->first();

    // Verificar si el vehículo existe
    if (!$vehiculo) {
        return response()->json(['error' => 'Vehículo no encontrado'], 404);
    }

    // Devolver la información del vehículo
    return response()->json([
        'tipo' => $vehiculo->tipo,
        'placa' => $vehiculo->placa,
        'horas' => $vehiculo->horas,
        'tarifa' => $vehiculo->tarifa,
    ]);
}

public function todosGet()
{
    // Obtener todos los vehículos
    $vehiculos = Vehiculo::all();

    // Verificar si hay vehículos registrados
    if ($vehiculos->isEmpty()) {
        return response()->json(['error' => 'No hay vehículos registrados'], 404);
    }

    // Retornar la lista de vehículos
    return response()->json($vehiculos);
}

}