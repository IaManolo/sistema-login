<?php
/**
 * Este archivo forma parte de Aplicacion_LOGIN.
 * Licenciado bajo la GNU General Public License v3.0.
 * Más información en https://www.gnu.org/licenses/gpl-3.0.html
 * Autor: Manuel Molina Sánchez
 */

session_start(); // Iniciar la sesión

// Destruir todas las variables de sesión
session_unset();

// Destruir la sesión
session_destroy();

// Redirigir al login después de cerrar sesión
header("Location: ../aplicacion_LOGIN/view/login.php");
exit(); // Asegurarse de que el script termine aquí
?>
