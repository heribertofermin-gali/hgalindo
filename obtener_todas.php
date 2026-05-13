<?php
// Incluimos la conexión que ya apunta a DBProgWeb
/** @var mysqli $conexion */
include 'conexion.php'; 

// Ordenamos por id de forma descendente para ver lo más reciente primero
$sql = "SELECT id, nombre, ruta, fecha_registro FROM imagenes ORDER BY id DESC";

$resultado = mysqli_query($conexion, $sql);

if (!$resultado) {
    // Si falla la consulta, devolvemos el error en JSON
    echo json_encode(['error' => mysqli_error($conexion)]);
    exit;
}

$fotos = [];

while($fila = mysqli_fetch_assoc($resultado)) {
    $fotos[] = $fila;
}

// Establecer el encabezado para que el navegador sepa que recibe JSON
header('Content-Type: application/json');

// Devolvemos el arreglo de fotos (vacío o con datos)
echo json_encode($fotos);

mysqli_close($conexion);
?>