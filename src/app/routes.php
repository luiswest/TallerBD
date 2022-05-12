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
    $cliente->get('/{id}', Cliente::class . ':buscarCliente'  );
  //  $cliente->get('/filtro/{indice}/{limite}', Cliente::class .':filtrar' );
  //  $cliente->get('/numregs', Cliente::class .':numRegs' );
    $cliente->post('', Cliente::class .':crear' );
    $cliente->put('/{id}', Cliente::class .':modificar' );
    $cliente->delete('/{id}', Cliente::class .':eliminar');
});
$app->group('/admin', function(RouteCollectorProxy $admin) {
    $admin->get('/{id}', Administrador::class . ':buscarAdmin'  );
    $admin->post('', Administrador::class .':crear' );
    $admin->put('/{id}', Administrador::class .':modificar' );
    $admin->delete('/{id}', Administrador::class .':eliminar');
});
$app->group('/filtro', function(RouteCollectorProxy $filtro) {
    $filtro->group('/cliente', function(RouteCollectorProxy $cliente) {
        $cliente->get('/{indice}/{limite}', Cliente::class .':filtrar' );
        $cliente->get('/numregs', Cliente::class .':numRegs' );      
    });
    $filtro->group('/admin', function(RouteCollectorProxy $admin) {
        $admin->get('/{indice}/{limite}', Administrador::class .':filtrar' );
        $admin->get('/numregs', Administrador::class .':numRegs' );      
    });
});
$app->group('/auth', function(RouteCollectorProxy $auth)
{
    $auth->post('/iniciar', Auth::class .':iniciarSesion' );
    $auth->get('/cerrar', Auth::class .':cerrarSesion');
});