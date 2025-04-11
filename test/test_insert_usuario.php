<?php
/**
 * Este archivo forma parte de Aplicacion_LOGIN.
 * Licenciado bajo la GNU General Public License v3.0.
 * Más información en https://www.gnu.org/licenses/gpl-3.0.html
 * Autor: Manuel Molina Sánchez
 */

require_once __DIR__ . '/../includes/conexion.php';

// Datos simulados
$nombre = "Usuario moderno";
$correo = "moderno@example.com";
$clave = password_hash("ClaveSegura2025!", PASSWORD_DEFAULT);
$imagen = "avatar1.png";
$token = bin2hex(random_bytes(32));

try {
    $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, correo, clave, imagen, token_verificacion)
                           VALUES (:nombre, :correo, :clave, :imagen, :token)");

    $stmt->execute([
        ':nombre' => $nombre,
        ':correo' => $correo,
        ':clave'  => $clave,
        ':imagen' => $imagen,
        ':token'  => $token
    ]);

    echo "✅ Usuario insertado correctamente con ID: " . $pdo->lastInsertId();
    echo "<br>Token generado: $token";

} catch (PDOException $e) {
    echo "❌ Error al insertar usuario: " . $e->getMessage();
}
