<?php
namespace App\Vehiculos\Presentation\Repositories;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Vehiculos\Controllers\VehiculoController;
use Exception;

class VehiculoRepository {

    function listar(Request $request, Response $response) {
        try {
            $controller = new VehiculoController();
            $vehiculos = $controller->listar();
            $response->getBody()->write(json_encode($vehiculos));
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Exception $ex) {
            $response->getBody()->write(json_encode(['error' => $ex->getMessage()]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    function buscarPorPlaca(Request $request, Response $response, $args) {
        try {
            $controller = new VehiculoController();
            $vehiculo = $controller->buscarPorPlaca($args['placa']);
            $response->getBody()->write(json_encode($vehiculo));
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Exception $ex) {
            $response->getBody()->write(json_encode(['error' => $ex->getMessage()]));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }
    }

    function buscarPorEstado(Request $request, Response $response, $args) {
        try {
            $controller = new VehiculoController();
            $vehiculos = $controller->buscarPorEstado($args['estado']);
            $response->getBody()->write(json_encode($vehiculos));
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Exception $ex) {
            $response->getBody()->write(json_encode(['error' => $ex->getMessage()]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    function buscarPorTipo(Request $request, Response $response, $args) {
        try {
            $controller = new VehiculoController();
            $vehiculos = $controller->buscarPorTipo($args['tipo']);
            $response->getBody()->write(json_encode($vehiculos));
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Exception $ex) {
            $response->getBody()->write(json_encode(['error' => $ex->getMessage()]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    function crear(Request $request, Response $response) {
        try {
            $data = json_decode($request->getBody()->getContents(), true);
            $controller = new VehiculoController();
            $vehiculo = $controller->crear($data);
            $response->getBody()->write(json_encode(['message' => 'Vehiculo creado', 'vehiculo' => $vehiculo]));
            return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
        } catch (Exception $ex) {
            $code = $ex->getCode() == 2 ? 409 : 500;
            $response->getBody()->write(json_encode(['error' => $ex->getMessage()]));
            return $response->withStatus($code)->withHeader('Content-Type', 'application/json');
        }
    }

    function editar(Request $request, Response $response, $args) {
        try {
            $data = json_decode($request->getBody()->getContents(), true);
            $controller = new VehiculoController();
            $vehiculo = $controller->editar($args['id'], $data);
            $response->getBody()->write(json_encode(['message' => 'Vehiculo actualizado', 'vehiculo' => $vehiculo]));
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Exception $ex) {
            $code = $ex->getCode() == 1 ? 404 : 400;
            $response->getBody()->write(json_encode(['error' => $ex->getMessage()]));
            return $response->withStatus($code)->withHeader('Content-Type', 'application/json');
        }
    }

    function cambiarEstado(Request $request, Response $response, $args) {
        try {
            $data = json_decode($request->getBody()->getContents(), true);
            $controller = new VehiculoController();
            $vehiculo = $controller->cambiarEstado($args['id'], $data['estado']);
            $response->getBody()->write(json_encode(['message' => 'Estado actualizado', 'vehiculo' => $vehiculo]));
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Exception $ex) {
            $code = $ex->getCode() == 1 ? 404 : 400;
            $response->getBody()->write(json_encode(['error' => $ex->getMessage()]));
            return $response->withStatus($code)->withHeader('Content-Type', 'application/json');
        }
    }
}