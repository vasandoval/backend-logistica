<?php
namespace App\Rutas\Presentation\Repositories;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Rutas\Controllers\RutaController;
use Exception;

class RutaRepository {

    function listarRutas(Request $request, Response $response) {
        try {
            $controlador = new RutaController();
            $rutas = $controlador->listarRutas();
            $response->getBody()->write(json_encode($rutas));
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Exception $ex) {
            $response->getBody()->write(json_encode(['error' => $ex->getMessage()]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    function buscarRutaPorCiudad(Request $request, Response $response, $args) {
        try {
            $controlador = new RutaController();
            $rutas = $controlador->buscarRutaPorCiudad($args['ciudad']);
            $response->getBody()->write(json_encode($rutas));
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Exception $ex) {
            $response->getBody()->write(json_encode(['error' => $ex->getMessage()]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    function crearRuta(Request $request, Response $response) {
        try {
            $datos = json_decode($request->getBody()->getContents(), true);
            $controlador = new RutaController();
            $ruta = $controlador->crearRuta($datos);
            $response->getBody()->write(json_encode(['message' => 'Ruta creada', 'ruta' => $ruta]));
            return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
        } catch (Exception $ex) {
            $codigo = $ex->getCode() == 2 ? 409 : 500;
            $response->getBody()->write(json_encode(['error' => $ex->getMessage()]));
            return $response->withStatus($codigo)->withHeader('Content-Type', 'application/json');
        }
    }

    function editarRuta(Request $request, Response $response, $args) {
        try {
            $datos = json_decode($request->getBody()->getContents(), true);
            $controlador = new RutaController();
            $ruta = $controlador->editarRuta($args['id'], $datos);
            $response->getBody()->write(json_encode(['message' => 'Ruta actualizada', 'ruta' => $ruta]));
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Exception $ex) {
            $codigo = $ex->getCode() == 1 ? 404 : 400;
            $response->getBody()->write(json_encode(['error' => $ex->getMessage()]));
            return $response->withStatus($codigo)->withHeader('Content-Type', 'application/json');
        }
    }

    function listarProgramaciones(Request $request, Response $response) {
        try {
            $controlador = new RutaController();
            $programaciones = $controlador->listarProgramaciones();
            $response->getBody()->write(json_encode($programaciones));
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Exception $ex) {
            $response->getBody()->write(json_encode(['error' => $ex->getMessage()]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    function buscarProgramacionPorConductor(Request $request, Response $response, $args) {
        try {
            $controlador = new RutaController();
            $programaciones = $controlador->buscarProgramacionPorConductor($args['conductor_id']);
            $response->getBody()->write(json_encode($programaciones));
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Exception $ex) {
            $response->getBody()->write(json_encode(['error' => $ex->getMessage()]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    function buscarProgramacionPorVehiculo(Request $request, Response $response, $args) {
        try {
            $controlador = new RutaController();
            $programaciones = $controlador->buscarProgramacionPorVehiculo($args['vehiculo_id']);
            $response->getBody()->write(json_encode($programaciones));
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Exception $ex) {
            $response->getBody()->write(json_encode(['error' => $ex->getMessage()]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    function buscarProgramacionPorEstado(Request $request, Response $response, $args) {
        try {
            $controlador = new RutaController();
            $programaciones = $controlador->buscarProgramacionPorEstado($args['estado']);
            $response->getBody()->write(json_encode($programaciones));
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Exception $ex) {
            $response->getBody()->write(json_encode(['error' => $ex->getMessage()]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    function buscarProgramacionPorFecha(Request $request, Response $response, $args) {
        try {
            $controlador = new RutaController();
            $programaciones = $controlador->buscarProgramacionPorFecha($args['fecha']);
            $response->getBody()->write(json_encode($programaciones));
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Exception $ex) {
            $response->getBody()->write(json_encode(['error' => $ex->getMessage()]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }

    function programarViaje(Request $request, Response $response) {
        try {
            $datos = json_decode($request->getBody()->getContents(), true);
            $controlador = new RutaController();
            $programacion = $controlador->programarViaje($datos);
            $response->getBody()->write(json_encode(['message' => 'Viaje programado', 'programacion' => $programacion]));
            return $response->withStatus(201)->withHeader('Content-Type', 'application/json');
        } catch (Exception $ex) {
            $codigo = $ex->getCode() == 2 ? 409 : 500;
            $response->getBody()->write(json_encode(['error' => $ex->getMessage()]));
            return $response->withStatus($codigo)->withHeader('Content-Type', 'application/json');
        }
    }

    function reprogramarViaje(Request $request, Response $response, $args) {
        try {
            $datos = json_decode($request->getBody()->getContents(), true);
            $controlador = new RutaController();
            $programacion = $controlador->reprogramarViaje($args['id'], $datos);
            $response->getBody()->write(json_encode(['message' => 'Viaje reprogramado', 'programacion' => $programacion]));
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (Exception $ex) {
            $codigo = $ex->getCode() == 1 ? 404 : 400;
            $response->getBody()->write(json_encode(['error' => $ex->getMessage()]));
            return $response->withStatus($codigo)->withHeader('Content-Type', 'application/json');
        }
    }
}