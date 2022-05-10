<?php
namespace App\controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;
use PDO;
class Usuario {
    protected $container;
    public function __construct(ContainerInterface $c) {
        $this->container = $c;
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
    public function buscar ($usr) {
        $sql = "call buscarUsuario(-1, :idUsuario);";
        $con = $this->container->get('bd');
        $query = $con->prepare($sql);
        $query->bindParam('idUsuario', $usr, PDO::PARAM_STR);
        $query->execute();
        $res = $query->fetch();
        /*if ($query->rowCount() > 0) {
            $res = $query->fetch();
           } else {
               $res = 0;
        }*/
        $query = null;
        $con = null;
        return $res;
    }
}