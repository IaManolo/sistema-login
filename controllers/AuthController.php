<?php
require_once '../includes/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $clave = $_POST['clave'] ?? '';
    $avatarElegido = $_POST['avatar'] ?? null;
    $imagenSubida = $_FILES['imagen'] ?? null;

    // Validación básica
    if (!$nombre || !$correo || !$clave) {
        exit("❌ Faltan datos obligatorios.");
    }

    // Comprobar si el correo ya existe
    $stmt = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE correo = :correo");
    $stmt->execute([':correo' => $correo]);
    if ($stmt->fetch()) {
        exit("❌ El correo ya está registrado.");
    }

    // Hash de contraseña
    $claveHash = password_hash($clave, PASSWORD_DEFAULT);

    // Generar token de verificación
    $token = bin2hex(random_bytes(32));

    // Procesar imagen
    $nombreImagen = "default.png";

    if ($avatarElegido) {
        $nombreImagen = $avatarElegido;
    } elseif ($imagenSubida && $imagenSubida['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($imagenSubida['name'], PATHINFO_EXTENSION);
        $nombreImagen = uniqid('img_') . "." . strtolower($ext);
        $rutaDestino = "../assets/img/" . $nombreImagen;
        move_uploaded_file($imagenSubida['tmp_name'], $rutaDestino);
    }

    // Insertar usuario
    $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, correo, clave, imagen, token_verificacion)
                           VALUES (:nombre, :correo, :clave, :imagen, :token)");

    $stmt->execute([
        ':nombre' => $nombre,
        ':correo' => $correo,
        ':clave'  => $claveHash,
        ':imagen' => $nombreImagen,
        ':token'  => $token
    ]);

    // Enviar correo de verificación
    $enlace = "https://www.zocoweb.com/aplicaciones/aplicacion_LOGIN/verificar.php?token=$token";
    $asunto = "Verifica tu cuenta";
    $mensaje = "
    <html>
    <body>
        <p>Hola, <strong>$nombre</strong></p>
        <p>Gracias por registrarte. Haz clic en este enlace para verificar tu cuenta:</p>
        <a href='$enlace'>$enlace</a>
    </body>
    </html>
    ";
    $cabeceras = "MIME-Version: 1.0\r\n";
    $cabeceras .= "Content-type:text/html;charset=UTF-8\r\n";
    $cabeceras .= "From: no-reply@tudominio.com\r\n";

    mail($correo, $asunto, $mensaje, $cabeceras);
    
    // Mostrar SweetAlert de éxito y redirigir
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Registro exitoso</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
    <script>
        Swal.fire({
            icon: 'success',
            title: '¡Registro exitoso!',
            text: 'Hemos enviado un correo para que verifiques tu cuenta.',
            confirmButtonText: 'Ir al inicio de sesión',
            timer: 4000,
            timerProgressBar: true
        }).then(() => {
            window.location.href = '../view/login.php'; // Cambia la ruta si es necesario
        });
    </script>
    </body>
    </html>
    <?php
}
?>
