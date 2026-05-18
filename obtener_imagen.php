<?php
ob_start(); // Proteger el JSON de espacios fantasma
session_start();
include 'conexion.php';

// Sanitización de parámetros
$direccion = isset($_GET['direccion']) ? $_GET['direccion'] : 'next';
$actualId  = isset($_GET['actual']) ? (int)$_GET['actual'] : 0;

if ($direccion == 'next') {
    $sql = "SELECT id, nombre, ruta FROM imagenes WHERE id > $actualId ORDER BY id ASC LIMIT 1";
} else {
    $sql = "SELECT id, nombre, ruta FROM imagenes WHERE id < $actualId ORDER BY id DESC LIMIT 1";
}

$resultado = mysqli_query($conexion, $sql);

if (mysqli_num_rows($resultado) == 0) {
    if ($direccion == 'next') {
        $sql_reset = "SELECT id, nombre, ruta FROM imagenes ORDER BY id ASC LIMIT 1";
    } else {
        $sql_reset = "SELECT id, nombre, ruta FROM imagenes ORDER BY id DESC LIMIT 1";
    }
    $resultado = mysqli_query($conexion, $sql_reset);
}

$datos = mysqli_fetch_assoc($resultado);

ob_end_clean(); // Limpiar basura antes de imprimir JSON
header('Content-Type: application/json');

if ($datos) {
    echo json_encode($datos);
} else {
    echo json_encode(['error' => 'No hay imágenes disponibles']);
}
mysqli_close($conexion);
?>
