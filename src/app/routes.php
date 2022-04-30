<?php
namespace App\controller;
use Slim\Routing\RouteCollectorProxy;
// require __DIR__ . '/../controller/Artefacto.php';
$app->group('/artefacto', function(RouteCollectorProxy $articulo)
{
    $articulo->get('/{indice}/{limite}', Artefacto::class . ':mostrarTodos' );
    $articulo->get('/{id}', Artefacto::class . ':buscar'  );
    //También se puede hacer así
    $articulo->get('/filtro/{indice}/{limite}', 'App\Controller\Artefacto:filtrar' );
    $articulo->post('/', Artefacto::class .':crear' );
    $articulo->put('/{id}', Artefacto::class .':modificar' );
    $articulo->delete('/{id}', Artefacto::class .':eliminar');
});
$app->group('/cliente', function(RouteCollectorProxy $cliente)
{
    $cliente->get('/{indice}/{limite}', Cliente::class . ':mostrarTodos' );
    $cliente->get('/{id}', Cliente::class . ':buscar'  );
    //También se puede hacer así
    $cliente->get('/filtro/{indice}/{limite}', Cliente::class .':filtrar' );
    $cliente->post('/', Cliente::class .':crear' );
    $cliente->put('/{id}', Cliente::class .':modificar' );
    $cliente->delete('/{id}', Cliente::class .':eliminar');
});