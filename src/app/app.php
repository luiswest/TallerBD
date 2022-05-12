<?php
use DI\Container;
use Slim\Factory\AppFactory;

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../env.php';


$cont_aux = new \DI\Container();

AppFactory::setContainer($cont_aux);
$app = AppFactory::create();

$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, false, false);
$app->add(new Tuupola\Middleware\JwtAuthentication([
    "secure" => false,
    "secret" => getenv('key'),
    //"path" => ["/cliente"],
    "ignore" => ["/auth/iniciar","/admin", "/filtro","/cliente"]
]));

$container = $app->getContainer();
require_once "config.php";
require_once "routes.php";
require_once "conexion.php";

$app->run();
