<?php
namespace App\controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;
use PDO;
class Usuario {
    public function __construct(public ContainerInterface $container) {  }

    public function autenticar($idUsuario, $passw) {
        $datos = $this->buscar(idUsuario: $idUsuario);
        return (($datos) &&  (password_verify($passw, $datos->passw))) ?
        ["rol" => $datos->rol] : null;
    }
    public function guardarUsuario($sqlGeneral, $datos, $rol) {
        $con = $this->container->get('bd');
        $idUsuario = $datos['idUsuario'];
        $passw = $datos['passw'];
        unset($datos['idUsuario']);
        unset($datos['passw']);
        $con->beginTransaction();
        try { 
            $query = $con->prepare($sqlGeneral);
            $query->execute($datos);

            $sql = "select nuevoUsuario(:idUsuario, :rol, :passw);";
            $query = $con->prepare($sql);

            $query->execute(array(
                        'idUsuario' => $idUsuario,
                        'rol' => $rol,  //Cliente tiene rol 4
                        'passw' => $passw  //Esto es temporal
                    ));
            $con->commit();

        } catch (PDOException $e) {
            $con->rollback();
        }  //fin de la transacción
        $res = $query->fetch(PDO::FETCH_NUM);
        $query = null;
        $con = null;
        return $res[0];
    }
    public function cambiarUsuario(string $idUsuario, int $rol=-1, string $passwN='') {
        $proc = $rol == -1 ? 'passwUsuario(:id, :passw);' : 'rolUsuario(:id, :rol);';
        $usuario = $this->buscar(idUsuario: $idUsuario);

        if ($usuario) {
            $params = ['id'=>$usuario->id];
            $params = $rol == -1 ? array_merge($params, ['passw'=>$passwN]) :
                                    array_merge($params, ['rol'=> $rol]);
            $con = $this->container->get('bd');
            $query = $con->prepare("select $proc");
            $retorno = $query->execute($params);
            $query = null;
            $con = null;
            return $retorno;
        }
        else {
            return false;
        }
    }
    public function buscar (int $id=0, string $idUsuario='') {
        $sql = "call buscarUsuario($id, '$idUsuario');";
        $con = $this->container->get('bd');
        $query = $con->prepare($sql);
        $query->execute();
        $res = $query->fetch();
        $query = null;
        $con = null;
        return $res;
    }
    public function eliminarUsuario(string $sqlGeneral, string $idUsuario, int $id) {
        $con = $this->container->get('bd');

        $idUsr = $this->buscar(idUsuario: $idUsuario)->id;
        $con->beginTransaction();
        try { 
            $query = $con->prepare($sqlGeneral);
            $query->bindParam('id', $id, PDO::PARAM_INT);
            $query->execute();

            $sql = "select eliminarUsuario(:idUsuario);";
            $query = $con->prepare($sql);
            $query->bindParam('idUsuario',$idUsr, PDO::PARAM_INT);
            $query->execute();
            $con->commit();

        } catch (PDOException $e) {
            $con->rollback();
        }  //fin de la transacción
        $res = $query->fetch(PDO::FETCH_NUM);
        $query = null;
        $con = null;
        return $res[0];
    }
    public function cambiarRol(Request $request, Response $response, $args) {
        $body = json_decode($request->getbody());
        $datos = $this->cambiarUsuario(idUsuario: $body->idUsuario, rol: $body->rol);
        $status = $datos ? 200 : 404;
        return $response->withStatus($status);
    }
    public function cambiarPassw(Request $request, Response $response, $args) {
        $body = json_decode($request->getbody());
        $datos = $this->autenticar($body->idUsuario, $body->passw);
        if ($datos) {
            $body->passwN = Hash::hash($body->passwN);
            $datos = $this->cambiarUsuario(idUsuario:$body->idUsuario, passwN: $body->passwN);
            $status = 200;
        } else {
            $status = 403;
        }
        return $response->withStatus($status);
    }
    public function resetPassw(Request $request, Response $response, $args) {
        $body = json_decode($request->getbody());

        $passwN = Hash::hash($body->idUsuario);
        $datos = $this->cambiarUsuario(idUsuario:$body->idUsuario, passwN: $passwN);
        $status = $datos ? 200 : 403;

        return $response->withStatus($status);
    }
}