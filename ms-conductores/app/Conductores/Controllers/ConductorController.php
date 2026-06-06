<?php
namespace App\Conductores\Controllers;

use App\Conductores\Models\Conductor;
use Exception;

class ConductorController {

    function listar() {
        return Conductor::all();
    }

    function buscarPorDocumento($documento) {
        $conductor = Conductor::where('documento', $documento)->first();
        if (empty($conductor)) throw new Exception("Conductor no encontrado", 1);
        return $conductor;
    }

    function buscarPorLicencia($licencia) {
        $conductor = Conductor::where('numero_licencia', $licencia)->first();
        if (empty($conductor)) throw new Exception("Conductor no encontrado", 1);
        return $conductor;
    }

    function buscarPorEstado($estado) {
        return Conductor::where('estado', $estado)->get();
    }

    function crear($info) {
        $existe = Conductor::where('documento', $info['documento'])
                           ->orWhere('numero_licencia', $info['numero_licencia'])
                           ->orWhere('correo', $info['correo'])
                           ->first();
        if ($existe) throw new Exception("Documento, licencia o correo ya registrado", 2);

        $conductor = new Conductor();
        $conductor->nombres = $info['nombres'];
        $conductor->apellidos = $info['apellidos'];
        $conductor->documento = $info['documento'];
        $conductor->telefono = $info['telefono'];
        $conductor->correo = $info['correo'];
        $conductor->numero_licencia = $info['numero_licencia'];
        $conductor->categoria_licencia = $info['categoria_licencia'];
        $conductor->fecha_vencimiento_licencia = $info['fecha_vencimiento_licencia'];
        $conductor->estado = 'disponible';
        $conductor->save();

        return $conductor;
    }

    function editar($id, $info) {
        $conductor = Conductor::find($id);
        if (empty($conductor)) throw new Exception("Conductor no encontrado", 1);

        if (isset($info['nombres'])) $conductor->nombres = $info['nombres'];
        if (isset($info['apellidos'])) $conductor->apellidos = $info['apellidos'];
        if (isset($info['telefono'])) $conductor->telefono = $info['telefono'];
        if (isset($info['correo'])) $conductor->correo = $info['correo'];
        if (isset($info['categoria_licencia'])) $conductor->categoria_licencia = $info['categoria_licencia'];
        if (isset($info['fecha_vencimiento_licencia'])) $conductor->fecha_vencimiento_licencia = $info['fecha_vencimiento_licencia'];
        if (isset($info['estado'])) $conductor->estado = $info['estado'];
        $conductor->save();

        return $conductor;
    }

    function cambiarEstado($id, $estado) {
        $conductor = Conductor::find($id);
        if (empty($conductor)) throw new Exception("Conductor no encontrado", 1);

        $estadosValidos = ['disponible', 'en_ruta', 'inactivo'];
        if (!in_array($estado, $estadosValidos)) throw new Exception("Estado no válido", 2);

        $conductor->estado = $estado;
        $conductor->save();
        return $conductor;
    }
}