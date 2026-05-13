<?php
session_start();
// Limpiamos todas las variables de sesión
$_SESSION = array();
// Destruimos la sesión
session_destroy();
// Redirigimos con un parámetro de éxito
header("Location: login.php?status=loggedout");
exit();
?>