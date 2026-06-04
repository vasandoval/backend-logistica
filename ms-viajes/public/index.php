<?php
error_reporting(0);
ini_set('display_errors', 0);

use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/Config/database.php';

$app = AppFactory::create();

$endpoints = require __DIR__ . '/../app/Viajes/Presentation/Routers/endpoints.php';
$endpoints($app);

$cors = require __DIR__ . '/../app/Middlewares/CorsMiddleware.php';
$cors($app);

$app->run();