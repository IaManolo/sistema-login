<?php
session_start(); // Iniciar la sesión

// Destruir todas las variables de sesión
session_unset();

// Destruir la sesión
session_destroy();

// Redirigir al login después de cerrar sesión
header("Location: ../aplicacion_LOGIN/view/login.php");
exit(); // Asegurarse de que el script termine aquí
?>
