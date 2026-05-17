<?php
ob_start(); // Inicia el búfer para atrapar cualquier texto o espacio "basura"
session_start();
if (!isset($_SESSION['usuario'])) {
    ob_end_clean();
    die('error_auth');
}

include 'conexion.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
        $fileTmpPath = $_FILES['foto']['tmp_name'];
        $fileName = $_FILES['foto']['name'];
        
        $uploadFileDir = 'uploads/';
        if (!is_dir($uploadFileDir)) {
            mkdir($uploadFileDir, 0777, true);
        }
        
        $newFileName = time() . '_' . preg_replace("/[^a-zA-Z0-9.-]/", "_", $fileName);
        $dest_path = $uploadFileDir . $newFileName;
        
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            if (isset($conexion) && $conexion !== false) {
                
                $query = "INSERT INTO imagenes (nombre, ruta) VALUES ($1, $2)";
                $stmt = pg_prepare($conexion, "", $query);
                
                if ($stmt) {
                    $result = pg_execute($conexion, "", array($nombre, $dest_path));
                    if ($result) {
                        ob_end_clean(); // Destruye cualquier espacio o warning oculto
                        die('success'); // Responde ÚNICAMENTE la palabra success
                    } else {
                        ob_end_clean(); die('error_bd');
                    }
                } else {
                    ob_end_clean(); die('error_prepare');
                }
            } else {
                ob_end_clean(); die('error_conexion');
            }
        } else {
            ob_end_clean(); die('error_upload');
        }
    } else {
        ob_end_clean(); die('error_file');
    }
} else {
    ob_end_clean(); die('error_method');
}
?>
