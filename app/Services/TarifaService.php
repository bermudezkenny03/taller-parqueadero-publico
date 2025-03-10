<?php

namespace App\Services;

class TarifaService
{
    public function calcularTarifa(string $tipo, float $horas): int
    {
        switch ($tipo) {
            case 'moto':
                return $this->calcularTarifaMoto($horas);
            case 'carro':
                return $this->calcularTarifaCarro($horas);
            case 'camion':
                return $this->calcularTarifaCamion($horas);
            default:
                throw new \InvalidArgumentException("Tipo de vehículo no válido");
        }
    }

    private function calcularTarifaMoto(float $horas): int
    {
        if ($horas <= 1) {
            return 1000;
        } else {
            $total = 1000 + ($horas - 1) * 500;
            return $this->redondear($total);
        }
    }

    private function calcularTarifaCarro(float $horas): int
    {
        if ($horas <= 1) {
            return 2000;
        } else {
            $total = 2000 + ($horas - 1) * 1000;
            return $this->redondear($total);
        }
    }

    // private function calcularTarifaCamion(float $horas): int
    // {
    //     if ($this->sorteo()) {
    //         return 0; // Sorteo aplicado, tarifa gratis.
    //     }
    //     if ($horas <= 12) {
    //         return 10000;
    //     } elseif ($horas <= 24) {
    //         return 15000;
    //     } else {
    //         $total = 15000 * (intdiv($horas, 24)) + 15000 * (($horas % 24) / 24);
    //         return $this->redondear($total);
    //     }
    // }

    private function calcularTarifaCamion(float $horas): int
{
    if ($this->sorteo()) {
        return 0; // Sorteo aplicado, tarifa gratis.
    }
    if ($horas <= 12) {
        return 10000;
    } elseif ($horas <= 24) {
        return 15000;
    } else {
        // Calcular días completos y fracción de horas adicionales
        $diasCompletos = intdiv($horas, 24);
        $horasAdicionales = $horas % 24;
        $tarifaDiasCompletos = $diasCompletos * 15000;
        $tarifaHorasAdicionales = ($horasAdicionales / 24) * 15000;
        $total = $tarifaDiasCompletos + $tarifaHorasAdicionales;
        return $this->redondear($total);
    }
}

    private function sorteo(): bool
    {
        return rand(1, 1000) == 1;
    }

    private function redondear(float $cantidad): int
    {
        return ceil($cantidad / 100) * 100;
    }
}