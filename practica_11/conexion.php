<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

$servidor = "localhost";
$password = "reservas";
$usuario = "reservas";
$dbname = "reservas";

try {
    $conexion = new PDO("mysql:host=$servidor;dbname=$dbname", $usuario, $password);
    return $conexion;
} catch (PDOException $e) {
    die("Error en la base de datos: " . $e->getMessage());
}
