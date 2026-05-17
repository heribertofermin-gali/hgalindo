<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    echo 'error_auth';
    exit();
}

include 'conexion.php'; // Usa tu $conexion de Postgres

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

if ($id > 0) {
    // Validar que la conexión de Postgres exista
    if (isset($conexion) && $conexion !== false) {
        
        // Consulta nativa para Postgres con parámetro posicionado ($1)
        $query = "DELETE FROM imagenes WHERE id = $1";
        
        // Dejamos el nombre "" para evitar el error de "prepared statement already exists"
        $stmt = pg_prepare($conexion, "", $query);
        
        if ($stmt) {
            $result = pg_execute($conexion, "", array($id));
            
            if ($result) {
                echo 'success'; // La palabra exacta que espera tu JS para quitar el "Eliminando..."
            } else {
                echo 'error_execute: no se pudo borrar de la BD';
            }
        } else {
            echo 'error_prepare: falla en la consulta';
        }
    } else {
        echo 'error_conexion: revisa conexion.php';
    }
} else {
    echo 'error_id: id inválido';
}
?>
