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

    /**
     * Registra la entrada de un vehículo al parqueadero.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function registrarEntrada(Request $request)
    {
        $request->validate([
            'tipo' => 'required|in:moto,carro,camion',
            'placa' => 'required|string|min:5|max:10|unique:vehiculos,placa',
        ]);

        $vehiculo = new Vehiculo();
        $vehiculo->tipo = $request->input('tipo');
        $vehiculo->placa = $request->input('placa');
        $vehiculo->fecha_entrada = now(); 
        $vehiculo->estacionado = true; 
        $vehiculo->save();

        return response()->json([
            'mensaje' => 'Vehículo registrado con éxito',
            'vehiculo' => $vehiculo,
        ], 201);
    }

    /**
     * Registra la salida de un vehículo y calcula la tarifa.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function registrarSalida(Request $request)
    {
        $request->validate([
            'placa' => 'required|string|min:5|max:10',
        ]);

        $vehiculo = Vehiculo::where('placa', $request->input('placa'))->first();

        if (!$vehiculo) {
            return response()->json(['error' => 'Vehículo no encontrado'], 404);
        }


        if (!$vehiculo->estacionado) {
            return response()->json(['error' => 'El vehículo ya salió del parqueadero'], 400);
        }

        $vehiculo->fecha_salida = now();
        $vehiculo->estacionado = false;

        $segundos = $vehiculo->fecha_entrada->diffInSeconds($vehiculo->fecha_salida);
        $horas = $segundos / 3600; 

        $tarifa = $this->tarifaService->calcularTarifa($vehiculo->tipo, $horas);

        $vehiculo->horas = $horas;
        $vehiculo->tarifa = $tarifa;
        $vehiculo->save();

        return response()->json([
            'mensaje' => 'Vehículo salió del parqueadero',
            'vehiculo' => $vehiculo,
            'tarifa' => $tarifa,
        ]);
    }

    /**
     * Obtiene un vehículo por su placa.
     *
     * @param string $placa
     * @return \Illuminate\Http\JsonResponse
     */
    public function get($placa)
    {
        $vehiculo = Vehiculo::where('placa', $placa)->first();

        if (!$vehiculo) {
            return response()->json(['error' => 'Vehículo no encontrado'], 404);
        }

        return response()->json([
            'vehiculo' => $vehiculo,
        ]);
    }

    /**
     * Lista todos los vehículos registrados con paginación.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function todosGet(Request $request)
    {
    
        $vehiculos = Vehiculo::all();
        return response()->json($vehiculos);

        if ($vehiculos->isEmpty()) {
            return response()->json(['error' => 'No hay vehículos registrados'], 404);
        }

        return response()->json($vehiculos);
    }
}