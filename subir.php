<?php
session_start();
/** @var mysqli $conexion */
include 'conexion.php'; 

// 1. Verificación de seguridad básica
if (!isset($_SESSION['usuario'])) {
    http_response_code(403);
    exit("No autorizado");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['foto'])) {
    
    $nombre_display = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $archivo = $_FILES['foto']; 
    
    // 2. Configuración de directorio
    $directorio = 'uploads/';
    if (!file_exists($directorio)) {
        mkdir($directorio, 0777, true);
    }

    // 3. Validación de tipo de archivo (Seguridad Forense)
    $permitidos = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));

    if (!in_array($extension, $permitidos)) {
        http_response_code(400);
        echo "Error: Tipo de archivo no permitido.";
        exit;
    }

    // 4. Limpieza del nombre de archivo físico
    // Reemplazamos espacios por guiones y quitamos caracteres raros
    $nombre_limpio = preg_replace("/[^a-zA-Z0-9.]/", "_", basename($archivo['name']));
    $nombre_final = time() . "_" . $nombre_limpio;
    $ruta_completa = $directorio . $nombre_final;

    // 5. Proceso de subida
    if (move_uploaded_file($archivo['tmp_name'], $ruta_completa)) {
        
        // Insertamos en la nueva base de datos DBProgWeb
        $sql = "INSERT INTO imagenes (nombre, ruta) VALUES ('$nombre_display', '$ruta_completa')";
        
        if (mysqli_query($conexion, $sql)) {
            // Respuesta para el AJAX de index.php
            echo "success"; 
        } else {
            // Si falla la DB, borramos el archivo físico para no dejar basura
            unlink($ruta_completa);
            http_response_code(500);
            echo "Error DB: " . mysqli_error($conexion);
        }
    } else {
        http_response_code(500);
        echo "Error: Falló el movimiento del archivo.";
    }
} else {
    http_response_code(400);
    echo "Petición inválida.";
}

mysqli_close($conexion);
?>