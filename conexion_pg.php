<?php
$host = "localhost";
$port = "5432";
$db   = "dbprogweb";
$user = "hgalindo";
$pass = "12345678";

try {
    $conexion_pg = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass);
    $conexion_pg->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "¡Conexión exitosa a PostgreSQL para Heriberto!";
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>
