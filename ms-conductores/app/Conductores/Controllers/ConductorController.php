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

    function crear($data) {
        $existe = Conductor::where('documento', $data['documento'])
                           ->orWhere('numero_licencia', $data['numero_licencia'])
                           ->orWhere('correo', $data['correo'])
                           ->first();
        if ($existe) throw new Exception("Documento, licencia o correo ya registrado", 2);

        $conductor = new Conductor();
        $conductor->nombres = $data['nombres'];
        $conductor->apellidos = $data['apellidos'];
        $conductor->documento = $data['documento'];
        $conductor->telefono = $data['telefono'];
        $conductor->correo = $data['correo'];
        $conductor->numero_licencia = $data['numero_licencia'];
        $conductor->categoria_licencia = $data['categoria_licencia'];
        $conductor->fecha_vencimiento_licencia = $data['fecha_vencimiento_licencia'];
        $conductor->estado = 'disponible';
        $conductor->save();

        return $conductor;
    }

    function editar($id, $data) {
        $conductor = Conductor::find($id);
        if (empty($conductor)) throw new Exception("Conductor no encontrado", 1);

        if (isset($data['nombres'])) $conductor->nombres = $data['nombres'];
        if (isset($data['apellidos'])) $conductor->apellidos = $data['apellidos'];
        if (isset($data['telefono'])) $conductor->telefono = $data['telefono'];
        if (isset($data['correo'])) $conductor->correo = $data['correo'];
        if (isset($data['categoria_licencia'])) $conductor->categoria_licencia = $data['categoria_licencia'];
        if (isset($data['fecha_vencimiento_licencia'])) $conductor->fecha_vencimiento_licencia = $data['fecha_vencimiento_licencia'];
        if (isset($data['estado'])) $conductor->estado = $data['estado'];
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