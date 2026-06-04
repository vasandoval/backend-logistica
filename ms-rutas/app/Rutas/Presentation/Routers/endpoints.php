<?php
use Slim\App;
use App\Rutas\Presentation\Repositories\RutaRepository;

return function (App $app) {
    $app->get('/rutas', [RutaRepository::class, 'listarRutas']);
    $app->get('/rutas/ciudad/{ciudad}', [RutaRepository::class, 'buscarRutaPorCiudad']);
    $app->post('/rutas', [RutaRepository::class, 'crearRuta']);
    $app->put('/rutas/{id}', [RutaRepository::class, 'editarRuta']);

    $app->get('/programaciones', [RutaRepository::class, 'listarProgramaciones']);
    $app->get('/programaciones/conductor/{conductor_id}', [RutaRepository::class, 'buscarProgramacionPorConductor']);
    $app->get('/programaciones/vehiculo/{vehiculo_id}', [RutaRepository::class, 'buscarProgramacionPorVehiculo']);
    $app->get('/programaciones/estado/{estado}', [RutaRepository::class, 'buscarProgramacionPorEstado']);
    $app->get('/programaciones/fecha/{fecha}', [RutaRepository::class, 'buscarProgramacionPorFecha']);
    $app->post('/programaciones', [RutaRepository::class, 'programarViaje']);
    $app->put('/programaciones/{id}', [RutaRepository::class, 'reprogramarViaje']);
};