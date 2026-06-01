<?php
namespace App\Auth\Presentation\Repositories;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Auth\Controllers\AuthController;
use Exception;

class AuthRepository{
    function login(Request $request, Response $response){
        try{
            $body = $request->getBody()->getContents();
            $data = json_decode($body, true);

            $controller = new AuthController();
            $usuario = $controller->login($data);

            $responseBody = json_encode([
                'message' => 'Login exitoso',
                'token' => $usuario->token,
                'usuario' => $usuario->usuario,
                'nombre' => $usuario->nombre,
                'rol' => $usuario->rol
            ]);

            $response->getBody()->write($responseBody);
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        
        } catch(Exception $ex){
            $response->getBody()->write(json_encode(['error' => $ex->getMessage()]));
            $code = match($ex->getCode()){
                1 => 404,
                3 => 403,
                default => 401
            };
            return $response->withStatus($code)->withHeader('Content-Type', 'application/json');
        }
    }
    function logout (Request $request, Response $response){
        try{
            $token = $request->getHeaderLine('Authorization');
            
            $controller = new AuthController();
            $controller->logout($token);

            $response->getBody()->write(json_encode(['message' => 'Sesión cerrada']));
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');

        }catch(Exception $ex){
            $response->getBody()->write(json_encode(['error' => $ex->getMessage()]));
            return $response->withStatus(401)->withHeader('Content-Type', 'application/json');
        }
    }


    function Validar_Token(Request $request, Response $response){
        try{
            $token = $request->getHeaderLine('Authorization');

            $controller = new AuthController();
            $usuario = $controller->validarToken($token);

            $response->getBody()->write(json_encode([
                'valid' => true,
                'usuario' => $usuario->usuario,
                'nombre' => $usuario->nombre, 
                'rol' => $usuario->rol
            ]));
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');

        }catch (Exception $ex){
            $response->getBody()->write(json_encode(['valid'=>false, 'error'=>$ex->getMessage()]));
            return $response->withStatus(401)->withHeader('Content-Type', 'application/json');
        }
    }
}