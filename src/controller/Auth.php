<?php
namespace App\controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;
use PDO;
class Auth extends Usuario {
    protected $container;
    public function __construct(ContainerInterface $c) {
        $this->container = $c;
    }
    private function autenticar($usr, $passw) {
        $datos = $this->buscar($usr);
/*         if ($datos) {
            if (password_verify($passw, $datos->passw)) {
                return true;
            } else {
                return false;
            }
        }
        return false; */
        if (!$datos) {return false;}
        return password_verify($passw, $datos->passw);
    }
    public function iniciarSesion(Request $request, Response $response, $args){
        $body = json_decode($request->getBody());
        $resultado = $this->autenticar($body->idUsuario, $body->passw);
        $status = $resultado == true ? 200 : 401;
        return $response->withStatus($status);
    }
    public function cerrarSesion(Request $request, Response $response, $args){

    }
}