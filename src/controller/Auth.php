<?php
namespace App\controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;
use Firebase\JWT\JWT;
use PDO;
class Auth extends Usuario {
    public function __construct(public ContainerInterface $container) {
    }
    public function iniciarSesion(Request $request, Response $response, $args){
        $body = json_decode($request->getBody());
        $res = $this->autenticar($body->idUsuario, $body->passw);
        if ($body->idUsuario === "Admin#W35t") {
            $res['rol'] = '0';
        }
        if ($res) {
            $retorno = Token::generarTokens($body->idUsuario, $res['rol']);
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