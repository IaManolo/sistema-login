<?php
session_start();

if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['apps_disponibles'])) {
    header("Location: login.php");
    exit();
}

$apps = $_SESSION['apps_disponibles'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_aplicacion'])) {
    $id = $_POST['id_aplicacion'];

    // Buscar la app seleccionada en la lista
    foreach ($apps as $app) {
        if ($app['id_aplicacion'] == $id) {
            $_SESSION['id_aplicacion'] = $app['id_aplicacion'];
            $_SESSION['nombre_aplicacion'] = $app['nombre_aplicacion'];
            $_SESSION['rol'] = $app['nombre_rol'];
            break;
        }
    }

    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Seleccionar aplicación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #8360c3, #2ebf91);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: start;
            padding: 40px 20px;
        }
        .container {
            max-width: 800px;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transition: transform 0.2s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .app-title {
            font-weight: bold;
            font-size: 1.3rem;
        }
        .app-role {
            font-size: 0.95rem;
            color: #555;
        }
        .btn-acceder {
            border-radius: 20px;
        }
    </style>
</head>
<body>

<div class="container text-center">
    <h2 class="text-white mb-4">Selecciona una aplicación</h2>

    <div class="row g-4">
        <?php foreach ($apps as $app): ?>
            <div class="col-md-6">
                <form method="POST">
                    <input type="hidden" name="id_aplicacion" value="<?= htmlspecialchars($app['id_aplicacion']) ?>">
                    <div class="card p-4">
                        <div class="app-title"><?= htmlspecialchars($app['nombre_aplicacion']) ?></div>
                        <div class="app-role">Rol: <?= htmlspecialchars($app['nombre_rol']) ?></div>
                        <button type="submit" class="btn btn-primary mt-3 btn-acceder">Acceder</button>
                    </div>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
