<?php
use Slim\App;
use App\Vehiculos\Presentation\Repositories\VehiculoRepository;

return function (App $app) {
    $app->get('/vehiculos', [VehiculoRepository::class, 'listar']);
    $app->get('/vehiculos/placa/{placa}', [VehiculoRepository::class, 'buscarPorPlaca']);
    $app->get('/vehiculos/estado/{estado}', [VehiculoRepository::class, 'buscarPorEstado']);
    $app->get('/vehiculos/tipo/{tipo}', [VehiculoRepository::class, 'buscarPorTipo']);
    $app->post('/vehiculos', [VehiculoRepository::class, 'crear']);
    $app->put('/vehiculos/{id}', [VehiculoRepository::class, 'editar']);
    $app->patch('/vehiculos/{id}/estado', [VehiculoRepository::class, 'cambiarEstado']);
};