<?php
use Slim\App;
use App\Viajes\Presentation\Repositories\ViajeRepository;

return function (App $app) {
    $app->post('/viajes/iniciar', [ViajeRepository::class, 'iniciarViaje']);
    $app->patch('/viajes/{id}/estado', [ViajeRepository::class, 'actualizarEstado']);
    $app->post('/viajes/novedad', [ViajeRepository::class, 'registrarNovedad']);
    $app->patch('/viajes/{id}/finalizar', [ViajeRepository::class, 'finalizarViaje']);
    $app->get('/viajes/historial/{programacion_id}', [ViajeRepository::class, 'consultarHistorial']);
    $app->get('/viajes/estado/{estado}', [ViajeRepository::class, 'consultarPorEstado']);
};