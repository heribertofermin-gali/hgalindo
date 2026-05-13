<?php
/** @var mysqli $conexion */
include 'conexion.php';

// Sanitización de parámetros
$direccion = isset($_GET['direccion']) ? $_GET['direccion'] : 'next';
$actualId  = isset($_GET['actual']) ? (int)$_GET['actual'] : 0;

if ($direccion == 'next') {
    // Buscar el siguiente ID superior
    $sql = "SELECT id, nombre, ruta FROM imagenes WHERE id > $actualId ORDER BY id ASC LIMIT 1";
} else {
    // Buscar el anterior ID inferior
    $sql = "SELECT id, nombre, ruta FROM imagenes WHERE id < $actualId ORDER BY id DESC LIMIT 1";
}

$resultado = mysqli_query($conexion, $sql); // Corregido: $conn -> $conexion

// Lógica de Ciclo Infinito: Si llegamos al límite, reiniciamos
if (mysqli_num_rows($resultado) == 0) {
    if ($direccion == 'next') {
        // Si no hay más adelante, ir a la primera de todas
        $sql_reset = "SELECT id, nombre, ruta FROM imagenes ORDER BY id ASC LIMIT 1";
    } else {
        // Si no hay más atrás, ir a la última de todas
        $sql_reset = "SELECT id, nombre, ruta FROM imagenes ORDER BY id DESC LIMIT 1";
    }
    $resultado = mysqli_query($conexion, $sql_reset);
}

$datos = mysqli_fetch_assoc($resultado);

// Retornar JSON para el Visor
header('Content-Type: application/json'); // Aseguramos que el navegador entienda que es JSON
if ($datos) {
    echo json_encode($datos);
} else {
    echo json_encode(['error' => 'No hay imágenes disponibles en DBProgWeb']);
}

mysqli_close($conexion);
?>