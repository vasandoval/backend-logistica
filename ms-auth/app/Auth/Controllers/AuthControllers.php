<?php
namespace App\Auth\Controllers;

use App\Auth\Models\User;
use Exception;

class AuthController {
    function login($data){
        $usuario = User::where('usuario', $data['usuario'])
                    ->orWhere('email', $data['usuario'])
                    ->first();

        if (empty($usuarios)){
            throw new Exception("Usuario no encontrado", 1);
        }

        if ($usuario->password !== $data['Contrasena']){
            throw new Exception("Contraseña incorrecta", 2);
        }

        if(usuario->estado === 'inactivo'){
            throw Exception("Usuario inactivo", 3);
        }

        $token = bin2hex(random_bytes(32));//genera token aleatorio
        $usuario->token = $token;
        $usuario->sesion_activ = true;
        $usuario->save();

        return $usuario;
    }

    function logout($token){
        $usuario = User::where('token', $token)-> first();

        if (empty($usuario)){
            throw new Exception("token inválido", 1);
        }

        $usuario->token = null;
        $usuario->session_active = false;
        $usuario->save();
    }

    function validarToken($token){
        $usuario = User::where('token', $token)
                    ->where('sesion_activa', true)
                    ->first();

        if (empty($usuario)){
        throw new Exception("Token inálido o sesión expirada", 1);
        }
           return $usuario;
    }
}
