<?php
ob_start(); // Previene "espacios fantasma" que rompan el AJAX
session_start();
if (!isset($_SESSION['usuario'])) {
    ob_end_clean();
    die('error_auth');
}

include 'conexion.php'; // Tu conexión mysqli normal

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    
    // El script en AJAX también manda la ruta de la foto física, si la necesitas para borrarla del disco
    // $ruta = isset($_POST['ruta']) ? trim($_POST['ruta']) : ''; 

    if ($id > 0 && isset($conexion)) {
        
        // Versión MySQLi para prevenir inyecciones
        $query = "DELETE FROM imagenes WHERE id = ?";
        $stmt = mysqli_prepare($conexion, $query);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $id);
            if (mysqli_stmt_execute($stmt)) {
                // Éxito: Todo salió perfecto
                ob_end_clean();
                die('success'); 
            } else {
                ob_end_clean();
                die('error_bd');
            }
            mysqli_stmt_close($stmt);
        } else {
            ob_end_clean();
            die('error_prepare');
        }
    } else {
        ob_end_clean();
        die('error_conexion_id');
    }
} else {
    ob_end_clean();
    die('error_method');
}
?>
