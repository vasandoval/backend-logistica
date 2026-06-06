<?php
namespace App\Conductores\Presentation\Repositories;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Conductores\Controllers\ConductorController;
use Exception;

class ConductorRepository {

    function listar(Request $request, Response $response) {
        try {
            $controller = new ConductorController();
            $conductores = $controller->listar();
            $response->getBody()->write(json_encode($conductores));
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Exception $ex) {
            $response->getBody()->write(json_encode(['error' => $ex->getMessage()]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    function buscarPorDocumento(Request $request, Response $response, $args) {
        try {
            $controller = new ConductorController();
            $conductor = $controller->buscarPorDocumento($args['documento']);
            $response->getBody()->write(json_encode($conductor));
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Exception $ex) {
            $response->getBody()->write(json_encode(['error' => $ex->getMessage()]));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }
    }

    function buscarPorLicencia(Request $request, Response $response, $args) {
        try {
            $controller = new ConductorController();
            $conductor = $controller->buscarPorLicencia($args['licencia']);
            $response->getBody()->write(json_encode($conductor));
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Exception $ex) {
            $response->getBody()->write(json_encode(['error' => $ex->getMessage()]));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }
    }

    function buscarPorEstado(Request $request, Response $response, $args) {
        try {
            $controller = new ConductorController();
            $conductores = $controller->buscarPorEstado($args['estado']);
            $response->getBody()->write(json_encode($conductores));
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Exception $ex) {
            $response->getBody()->write(json_encode(['error' => $ex->getMessage()]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    function crear(Request $request, Response $response) {
        try {
            $datos = json_decode($request->getBody()->getContents(), true);
            $controller = new ConductorController();
            $conductor = $controller->crear($datos);
            $response->getBody()->write(json_encode(['message' => 'Conductor creado', 'conductor' => $conductor]));
            return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
        } catch (Exception $ex) {
            $code = $ex->getCode() == 2 ? 409 : 500;
            $response->getBody()->write(json_encode(['error' => $ex->getMessage()]));
            return $response->withStatus($code)->withHeader('Content-Type', 'application/json');
        }
    }

    function editar(Request $request, Response $response, $args) {
        try {
            $datos = json_decode($request->getBody()->getContents(), true);
            $controller = new ConductorController();
            $conductor = $controller->editar($args['id'], $datos);
            $response->getBody()->write(json_encode(['message' => 'Conductor actualizado', 'conductor' => $conductor]));
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Exception $ex) {
            $code = $ex->getCode() == 1 ? 404 : 500;
            $response->getBody()->write(json_encode(['error' => $ex->getMessage()]));
            return $response->withStatus($code)->withHeader('Content-Type', 'application/json');
        }
    }

    function cambiarEstado(Request $request, Response $response, $args) {
        try {
            $datos = json_decode($request->getBody()->getContents(), true);
            $controller = new ConductorController();
            $conductor = $controller->cambiarEstado($args['id'], $datos['estado']);
            $response->getBody()->write(json_encode(['message' => 'Estado actualizado', 'conductor' => $conductor]));
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Exception $ex) {
            $code = $ex->getCode() == 1 ? 404 : 400;
            $response->getBody()->write(json_encode(['error' => $ex->getMessage()]));
            return $response->withStatus($code)->withHeader('Content-Type', 'application/json');
        }
    }
}