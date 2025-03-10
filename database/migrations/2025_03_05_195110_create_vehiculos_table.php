<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiculosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->id(); 
            $table->string('tipo'); // 'moto', 'carro', 'camion'
            $table->string('placa')->unique(); // Placa del vehículo
            $table->float('horas')->default(0); // Horas de estacionamiento
            $table->integer('tarifa')->nullable(); // Tarifa a pagar 
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehiculos');
    }
}
