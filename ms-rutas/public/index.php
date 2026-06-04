<?php
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/Config/database.php';

$app = AppFactory::create();

$endpoints = require __DIR__ . '/../app/Rutas/Presentation/Routers/endpoints.php';
$endpoints($app);

$cors = require __DIR__ . '/../app/Middlewares/CorsMiddleware.php';
$cors($app);

$app->run();