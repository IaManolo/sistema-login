<?php
/**
 * Este archivo forma parte de Aplicacion_LOGIN.
 * Licenciado bajo la GNU General Public License v3.0.
 * Más información en https://www.gnu.org/licenses/gpl-3.0.html
 * Autor: Manuel Molina Sánchez
 */

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/registro.css">
</head>
<body>

<div class="registro-container">
    <h2 class="mb-4 text-center">Crear cuenta</h2>

    <form id="registroForm" method="POST" action="../controllers/AuthController.php" enctype="multipart/form-data">
        <!-- Nombre -->
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre completo</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>

        <!-- Correo -->
        <div class="mb-3">
            <label for="correo" class="form-label">Correo electrónico</label>
            <input type="email" class="form-control" id="correo" name="correo" required>
            <div id="correoFeedback" class="form-text text-danger"></div>
        </div>

        <!-- Contraseña con validación visual -->
        <div class="mb-3">
            <label for="clave" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="clave" name="clave" required>
            <ul id="passwordChecklist" class="form-text ps-3">
                <li id="req-length">❌ Mínimo 8 caracteres</li>
                <li id="req-uppercase">❌ Al menos una mayúscula</li>
                <li id="req-number">❌ Al menos un número</li>
                <li id="req-symbol">❌ Al menos un símbolo</li>
            </ul>
        </div>

        <!-- Avatares predefinidos -->
        <div class="mb-3">
            <label class="form-label">O elige un avatar:</label>
            <div class="d-flex gap-3">
                <label>
                    <input type="radio" name="avatar" value="avatar_1.png" hidden>
                    <img src="../assets/img/avatar_1.png" class="preview-img avatar-option">
                </label>
                <label>
                    <input type="radio" name="avatar" value="avatar_2.png" hidden>
                    <img src="../assets/img/avatar_2.png" class="preview-img avatar-option">
                </label>
                <label>
                    <input type="radio" name="avatar" value="avatar_3.png" hidden>
                    <img src="../assets/img/avatar_3.png" class="preview-img avatar-option">
                </label>
            </div>
        </div>

        <!-- Subida de imagen personalizada -->
        <div class="mb-3">
            <label class="form-label">O sube tu propia imagen:</label>
            <input class="form-control" type="file" name="imagen" id="imagen">
            <img id="preview" class="preview-img" src="../assets/img/default.png" alt="Vista previa">
        </div>

        <!-- Botón de registro -->
        <button type="submit" class="btn btn-primary w-100">Registrarse</button>
    </form>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/registro.js"></script>

</body>
</html>
