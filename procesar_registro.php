<?php
/** @var mysqli $conexion */
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Sanitización de entradas
    $nombre   = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $correo   = mysqli_real_escape_string($conexion, $_POST['correo']);
    $plain_pass = $_POST['password'];

    // 2. Verificar si el correo ya está registrado
    $checkEmail = "SELECT correo FROM usuarios WHERE correo = '$correo'";
    $resCheck = mysqli_query($conexion, $checkEmail);

    if (mysqli_num_rows($resCheck) > 0) {
        echo "<script>
                alert('Error: Este correo ya está registrado.');
                window.history.back();
              </script>";
    } else {
        // 3. Encriptar contraseña y guardar
        $password_hash = password_hash($plain_pass, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO usuarios (nombre, correo, password) 
                VALUES ('$nombre', '$correo', '$password_hash')";

        if (mysqli_query($conexion, $sql)) {
            echo "<script>
                    alert('¡Cuenta creada con éxito! Ahora puedes iniciar sesión.');
                    window.location='login.php';
                  </script>";
        } else {
            echo "Error crítico en el sistema: " . mysqli_error($conexion);
        }
    }
}

mysqli_close($conexion);
?>