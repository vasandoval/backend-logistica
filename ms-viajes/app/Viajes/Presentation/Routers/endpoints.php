<?php
use Slim\App;
use App\Viajes\Presentation\Repositories\ViajeRepository;

return function (App $app) {
        $app->get('/viajes/todos', [ViajeRepository::class, 'consultarTodos']);
        $app->post('/viajes/iniciar', [ViajeRepository::class, 'iniciarViaje']);
        $app->post('/viajes/novedad', [ViajeRepository::class, 'registrarNovedad']);
        $app->get('/viajes/historial/{programacion_id}', [ViajeRepository::class, 'consultarHistorial']);
        $app->get('/viajes/estado/{estado}', [ViajeRepository::class, 'consultarPorEstado']);
        $app->post('/viajes/{id}/estado', [ViajeRepository::class, 'actualizarEstado']);
        $app->post('/viajes/{id}/finalizar', [ViajeRepository::class, 'finalizarViaje']);
};