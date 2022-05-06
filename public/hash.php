<?php
$passwBD = 'West1235';
echo $passwBD . "<br>";

$opciones = [
    'cost' => 11
];
$hash = password_hash($passwBD, PASSWORD_BCRYPT,$opciones);
echo $hash . "<br>";

$entradaUsuario = $_GET['passw'];

echo $entradaUsuario . "<br>";
if (password_verify($entradaUsuario, $hash)) {
    echo "Acceso Concedido";
} else {
    echo "Acceso Denegado";
}
