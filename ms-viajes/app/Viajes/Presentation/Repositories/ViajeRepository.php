<?php
namespace App\Viajes\Presentation\Repositories;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Viajes\Controllers\ViajeController;
use Exception;

class ViajeRepository {

    function iniciarViaje(Request $request, Response $response) {
        try {
            $datos = json_decode((string)$request->getBody(), true);
            $ctrl = new ViajeController();
            $seguimiento = $ctrl->iniciarViaje($datos);
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
            $datos = json_decode((string)$request->getBody(), true);
            $ctrl = new ViajeController();
            $seguimiento = $ctrl->actualizarEstado($args['id'], $datos);
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
            $datos = json_decode((string)$request->getBody(), true);
            $ctrl = new ViajeController();
            $seguimiento = $ctrl->registrarNovedad($datos);
            $response->getBody()->write(json_encode(['message' => 'Novedad registrada', 'seguimiento' => $seguimiento]));
            return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
        } catch (Exception $ex) {
            $response->getBody()->write(json_encode(['error' => $ex->getMessage()]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    function finalizarViaje(Request $request, Response $response, $args) {
        try {
            $datos = json_decode((string)$request->getBody(), true);
            $ctrl = new ViajeController();
            $seguimiento = $ctrl->finalizarViaje($args['id'], $datos);
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
            $ctrl = new ViajeController();
            $historial = $ctrl->consultarHistorial($args['programacion_id']);
            $response->getBody()->write(json_encode($historial));
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Exception $ex) {
            $response->getBody()->write(json_encode(['error' => $ex->getMessage()]));
            return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        }
    }

    function consultarPorEstado(Request $request, Response $response, $args) {
        try {
            $ctrl = new ViajeController();
            $seguimientos = $ctrl->consultarPorEstado($args['estado']);
            $response->getBody()->write(json_encode($seguimientos));
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Exception $ex) {
            $response->getBody()->write(json_encode(['error' => $ex->getMessage()]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }
}