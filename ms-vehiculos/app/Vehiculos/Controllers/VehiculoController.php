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

    function crear($data) {
        if (empty($data['placa'])) throw new Exception("La placa es obligatoria", 2);
        if ($data['capacidad_carga'] <= 0) throw new Exception("La capacidad debe ser mayor a cero", 2);

        $existe = Vehiculo::where('placa', $data['placa'])->first();
        if ($existe) throw new Exception("La placa ya está registrada", 2);

        $vehiculo = new Vehiculo();
        $vehiculo->placa = $data['placa'];
        $vehiculo->tipo_vehiculo = $data['tipo_vehiculo'];
        $vehiculo->capacidad_carga = $data['capacidad_carga'];
        $vehiculo->modelo = $data['modelo'];
        $vehiculo->marca = $data['marca'];
        $vehiculo->estado = 'disponible';
        $vehiculo->save();

        return $vehiculo;
    }

    function editar($id, $data) {
        $vehiculo = Vehiculo::find($id);
        if (empty($vehiculo)) throw new Exception("Vehiculo no encontrado", 1);

        if (isset($data['capacidad_carga']) && $data['capacidad_carga'] <= 0)
            throw new Exception("La capacidad debe ser mayor a cero", 2);

        if (isset($data['capacidad_carga'])) $vehiculo->capacidad_carga = $data['capacidad_carga'];
        if (isset($data['tipo_vehiculo'])) $vehiculo->tipo_vehiculo = $data['tipo_vehiculo'];
        if (isset($data['modelo'])) $vehiculo->modelo = $data['modelo'];
        if (isset($data['marca'])) $vehiculo->marca = $data['marca'];
        if (isset($data['estado'])) $vehiculo->estado = $data['estado'];
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