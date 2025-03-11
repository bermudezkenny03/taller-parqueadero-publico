<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo',
        'placa',
        'horas',
        'tarifa',
        'fecha_entrada',
        'fecha_salida',
        'estacionado',
    ];

    protected $dates = [
        'fecha_entrada',
        'fecha_salida',
    ];
}
