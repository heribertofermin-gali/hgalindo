<?php
session_start();
// Abrimos las dos conexiones
include 'conexion.php';    // Tu conexión original (MySQL/MariaDB)
include 'conexion_pg.php'; // Tu nueva conexión (PostgreSQL)

if (!isset($_SESSION['usuario'])) {
    http_response_code(403);
    exit("No autorizado");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['foto'])) {
    $nombre_display = $_POST['nombre'];
    $archivo = $_FILES['foto'];
    $directorio = 'uploads/';

    if (!file_exists($directorio)) {
        mkdir($directorio, 0777, true);
    }

    $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
    $nombre_final = time() . "_" . preg_replace("/[^a-zA-Z0-9.]/", "_", basename($archivo['name']));
    $ruta_completa = $directorio . $nombre_final;

    if (move_uploaded_file($archivo['tmp_name'], $ruta_completa)) {
        
        // --- 1. GUARDAR EN MARIADB (MySQL) ---
        $nombre_esc_mysql = mysqli_real_escape_string($conexion, $nombre_display);
        $sql_mysql = "INSERT INTO imagenes (nombre, ruta) VALUES ('$nombre_esc_mysql', '$ruta_completa')";
        $res_mysql = mysqli_query($conexion, $sql_mysql);

        // --- 2. GUARDAR EN POSTGRESQL ---
        try {
            $sql_pg = "INSERT INTO imagenes (nombre, ruta) VALUES (:nombre, :ruta)";
            $stmt_pg = $conexion_pg->prepare($sql_pg);
            $res_pg = $stmt_pg->execute([':nombre' => $nombre_display, ':ruta' => $ruta_completa]);
        } catch (PDOException $e) {
            $res_pg = false;
        }

        // --- VERIFICACIÓN FINAL ---
        if ($res_mysql && $res_pg) {
            echo "success"; // Ambas guardaron bien
        } else {
            echo "Error: MySQL(" . ($res_mysql ? 'OK' : 'FAIL') . ") | Postgres(" . ($res_pg ? 'OK' : 'FAIL') . ")";
        }

    } else {
        echo "Error al mover archivo.";
    }
}
?>
