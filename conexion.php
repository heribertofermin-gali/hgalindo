<?php
$host = "localhost";
$user = "hgalindo"; // Usuario
$pass = "12345678";     // Contraseña
$db   = "DBProgWeb"; // Nuevo nombre de la base de datos

$conexion = mysqli_connect($host, $user, $pass, $db);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>
