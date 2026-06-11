<?php
namespace App\Viajes\Controllers;

use App\Viajes\Models\SeguimientoViaje;
use Exception;

class ViajeController {

    function iniciarViaje($info) {
    $cancelado = SeguimientoViaje::where('programacion_viaje_id', $info['programacion_viaje_id'])
                                 ->where('estado', 'cancelado')
                                 ->first();
    if ($cancelado)
        throw new Exception("No se puede iniciar un viaje cancelado", 2);

    $seguimiento = new SeguimientoViaje();
    $seguimiento->programacion_viaje_id = $info['programacion_viaje_id'];
    $seguimiento->fecha = $info['fecha'];
    $seguimiento->hora = $info['hora'];
    $seguimiento->estado = 'en_transito';
    $seguimiento->novedad = $info['novedad'] ?? null;
    $seguimiento->save();

    return $seguimiento;
}

    function actualizarEstado($id, $info) {
        $seguimiento = SeguimientoViaje::find($id);
        if (empty($seguimiento))
            throw new Exception("Seguimiento no encontrado", 1);

        $estadosValidos = ['programado', 'en_transito', 'retrasado', 'finalizado', 'cancelado'];
        if (!in_array($info['estado'], $estadosValidos))
            throw new Exception("Estado no valido", 2);

        $seguimiento->estado = $info['estado'];
        $seguimiento->novedad = $info['novedad'] ?? $seguimiento->novedad;
        $seguimiento->save();

        return $seguimiento;
    }

    function registrarNovedad($info) {
        $seguimiento = new SeguimientoViaje();
        $seguimiento->programacion_viaje_id = $info['programacion_viaje_id'];
        $seguimiento->fecha = $info['fecha'];
        $seguimiento->hora = $info['hora'];
        $seguimiento->estado = $info['estado'];
        $seguimiento->novedad = $info['novedad'];
        $seguimiento->save();

        return $seguimiento;
    }

    function finalizarViaje($id, $info) {
        $seguimiento = SeguimientoViaje::find($id);
        if (empty($seguimiento))
            throw new Exception("Seguimiento no encontrado", 1);

        if ($seguimiento->estado === 'programado')
            throw new Exception("No se puede finalizar un viaje no iniciado", 2);

        if ($seguimiento->estado === 'finalizado')
            throw new Exception("El viaje ya esta finalizado", 2);

        $seguimiento->estado = 'finalizado';
        $seguimiento->novedad = $info['novedad'] ?? null;
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