<?php
use Psr\Container\ContainerInterface;
$container->set('bd', function(ContainerInterface $c) {
    $conf = $c->get('config_bd');
    $opc = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    ];
    $dsn = "mysql:host=$conf->host;dbname=$conf->bd;
    charset=$conf->charset";
    try {
        $con = new PDO($dsn, $conf->usr, $conf->pass, $opc);
        
    } catch (PDOException $e) {
        print "Error! " . $e->getMessage() . "<br>"; //Desarrollo
        die();
       // print "Error temporal, nos disculpamos por los inconvenienes "; //Produccion
    }

    return $con;

});