<?php

namespace Tests\Feature;

use App\Services\TarifaService;
use Tests\TestCase;

class TarifaServiceTest extends TestCase
{
    public function test_calcular_tarifa_moto()
    {
        $service = new TarifaService();
        $this->assertEquals(1000, $service->calcularTarifa('moto', 0.5));
        $this->assertEquals(1300, $service->calcularTarifa('moto', 1.5));
    }

    public function test_calcular_tarifa_carro()
    {
        $service = new TarifaService();
        $this->assertEquals(2000, $service->calcularTarifa('carro', 0.5));
        $this->assertEquals(3500, $service->calcularTarifa('carro', 2.5));
    }

    // public function test_calcular_tarifa_camion()
    // {
    //     $service = new TarifaService();
    //     $this->assertContains($service->calcularTarifa('camion', 10), [0, 10000]);
    //     $this->assertContains($service->calcularTarifa('camion', 25), [0, 30000]);
    // }

    public function test_calcular_tarifa_camion()
{
    $service = new TarifaService();
    $this->assertContains($service->calcularTarifa('camion', 10), [0, 10000]);
    $this->assertEquals(15700, $service->calcularTarifa('camion', 25));
}
}