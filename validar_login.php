<?php
session_start();
/** @var mysqli $conexion */
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Sanitización de entrada (Vital para prevenir SQL Injection)
    $correo   = mysqli_real_escape_string($conexion, trim($_POST['correo']));
    $password = $_POST['password'];

    // 2. Consulta a la tabla usuarios de la base de datos DBProgWeb
    $sql = "SELECT id, nombre, correo, password FROM usuarios WHERE correo = '$correo'";
    $resultado = mysqli_query($conexion, $sql);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $usuario = mysqli_fetch_assoc($resultado);

        // 3. Verificamos la contraseña contra el hash de la DB
        if (password_verify($password, $usuario['password'])) {
            
            // Regeneramos el ID de sesión (Buena práctica de seguridad)
            session_regenerate_id(true);
            
            // Guardamos los datos necesarios en la sesión
            $_SESSION['id_usuario'] = $usuario['id'];
            $_SESSION['usuario']    = $usuario['nombre']; 
            
            // Aseguramos el cierre de escritura antes de redirigir
            session_write_close(); 
            
            header("Location: index.php");
            exit();
        } else {
            // Error en contraseña
            mostrarError();
        }
    } else {
        // El correo no existe
        mostrarError();
    }
}

// Función para manejar el error de forma centralizada
function mostrarError() {
    echo "<script>
            alert('Las credenciales ingresadas son incorrectas.');
            window.location='login.php';
          </script>";
    exit();
}

mysqli_close($conexion);
?>