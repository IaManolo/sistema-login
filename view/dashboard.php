<?php
/**
 * Este archivo forma parte de Aplicacion_LOGIN.
 * Licenciado bajo la GNU General Public License v3.0.
 * Más información en https://www.gnu.org/licenses/gpl-3.0.html
 * Autor: Manuel Molina Sánchez
 */

session_start();

if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['id_aplicacion']) || !isset($_SESSION['rol'])) {
    header("Location: ../login.php");
    exit();
}

$nombre_app = $_SESSION['nombre_aplicacion'] ?? 'Aplicación desconocida';
$rol = $_SESSION['rol'] ?? 'Sin rol';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel - <?= htmlspecialchars($nombre_app) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f5f8ff;
            min-height: 100vh;
            padding-top: 50px;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .logout-btn {
            position: absolute;
            top: 20px;
            right: 30px;
        }
    </style>
</head>
<body>

<div class="container text-center">
    <a href="../logout.php" class="btn btn-danger logout-btn">Cerrar sesión</a>

    <h1 class="mb-4">Bienvenido</h1>

    <div class="card p-4">
        <h3 class="mb-2"><?= htmlspecialchars($nombre_app) ?></h3>
        <p class="text-muted">Estás accediendo como <strong><?= htmlspecialchars($rol) ?></strong></p>

        <?php if ($rol === 'admin'): ?>
            <a href="admin/usuarios.php" class="btn btn-primary mt-3">Gestionar Usuarios</a>
        <?php elseif ($rol === 'editor'): ?>
            <a href="editor/contenido.php" class="btn btn-secondary mt-3">Editar Contenido</a>
        <?php elseif ($rol === 'viewer'): ?>
            <a href="viewer/ver.php" class="btn btn-info mt-3">Ver Contenido</a>
        <?php else: ?>
            <p class="text-warning mt-3">No tienes acciones asignadas aún.</p>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
