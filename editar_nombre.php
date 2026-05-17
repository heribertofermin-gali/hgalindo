<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    echo 'error: no autorizado';
    exit();
}

include 'conexion.php'; // Incluye tu archivo con pg_connect

$id     = isset($_POST['id'])     ? intval($_POST['id'])   : 0;
$nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';

if (!$id || $nombre === '') {
    echo 'error: datos incompletos';
    exit();
}

// CORRECCIÓN: Validamos simplemente que la variable exista y no sea falsa
if (isset($conexion) && $conexion !== false) {
    
    // En PostgreSQL usamos parámetros posicionados ($1, $2)
    $query = "UPDATE imagenes SET nombre = $1 WHERE id = $2";
    
    // Dejamos el segundo parámetro vacío "" para que PHP le asigne un nombre automático
    // y evitar conflictos si se ejecuta la consulta varias veces consecutivas.
    $stmt = pg_prepare($conexion, "", $query);
    
    if ($stmt) {
        $result = pg_execute($conexion, "", array($nombre, $id));
        
        if ($result) {
            echo 'success'; // Esto es lo que lee el AJAX de tu visor para actualizar la vista
        } else {
            echo 'error: no se pudo actualizar en la base de datos';
        }
    } else {
        echo 'error: error al preparar la consulta';
    }

} else {
    echo 'error: no se encontró la variable de conexión ($conexion de Postgres)';
}
?>
