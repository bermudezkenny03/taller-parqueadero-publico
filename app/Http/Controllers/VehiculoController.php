<?php

namespace App\Http\Controllers;
use App\Models\Vehiculo;

use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    public function index()
    {
        $vehiculos = Vehiculo::all();
        return response()->json($vehiculos);
    }

    public function store(Request $request)
    {
        $vehiculo = Vehiculo::create($request->all());
        return response()->json($vehiculo, 201);
    }
}
