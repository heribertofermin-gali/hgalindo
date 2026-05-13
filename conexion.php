<?php
$host = "localhost";
$user = "root"; // Usuario por defecto de XAMPP
$pass = "";     // Contraseña por defecto (vacía)
$db   = "dbprogweb"; // Nuevo nombre de la base de datos

$conexion = mysqli_connect($host, $user, $pass, $db);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>