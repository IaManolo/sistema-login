<?php
require_once 'includes/conexion.php';

$token = $_GET['token'] ?? '';

if (empty($token)) {
    exit("❌ Token no proporcionado.");
}

try {
    // Buscar usuario con ese token
    $stmt = $pdo->prepare("SELECT id_usuario, estado_verificacion FROM usuarios WHERE token_verificacion = :token");
    $stmt->execute([':token' => $token]);
    $usuario = $stmt->fetch();

    if (!$usuario) {
        exit("❌ Token inválido o ya usado.");
    }

    if ($usuario['estado_verificacion'] === 'verificado') {
        exit("⚠️ Este usuario ya ha sido verificado.");
    }

    // Actualizar estado a verificado y limpiar token
    $stmt = $pdo->prepare("UPDATE usuarios SET estado_verificacion = 'verificado', token_verificacion = NULL WHERE id_usuario = :id");
    $stmt->execute([':id' => $usuario['id_usuario']]);

    // Mostrar SweetAlert de éxito y redirigir
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Verificación exitosa</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
    <script>
        Swal.fire({
            icon: 'success',
            title: '¡Cuenta verificada!',
            text: 'Tu cuenta ha sido activada correctamente.',
            confirmButtonText: 'Ir al inicio de sesión',
            timer: 4000,
            timerProgressBar: true
        }).then(() => {
            window.location.href = '../aplicacion_LOGIN/view/login.php'; // Redirigir al login después de la verificación
        });
    </script>
    </body>
    </html>
    <?php
} catch (PDOException $e) {
    echo "❌ Error al verificar cuenta: " . $e->getMessage();
}
?>
