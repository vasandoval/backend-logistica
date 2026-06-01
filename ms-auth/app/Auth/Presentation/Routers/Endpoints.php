<?php

use Slim\App;
use App\Auth\Presentation\Repositories\AuthRepository;

return function(App $app){
    $app->post('/login', [AuthRepository::class, 'login']);
    $app->post('/logout', [AuthRepository::class, 'logout']);
    $app->get('/validar-token', [AuthRepository::class, 'validarToken']);
};