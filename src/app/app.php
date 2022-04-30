<?php
use DI\Container;
use Slim\Factory\AppFactory;

require __DIR__ . '/../../vendor/autoload.php';

$cont_aux = new \DI\Container();

AppFactory::setContainer($cont_aux);
$app = AppFactory::create();

$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, false, false);

$container = $app->getContainer();
require_once "config.php";
require_once "routes.php";
require_once "conexion.php";

$app->run();
