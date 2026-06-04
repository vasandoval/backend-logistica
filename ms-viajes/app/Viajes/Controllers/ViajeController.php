<?php
namespace App\Viajes\Controllers;

use App\Viajes\Models\SeguimientoViaje;
use Exception;

class ViajeController {

    function iniciarViaje($datos) {
        $existe = SeguimientoViaje::where('programacion_viaje_id', $datos['programacion_viaje_id'])
                                  ->first();
        if (empty($existe))
            throw new Exception("No existe programacion para ese viaje", 1);

        $cancelado = SeguimientoViaje::where('programacion_viaje_id', $datos['programacion_viaje_id'])
                                     ->where('estado', 'cancelado')
                                     ->first();
        if ($cancelado)
            throw new Exception("No se puede iniciar un viaje cancelado", 2);

        $seguimiento = new SeguimientoViaje();
        $seguimiento->programacion_viaje_id = $datos['programacion_viaje_id'];
        $seguimiento->fecha = $datos['fecha'];
        $seguimiento->hora = $datos['hora'];
        $seguimiento->estado = 'en_transito';
        $seguimiento->novedad = $datos['novedad'] ?? null;
        $seguimiento->save();

        return $seguimiento;
    }

    function actualizarEstado($id, $datos) {
        $seguimiento = SeguimientoViaje::find($id);
        if (empty($seguimiento))
            throw new Exception("Seguimiento no encontrado", 1);

        $estadosValidos = ['programado', 'en_transito', 'retrasado', 'finalizado', 'cancelado'];
        if (!in_array($datos['estado'], $estadosValidos))
            throw new Exception("Estado no valido", 2);

        $seguimiento->estado = $datos['estado'];
        $seguimiento->novedad = $datos['novedad'] ?? $seguimiento->novedad;
        $seguimiento->save();

        return $seguimiento;
    }

    function registrarNovedad($datos) {
        $seguimiento = new SeguimientoViaje();
        $seguimiento->programacion_viaje_id = $datos['programacion_viaje_id'];
        $seguimiento->fecha = $datos['fecha'];
        $seguimiento->hora = $datos['hora'];
        $seguimiento->estado = $datos['estado'];
        $seguimiento->novedad = $datos['novedad'];
        $seguimiento->save();

        return $seguimiento;
    }

    function finalizarViaje($id, $datos) {
        $seguimiento = SeguimientoViaje::find($id);
        if (empty($seguimiento))
            throw new Exception("Seguimiento no encontrado", 1);

        if ($seguimiento->estado === 'programado')
            throw new Exception("No se puede finalizar un viaje no iniciado", 2);

        if ($seguimiento->estado === 'finalizado')
            throw new Exception("El viaje ya esta finalizado", 2);

        $seguimiento->estado = 'finalizado';
        $seguimiento->novedad = $datos['novedad'] ?? null;
        $seguimiento->save();

        return $seguimiento;
    }

    function consultarHistorial($programacionId) {
        $historial = SeguimientoViaje::where('programacion_viaje_id', $programacionId)->get();
        if ($historial->isEmpty())
            throw new Exception("No hay registros para esta programacion", 1);

        return $historial;
    }

    function consultarPorEstado($estado) {
        return SeguimientoViaje::where('estado', $estado)->get();
    }
}