<?php
/**
 * Este archivo forma parte de Aplicacion_LOGIN.
 * Licenciado bajo la GNU General Public License v3.0.
 * Más información en https://www.gnu.org/licenses/gpl-3.0.html
 * Autor: Manuel Molina Sánchez
 */

session_start();
require_once '../includes/conexion.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

$mensaje_error = null;

// Inicializar variables de sesión
if (!isset($_SESSION['intentos_login'])) {
    $_SESSION['intentos_login'] = 0;
}
if (!isset($_SESSION['ultimo_intento'])) {
    $_SESSION['ultimo_intento'] = time();
}

$bloqueo_duracion = 60; // en segundos
$bloqueado = false;
$segundos_restantes = 0;

if ($_SESSION['intentos_login'] >= 3) {
    $tiempo_transcurrido = time() - $_SESSION['ultimo_intento'];
    if ($tiempo_transcurrido < $bloqueo_duracion) {
        $segundos_restantes = $bloqueo_duracion - $tiempo_transcurrido;
        $mensaje_error = "Demasiados intentos. Espera $segundos_restantes segundos.";
        $bloqueado = true;
    } else {
        // Reiniciar intentos si ya pasó el tiempo
        $_SESSION['intentos_login'] = 0;
        $_SESSION['ultimo_intento'] = time();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$bloqueado) {
    $correo = $_POST['correo'] ?? '';
    $clave = $_POST['clave'] ?? '';

    if (!$correo || !$clave) {
        $mensaje_error = "Todos los campos son obligatorios.";
    } else {
        $stmt = $pdo->prepare("SELECT id_usuario, clave, estado_verificacion FROM usuarios WHERE correo = :correo");
        $stmt->execute([':correo' => $correo]);
        $usuario = $stmt->fetch();
            if (!$usuario) {
                $mensaje_error = "El correo no está registrado.";
            } elseif (!password_verify($clave, $usuario['clave'])) {
                $mensaje_error = "Contraseña incorrecta.";
            } elseif ($usuario['estado_verificacion'] !== 'verificado') {
                $mensaje_error = "Tu cuenta no ha sido verificada. Revisa tu correo.";
            }

      else {
    // Éxito: iniciar sesión
    $_SESSION['usuario_id'] = $usuario['id_usuario'];
    $_SESSION['intentos_login'] = 0;

    // Buscar las aplicaciones del usuario
    $stmtApps = $pdo->prepare("
        SELECT a.id_aplicacion, a.nombre_aplicacion, r.nombre_rol
        FROM usuario_aplicacion_rol uar
        JOIN aplicaciones a ON uar.id_aplicacion = a.id_aplicacion
        JOIN roles r ON uar.id_rol = r.id_rol
        WHERE uar.id_usuario = :id_usuario
    ");
    $stmtApps->execute([':id_usuario' => $usuario['id_usuario']]);
    $apps = $stmtApps->fetchAll();

    if (count($apps) === 0) {
        $mensaje_error = "No tienes acceso a ninguna aplicación. Contacta al administrador.";
    } elseif (count($apps) === 1) {
        // Solo una app, guardar datos y redirigir
        $_SESSION['id_aplicacion'] = $apps[0]['id_aplicacion'];
        $_SESSION['nombre_aplicacion'] = $apps[0]['nombre_aplicacion'];
        $_SESSION['rol'] = $apps[0]['nombre_rol'];
        header("Location: ../view/dashboard.php");
        exit();
    } else {
        // Varias apps → guardamos la lista y mostramos selector
        $_SESSION['apps_disponibles'] = $apps;
        header("Location: ../view/seleccionar_aplicacion.php");
        exit();
    }
}


        // Sumar intento fallido
        $_SESSION['intentos_login']++;
        $_SESSION['ultimo_intento'] = time();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-container {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .login-container img {
            width: 50%;
            margin-bottom: 20px;
        }
        .form-control {
            border-radius: 20px;
        }
        .password-wrapper {
            position: relative;
        }
        .toggle-password {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #888;
        }
        button {
            width: 100%;
            border-radius: 20px;
        }
        .contador {
            margin-top: 10px;
            font-weight: bold;
            color: #dc3545;
        }
    </style>
</head>
<body>

<div class="login-container">
    <img src="../assets/img/login-illustration.png" alt="Login Illustration">
    <h3 class="mb-3">Iniciar sesión</h3>
    <form method="POST" action="login.php">
        <div class="mb-3">
            <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo electrónico" required <?= $bloqueado ? 'disabled' : '' ?>>
        </div>
        <div class="mb-3 password-wrapper">
            <input type="password" class="form-control" id="clave" name="clave" placeholder="Contraseña" required <?= $bloqueado ? 'disabled' : '' ?>>
            <span class="toggle-password" onclick="togglePassword()">👁️</span>
        </div>
        <button type="submit" class="btn btn-primary" <?= $bloqueado ? 'disabled' : '' ?>>Iniciar sesión</button>
    </form>

    <?php
    $intentos_actuales = $_SESSION['intentos_login'] ?? 0;
    $intentos_restantes = max(0, 3 - $intentos_actuales);
    ?>

    <?php if (!$bloqueado && $intentos_actuales > 0): ?>
        <div class="contador">
            Intento <?= $intentos_actuales ?> de 3
        </div>
    <?php elseif ($bloqueado): ?>
        <div class="contador">
            Has superado el número de intentos. Espera <span id="countdown"><?= $segundos_restantes ?></span> segundos...
        </div>
    <?php endif; ?>
</div>

<?php if ($mensaje_error): ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire('Error', '<?= addslashes($mensaje_error) ?>', 'error');
    });
</script>
<?php endif; ?>

<script>
    function togglePassword() {
        const input = document.getElementById('clave');
        input.type = input.type === 'password' ? 'text' : 'password';
    }

    // Contador regresivo
    <?php if ($bloqueado): ?>
    let countdown = <?= $segundos_restantes ?>;
    const countdownElement = document.getElementById('countdown');
    const interval = setInterval(() => {
        countdown--;
        if (countdownElement) countdownElement.textContent = countdown;
        if (countdown <= 0) {
            clearInterval(interval);
            location.reload(); // recarga para habilitar el login
        }
    }, 1000);
    <?php endif; ?>
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
