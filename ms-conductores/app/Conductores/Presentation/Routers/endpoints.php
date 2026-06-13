<?php
use Slim\App;
use App\Conductores\Presentation\Repositories\ConductorRepository;

return function (App $app) {
    $app->get('/conductores', [ConductorRepository::class, 'listar']);
    $app->get('/conductores/documento/{documento}', [ConductorRepository::class, 'buscarPorDocumento']);
    $app->get('/conductores/licencia/{licencia}', [ConductorRepository::class, 'buscarPorLicencia']);
    $app->get('/conductores/estado/{estado}', [ConductorRepository::class, 'buscarPorEstado']);
    $app->post('/conductores', [ConductorRepository::class, 'crear']);
    $app->put('/conductores/{id}', [ConductorRepository::class, 'editar']);
    $app->post('/conductores/{id}/estado', [ConductorRepository::class, 'cambiarEstado']);
};