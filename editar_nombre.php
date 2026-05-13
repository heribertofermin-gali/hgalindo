<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    echo 'error: no autorizado';
    exit();
}

include 'conexion.php';

$id     = isset($_POST['id'])     ? intval($_POST['id'])   : 0;
$nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';

if (!$id || $nombre === '') {
    echo 'error: datos incompletos';
    exit();
}

// --── Detecta automáticamente PDO o mysqli ──────────────────────────

// Opción A: PDO  ($pdo)
if (isset($pdo) && $pdo instanceof PDO) {
    try {
        $stmt = $pdo->prepare("UPDATE imagenes SET nombre = ? WHERE id = ?");
        $stmt->execute([$nombre, $id]);
        echo 'success';
    } catch (Exception $e) {
        echo 'error: ' . $e->getMessage();
    }

// Opción B: mysqli objeto  ($conn / $conexion / $mysqli)
} elseif (isset($conn)     && $conn     instanceof mysqli ||
          isset($conexion) && $conexion instanceof mysqli ||
          isset($mysqli)   && $mysqli   instanceof mysqli) {

    $c    = isset($conn) ? $conn : (isset($conexion) ? $conexion : $mysqli);
    $stmt = $c->prepare("UPDATE imagenes SET nombre = ? WHERE id = ?");
    $stmt->bind_param("si", $nombre, $id);
    $stmt->execute();
    echo $stmt->affected_rows >= 0 ? 'success' : 'error: no se actualizó';
    $stmt->close();

// Opción C: mysqli procedural  (mysqli_connect)
} elseif (isset($conn)     && is_resource($conn)     ||
          isset($conexion) && is_resource($conexion)) {

    $c    = isset($conn) ? $conn : $conexion;
    $stmt = mysqli_prepare($c, "UPDATE imagenes SET nombre = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "si", $nombre, $id);
    mysqli_stmt_execute($stmt);
    echo 'success';

} else {
    echo 'error: no se encontró variable de conexión ($pdo, $conn o $conexion)';
}
?>

