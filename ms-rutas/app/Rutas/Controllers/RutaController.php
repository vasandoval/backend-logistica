<?php
namespace App\Rutas\Controllers;

use App\Rutas\Models\Ruta;
use App\Rutas\Models\ProgramacionViaje;
use Exception;

class RutaController {

    function listarRutas() {
        return Ruta::all();
    }

    function buscarRutaPorCiudad($ciudad) {
        return Ruta::where('ciudad_origen', 'like', "%$ciudad%")
                   ->orWhere('ciudad_destino', 'like', "%$ciudad%")
                   ->get();
    }

    function crearRuta($info) {
        if ($info['distancia'] <= 0)
            throw new Exception("La distancia debe ser mayor a cero", 2);

        $existe = Ruta::where('ciudad_origen', $info['ciudad_origen'])
                      ->where('ciudad_destino', $info['ciudad_destino'])
                      ->first();
        if ($existe) throw new Exception("Esta ruta ya existe", 2);

        $ruta = new Ruta();
        $ruta->ciudad_origen = $info['ciudad_origen'];
        $ruta->ciudad_destino = $info['ciudad_destino'];
        $ruta->distancia = $info['distancia'];
        $ruta->tiempo_estimado = $info['tiempo_estimado'];
        $ruta->observaciones = $info['observaciones'] ?? null;
        $ruta->save();

        return $ruta;
    }

    function editarRuta($id, $info) {
        $ruta = Ruta::find($id);
        if (empty($ruta)) throw new Exception("Ruta no encontrada", 1);

        if (isset($info['distancia']) && $info['distancia'] <= 0)
            throw new Exception("La distancia debe ser mayor a cero", 2);

        if (isset($info['distancia'])) $ruta->distancia = $info['distancia'];
        if (isset($info['tiempo_estimado'])) $ruta->tiempo_estimado = $info['tiempo_estimado'];
        if (isset($info['observaciones'])) $ruta->observaciones = $info['observaciones'];
        $ruta->save();

        return $ruta;
    }

    // ---- PROGRAMACIONES ----

    function listarProgramaciones() {
        return ProgramacionViaje::all();
    }

    function buscarProgramacionPorConductor($conductorId) {
        return ProgramacionViaje::where('conductor_id', $conductorId)->get();
    }

    function buscarProgramacionPorVehiculo($vehiculoId) {
        return ProgramacionViaje::where('vehiculo_id', $vehiculoId)->get();
    }

    function buscarProgramacionPorEstado($estado) {
        return ProgramacionViaje::where('estado', $estado)->get();
    }

    function buscarProgramacionPorFecha($fecha) {
        return ProgramacionViaje::where('fecha_salida', $fecha)->get();
    }

    function programarViaje($info) {
        $cond_Ocupado = ProgramacionViaje::where('conductor_id', $info['conductor_id'])
                                             ->where('estado', 'programado')
                                             ->first();
        if ($cond_Ocupado) throw new Exception("El conductor no está disponible", 2);

        $vehi_Ocupado = ProgramacionViaje::where('vehiculo_id', $info['vehiculo_id'])
                                            ->where('estado', 'programado')
                                            ->first();
        if ($vehi_Ocupado) throw new Exception("El vehiculo no está disponible", 2);

        $programacion = new ProgramacionViaje();
        $programacion->conductor_id = $info['conductor_id'];
        $programacion->vehiculo_id = $info['vehiculo_id'];
        $programacion->ruta_id = $info['ruta_id'];
        $programacion->fecha_salida = $info['fecha_salida'];
        $programacion->hora_salida = $info['hora_salida'];
        $programacion->fecha_estimada_llegada = $info['fecha_estimada_llegada'];
        $programacion->observaciones = $info['observaciones'] ?? null;
        $programacion->estado = 'programado';
        $programacion->save();

        return $programacion;
    }

    function reprogramarViaje($id, $info) {
        $programacion = ProgramacionViaje::find($id);
        if (empty($programacion)) throw new Exception("Programacion no encontrada", 1);
        if ($programacion->estado === 'cancelado') throw new Exception("No se puede reprogramar un viaje cancelado", 2);

        if (isset($info['fecha_salida'])) $programacion->fecha_salida = $info['fecha_salida'];
        if (isset($info['hora_salida'])) $programacion->hora_salida = $info['hora_salida'];
        if (isset($info['fecha_estimada_llegada'])) $programacion->fecha_estimada_llegada = $info['fecha_estimada_llegada'];
        if (isset($info['conductor_id'])) $programacion->conductor_id = $info['conductor_id'];
        if (isset($info['vehiculo_id'])) $programacion->vehiculo_id = $info['vehiculo_id'];
        if (isset($info['observaciones'])) $programacion->observaciones = $info['observaciones'];
        $programacion->save();

        return $programacion;
    }
}