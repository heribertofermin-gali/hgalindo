<?php
session_start();
// Cambiamos el include para usar la conexión de Postgres
include 'conexion_pg.php'; 

// 1. Verificación de seguridad básica
if (!isset($_SESSION['usuario'])) {
    http_response_code(403);
    exit("No autorizado");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['foto'])) {

    // En PDO no usamos mysqli_real_escape_string, usamos sentencias preparadas
    $nombre_display = $_POST['nombre'];
    $archivo = $_FILES['foto'];

    // 2. Configuración de directorio
    $directorio = 'uploads/';
    if (!file_exists($directorio)) {
        mkdir($directorio, 0777, true);
    }

    // 3. Validación de tipo de archivo
    $permitidos = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));

    if (!in_array($extension, $permitidos)) {
        http_response_code(400);
        echo "Error: Tipo de archivo no permitido.";
        exit;
    }

    // 4. Limpieza del nombre de archivo físico
    $nombre_limpio = preg_replace("/[^a-zA-Z0-9.]/", "_", basename($archivo['name']));
    $nombre_final = time() . "_" . $nombre_limpio;
    $ruta_completa = $directorio . $nombre_final;

    // 5. Proceso de subida
    if (move_uploaded_file($archivo['tmp_name'], $ruta_completa)) {

        try {
            // Usamos $conexion_pg que definimos en conexion_pg.php con sentencias preparadas
            $sql = "INSERT INTO imagenes (nombre, ruta) VALUES (:nombre, :ruta)";
            $stmt = $conexion_pg->prepare($sql);
            
            if ($stmt->execute([':nombre' => $nombre_display, ':ruta' => $ruta_completa])) {
                // Respuesta para el AJAX
                echo "success";
            } else {
                // Si falla la DB, borramos el archivo físico
                unlink($ruta_completa);
                http_response_code(500);
                echo "Error al insertar en PostgreSQL";
            }
        } catch (PDOException $e) {
            unlink($ruta_completa);
            http_response_code(500);
            echo "Error DB Postgres: " . $e->getMessage();
        }

    } else {
        http_response_code(500);
        echo "Error: Falló el movimiento del archivo.";
    }
} else {
    http_response_code(400);
    echo "Petición inválida.";
}

// En PDO la conexión se cierra sola, o poniendo la variable en null
$conexion_pg = null;
?>
