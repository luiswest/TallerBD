<?php
namespace App\controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;
class Artefacto {
    public function mostrarTodos (Request $request, Response $response, $args) {
        //Retornar todos los registros con limit
        $indice = $args['indice'];
        $limite = $args['limite'];
        $response->getBody()->write("Retorno $limite registros desde posición $indice");
        return $response;
    }
    public function buscar (Request $request, Response $response, $args) {
        //Retornar un registro por código
        $id = $args['id'];
        $response->getBody()->write("Retorno de articulo con id $id");
        return $response;
    }
    public function filtrar (Request $request, Response $response, $args) {
        //Retorna registros filtrados con limit
        $indice = $args['indice'];
        $limite = $args['limite'];
        $datos = json_encode($request->getQueryParams());
        $response->getBody()->write("Retorno $limite registros desde posición $indice <pre>$datos</pre>");
        return $response;
    }
    public function crear (Request $request, Response $response, $args) {
        //Crear nuevo
        $datos = json_decode($request->getBody());
        $response->getBody()->write(json_encode($datos));
        return $response;
    }
    public function modificar (Request $request, Response $response, $args) {
        //modificar
        $id = $args["id"];
        $body = json_decode($request->getBody());
        $datos = json_encode($body);
        $response->getBody()->write("Modificar artículo con id $id <pre>Datos:$datos<pre>");
        return $response;
    }
    public function eliminar (Request $request, Response $response, $args) {
        //eliminar
        $id = $args["id"];
        $response->getBody()->write("Se va eliminar el articulo con id $id");
        return $response;
    }
}