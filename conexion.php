<?php
$host = "localhost";
$port = "5432"; // Puerto por defecto de Postgres
$db   = "dbprogweb";
$user = "hgalindo"; // Tu usuario de PostgreSQL (suele ser postgres)
$pass = "12345678"; // Pon la contraseña de tu Postgres

// Cadena de conexión para pg_connect
$conn_string = "host=$host port=$port dbname=$db user=$user password=$pass";

// Conexión nativa a PostgreSQL
$conexion = pg_connect($conn_string);

if (!$conexion) {
    // Si falla, enviamos este mensaje (que es el que ves en el cuadrito negro)
    die("Error de conexión a PostgreSQL."); 
}

