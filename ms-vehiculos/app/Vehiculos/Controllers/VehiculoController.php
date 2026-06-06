<?php
namespace App\Vehiculos\Controllers;

use App\Vehiculos\Models\Vehiculo;
use Exception;

class VehiculoController {

    function listar() {
        return Vehiculo::all();
    }

    function buscarPorPlaca($placa) {
        $vehiculo = Vehiculo::where('placa', $placa)->first();
        if (empty($vehiculo)) throw new Exception("Vehiculo no encontrado", 1);
        return $vehiculo;
    }

    function buscarPorEstado($estado) {
        return Vehiculo::where('estado', $estado)->get();
    }

    function buscarPorTipo($tipo) {
        return Vehiculo::where('tipo_vehiculo', $tipo)->get();
    }

    function crear($info) {
        if (empty($info['placa'])) throw new Exception("La placa es obligatoria", 2);
        if ($info['capacidad_carga'] <= 0) throw new Exception("La capacidad debe ser mayor a cero", 2);

        $existe = Vehiculo::where('placa', $info['placa'])->first();
        if ($existe) throw new Exception("La placa ya está registrada", 2);

        $vehiculo = new Vehiculo();
        $vehiculo->placa = $info['placa'];
        $vehiculo->tipo_vehiculo = $info['tipo_vehiculo'];
        $vehiculo->capacidad_carga = $info['capacidad_carga'];
        $vehiculo->modelo = $info['modelo'];
        $vehiculo->marca = $info['marca'];
        $vehiculo->estado = 'disponible';
        $vehiculo->save();

        return $vehiculo;
    }

    function editar($id, $info) {
        $vehiculo = Vehiculo::find($id);
        if (empty($vehiculo)) throw new Exception("Vehiculo no encontrado", 1);

        if (isset($info['capacidad_carga']) && $info['capacidad_carga'] <= 0)
            throw new Exception("La capacidad debe ser mayor a cero", 2);

        if (isset($info['capacidad_carga'])) $vehiculo->capacidad_carga = $info['capacidad_carga'];
        if (isset($info['tipo_vehiculo'])) $vehiculo->tipo_vehiculo = $info['tipo_vehiculo'];
        if (isset($info['modelo'])) $vehiculo->modelo = $info['modelo'];
        if (isset($info['marca'])) $vehiculo->marca = $info['marca'];
        if (isset($info['estado'])) $vehiculo->estado = $info['estado'];
        $vehiculo->save();

        return $vehiculo;
    }

    function cambiarEstado($id, $estado) {
        $vehiculo = Vehiculo::find($id);
        if (empty($vehiculo)) throw new Exception("Vehiculo no encontrado", 1);

        $estadosValidos = ['disponible', 'en_ruta', 'mantenimiento', 'inactivo'];
        if (!in_array($estado, $estadosValidos)) throw new Exception("Estado no válido", 2);

        $vehiculo->estado = $estado;
        $vehiculo->save();
        return $vehiculo;
    }
}