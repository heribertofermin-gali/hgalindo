<?php
/**
 * obtener_imagen.php
 * Script para obtener una sola imagen de forma dinámica
 * TESVG 2026 - Programación Web
 */

// Incluimos la conexión (Asegúrate de que el nombre del archivo sea exacto)
include 'conexion.php';

// Configuramos el encabezado para que el navegador sepa que enviamos JSON
header('Content-Type: application/json');

// Sanitización y recepción de parámetros
// 'direccion' puede ser 'next' o 'prev'
// 'actual' es el ID de la imagen que se está viendo actualmente
$direccion = isset($_GET['direccion']) ? $_GET['direccion'] : 'next';
$actualId  = isset($_GET['actual']) ? (int)$_GET['actual'] : 0;

try {
    if ($direccion === 'next') {
        // Buscamos el primer ID que sea mayor al actual
        $sql = "SELECT id, nombre, ruta FROM imagenes WHERE id > ? ORDER BY id ASC LIMIT 1";
    } else {
        // Buscamos el primer ID que sea menor al actual
        $sql = "SELECT id, nombre, ruta FROM imagenes WHERE id < ? ORDER BY id DESC LIMIT 1";
    }

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $actualId);
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Lógica de Ciclo Infinito: Si no hay más registros en esa dirección, reiniciamos el ciclo
    if ($resultado->num_rows === 0) {
        if ($direccion === 'next') {
            // Si ya no hay más adelante, saltamos a la primera imagen de la tabla
            $sql_reset = "SELECT id, nombre, ruta FROM imagenes ORDER BY id ASC LIMIT 1";
        } else {
            // Si ya no hay más atrás, saltamos a la última imagen de la tabla
            $sql_reset = "SELECT id, nombre, ruta FROM imagenes ORDER BY id DESC LIMIT 1";
        }
        $res_reset = $conexion->query($sql_reset);
        $datos = $res_reset->fetch_assoc();
    } else {
        $datos = $resultado->fetch_assoc();
    }

    // Retornamos el resultado
    if ($datos) {
        echo json_encode($datos);
    } else {
        // Caso en que la tabla esté totalmente vacía
        echo json_encode(['error' => 'No se encontraron imágenes en la base de datos.']);
    }

} catch (Exception $e) {
    // Manejo de errores del servidor
    echo json_encode(['error' => 'Error en el servidor: ' . $e->getMessage()]);
}

// Cerramos la conexión
$conexion->close();
?>
