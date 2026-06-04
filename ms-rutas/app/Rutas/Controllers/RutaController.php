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

    function crearRuta($datos) {
        if ($datos['distancia'] <= 0)
            throw new Exception("La distancia debe ser mayor a cero", 2);

        $existe = Ruta::where('ciudad_origen', $datos['ciudad_origen'])
                      ->where('ciudad_destino', $datos['ciudad_destino'])
                      ->first();
        if ($existe) throw new Exception("Esta ruta ya existe", 2);

        $ruta = new Ruta();
        $ruta->ciudad_origen = $datos['ciudad_origen'];
        $ruta->ciudad_destino = $datos['ciudad_destino'];
        $ruta->distancia = $datos['distancia'];
        $ruta->tiempo_estimado = $datos['tiempo_estimado'];
        $ruta->observaciones = $datos['observaciones'] ?? null;
        $ruta->save();

        return $ruta;
    }

    function editarRuta($id, $datos) {
        $ruta = Ruta::find($id);
        if (empty($ruta)) throw new Exception("Ruta no encontrada", 1);

        if (isset($datos['distancia']) && $datos['distancia'] <= 0)
            throw new Exception("La distancia debe ser mayor a cero", 2);

        if (isset($datos['distancia'])) $ruta->distancia = $datos['distancia'];
        if (isset($datos['tiempo_estimado'])) $ruta->tiempo_estimado = $datos['tiempo_estimado'];
        if (isset($datos['observaciones'])) $ruta->observaciones = $datos['observaciones'];
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

    function programarViaje($datos) {
        $conductorOcupado = ProgramacionViaje::where('conductor_id', $datos['conductor_id'])
                                             ->where('estado', 'programado')
                                             ->first();
        if ($conductorOcupado) throw new Exception("El conductor no está disponible", 2);

        $vehiculoOcupado = ProgramacionViaje::where('vehiculo_id', $datos['vehiculo_id'])
                                            ->where('estado', 'programado')
                                            ->first();
        if ($vehiculoOcupado) throw new Exception("El vehiculo no está disponible", 2);

        $programacion = new ProgramacionViaje();
        $programacion->conductor_id = $datos['conductor_id'];
        $programacion->vehiculo_id = $datos['vehiculo_id'];
        $programacion->ruta_id = $datos['ruta_id'];
        $programacion->fecha_salida = $datos['fecha_salida'];
        $programacion->hora_salida = $datos['hora_salida'];
        $programacion->fecha_estimada_llegada = $datos['fecha_estimada_llegada'];
        $programacion->observaciones = $datos['observaciones'] ?? null;
        $programacion->estado = 'programado';
        $programacion->save();

        return $programacion;
    }

    function reprogramarViaje($id, $datos) {
        $programacion = ProgramacionViaje::find($id);
        if (empty($programacion)) throw new Exception("Programacion no encontrada", 1);
        if ($programacion->estado === 'cancelado') throw new Exception("No se puede reprogramar un viaje cancelado", 2);

        if (isset($datos['fecha_salida'])) $programacion->fecha_salida = $datos['fecha_salida'];
        if (isset($datos['hora_salida'])) $programacion->hora_salida = $datos['hora_salida'];
        if (isset($datos['fecha_estimada_llegada'])) $programacion->fecha_estimada_llegada = $datos['fecha_estimada_llegada'];
        if (isset($datos['conductor_id'])) $programacion->conductor_id = $datos['conductor_id'];
        if (isset($datos['vehiculo_id'])) $programacion->vehiculo_id = $datos['vehiculo_id'];
        if (isset($datos['observaciones'])) $programacion->observaciones = $datos['observaciones'];
        $programacion->save();

        return $programacion;
    }
}