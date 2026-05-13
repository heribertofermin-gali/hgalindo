<?php
session_start();
/** @var mysqli $conexion */
include 'conexion.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    http_response_code(403);
    exit('No autorizado');
}

// Verificar que se recibieron los datos necesarios
if (isset($_POST['id']) && isset($_POST['ruta'])) {
    
    // Convertimos el ID a entero para mayor seguridad
    $id = (int)$_POST['id']; 
    $ruta = $_POST['ruta'];

    // 1. Intentar borrar el archivo físico del servidor
    if (file_exists($ruta)) {
        unlink($ruta);
    }

    // 2. Borrar el registro de la base de datos usando CONSULTAS PREPARADAS
    // Esto reemplaza las líneas que tenías con $sql y mysqli_query
    $stmt = $conexion->prepare("DELETE FROM imagenes WHERE id = ?");
    $stmt->bind_param("i", $id); 

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Datos incompletos";
}

mysqli_close($conexion);
?>