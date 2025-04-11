<?php
/**
 * Este archivo forma parte de Aplicacion_LOGIN.
 * Licenciado bajo la GNU General Public License v3.0.
 * Más información en https://www.gnu.org/licenses/gpl-3.0.html
 * Autor: Manuel Molina Sánchez
 */

session_start();

// --- Parte común a cualquier aplicación: validación del login y acceso ---
if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['id_aplicacion']) || !isset($_SESSION['rol'])) {
    header("Location: ../view/login.php");
    exit();
}

// Verificar que la aplicación en sesión es la de noticias (id_aplicacion = 3)
if ($_SESSION['id_aplicacion'] != 3) {  // Suponiendo que "noticias" tiene id_aplicacion = 3
    header("Location: ../view/seleccionar_aplicacion.php");
    exit();
}

// --- Aquí empieza la parte específica de la aplicación de Noticias ---
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Noticias - <?= $_SESSION['nombre_aplicacion'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Barra de navegación (opcional) -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Noticias</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Categorías</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Cerrar sesión</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="container mt-4">
        <h1>Bienvenido a las Noticias de <?= $_SESSION['nombre_aplicacion'] ?></h1>

        <!-- Opciones según el rol -->
        <?php if ($_SESSION['rol'] == 'admin'): ?>
            <div class="alert alert-info" role="alert">
                Estás logueado como Administrador. Puedes <a href="gestion_noticias.php" class="alert-link">gestionar las noticias</a>.
            </div>
        <?php elseif ($_SESSION['rol'] == 'editor'): ?>
            <div class="alert alert-warning" role="alert">
                Estás logueado como Editor. Puedes <a href="crear_noticia.php" class="alert-link">crear nuevas noticias</a>.
            </div>
        <?php elseif ($_SESSION['rol'] == 'viewer'): ?>
            <div class="alert alert-success" role="alert">
                Estás logueado como Lector. Puedes leer las noticias.
            </div>
        <?php endif; ?>

        <!-- Ejemplo de Noticias -->
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <img src="noticia1.jpg" class="card-img-top" alt="Noticia 1">
                    <div class="card-body">
                        <h5 class="card-title">Noticia 1</h5>
                        <p class="card-text">Resumen de la noticia 1...</p>
                        <a href="detalle_noticia.php?id=1" class="btn btn-primary">Leer más</a>
                    </div>
                </div>
            </div>
            <!-- Más noticias aquí... -->
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
