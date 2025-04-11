<?php
/**
 * Este archivo forma parte de Aplicacion_LOGIN.
 * Licenciado bajo la GNU General Public License v3.0.
 * Más información en https://www.gnu.org/licenses/gpl-3.0.html
 * Autor: Manuel Molina Sánchez
 */

// Datos de prueba (puedes tomar el token del insert real si lo deseas)
$nombre = "Usuario de prueba";
$correo = "adminzocoweb@zocoweb.com";
$token = "7e2f5a1f30f13844bdeb9e4a768bfee29128216bc26e47448c7f67d341b7b8d4";

// Ruta base del sistema (ajústala si cambias el nombre del archivo final)
$enlace = "https://zocoweb.com/aplicaciones/aplicacion_LOGIN/verificar.php?token=$token";

// Asunto y mensaje
$asunto = "Verifica tu cuenta";
$mensaje = "
<html>
<head><title>Verifica tu cuenta</title></head>
<body>
    <p>Hola, <strong>$nombre</strong></p>
    <p>Gracias por registrarte. Haz clic en el siguiente enlace para verificar tu cuenta:</p>
    <p><a href='$enlace'>$enlace</a></p>
</body>
</html>
";

// Cabeceras
$cabeceras  = "MIME-Version: 1.0" . "\r\n";
$cabeceras .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$cabeceras .= "From: no-reply@tudominio.com" . "\r\n";

// Enviar
if (mail($correo, $asunto, $mensaje, $cabeceras)) {
    echo "✅ Correo enviado correctamente a $correo";
} else {
    echo "❌ Error al enviar el correo";
}
