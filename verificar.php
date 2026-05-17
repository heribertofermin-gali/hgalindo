<?php
include 'conexion_pg.php';

echo "<h2>Lista de Imágenes en PostgreSQL</h2>";

try {
    $consulta = $conexion_pg->query("SELECT * FROM imagenes ORDER BY fecha_registro DESC");
    $registros = $consulta->fetchAll(PDO::FETCH_ASSOC);

    if (count($registros) > 0) {
        echo "<table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Ruta</th>
                    <th>Fecha</th>
                </tr>";
        foreach ($registros as $fila) {
            echo "<tr>
                    <td>{$fila['id']}</td>
                    <td>{$fila['nombre']}</td>
                    <td>{$fila['ruta']}</td>
                    <td>{$fila['fecha_registro']}</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "No hay imágenes registradas en Postgres aún.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
