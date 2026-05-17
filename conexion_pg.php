<?php
$host = "localhost";
$port = "5432";
$db   = "dbprogweb";
$user = "hgalindo";
$pass = "12345678";

try {
    $conexion_pg = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass);
    $conexion_pg->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Ya no hay "echo" aquí para que el AJAX no se confunda
} catch (PDOException $e) {
    // Solo mostramos error si realmente falla la conexión
    http_response_code(500);
    echo "Error de conexión: " . $e->getMessage();
    exit;
}
