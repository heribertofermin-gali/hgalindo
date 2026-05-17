<?php
ob_start();
session_start();

// Si no hay sesión, devolvemos un arreglo vacío en formato JSON
if (!isset($_SESSION['usuario'])) {
    ob_end_clean();
    echo json_encode([]);
    exit();
}

include 'conexion.php';

$imagenes = array();

if (isset($conexion) && $conexion !== false) {
    // Consulta nativa de Postgres para traer todas las fotos ordenadas por ID
    $query = "SELECT id, nombre, ruta FROM imagenes ORDER BY id ASC";
    $result = pg_query($conexion, $query);

    if ($result) {
        // Recorremos los resultados y los guardamos en el arreglo
        while ($row = pg_fetch_assoc($result)) {
            $imagenes[] = $row;
        }
    }
}

// Limpiamos cualquier "basura" invisible antes de imprimir el resultado
ob_end_clean();

// Le decimos al navegador que la respuesta es estrictamente JSON
header('Content-Type: application/json');
echo json_encode($imagenes);
?>
