<?php
namespace App\Viajes\Presentation\Repositories;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Viajes\Controllers\ViajeController;
use Exception;

class ViajeRepository {

    function iniciarViaje(Request $request, Response $response) {
        try {
            $info = json_decode((string)$request->getBody(), true);
            $controller = new ViajeController();
            $seguimiento = $controller->iniciarViaje($info);
            $response->getBody()->write(json_encode(['message' => 'Viaje iniciado', 'seguimiento' => $seguimiento]));
            return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
        } catch (Exception $ex) {
            $codigo = $ex->getCode() == 1 ? 404 : 400;
            $response->getBody()->write(json_encode(['error' => $ex->getMessage()]));
            return $response->withStatus($codigo)->withHeader('Content-Type', 'application/json');
        }
    }

    function actualizarEstado(Request $request, Response $response, $args) {
        try {
            $info = json_decode((string)$request->getBody(), true);
            $controller = new ViajeController();
            $seguimiento = $controller->actualizarEstado($args['id'], $info);
            $response->getBody()->write(json_encode(['message' => 'Estado actualizado', 'seguimiento' => $seguimiento]));
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Exception $ex) {
            $codigo = $ex->getCode() == 1 ? 404 : 400;
            $response->getBody()->write(json_encode(['error' => $ex->getMessage()]));
            return $response->withStatus($codigo)->withHeader('Content-Type', 'application/json');
        }
    }

    function registrarNovedad(Request $request, Response $response) {
        try {
            $info = json_decode((string)$request->getBody(), true);
            $controller = new ViajeController();
            $seguimiento = $controller->registrarNovedad($info);
            $response->getBody()->write(json_encode(['message' => 'Novedad registrada', 'seguimiento' => $seguimiento]));
            return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
        } catch (Exception $ex) {
            $response->getBody()->write(json_encode(['error' => $ex->getMessage()]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    function finalizarViaje(Request $request, Response $response, $args) {
        try {
            $info = json_decode((string)$request->getBody(), true);
            $controller = new ViajeController();
            $seguimiento = $controller->finalizarViaje($args['id'], $info);
            $response->getBody()->write(json_encode(['message' => 'Viaje finalizado', 'seguimiento' => $seguimiento]));
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Exception $ex) {
            $codigo = $ex->getCode() == 1 ? 404 : 400;
            $response->getBody()->write(json_encode(['error' => $ex->getMessage()]));
            return $response->withStatus($codigo)->withHeader('Content-Type', 'application/json');
        }
    }

    function consultarHistorial(Request $request, Response $response, $args) {
        try {
            $controller = new ViajeController();
            $historial = $controller->consultarHistorial($args['programacion_id']);
            $response->getBody()->write(json_encode($historial));
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Exception $ex) {
            $response->getBody()->write(json_encode(['error' => $ex->getMessage()]));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }
    }

    function consultarPorEstado(Request $request, Response $response, $args) {
        try {
            $controller = new ViajeController();
            $seguimientos = $controller->consultarPorEstado($args['estado']);
            $response->getBody()->write(json_encode($seguimientos));
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Exception $ex) {
            $response->getBody()->write(json_encode(['error' => $ex->getMessage()]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }
}