<?php
/**
 * Este archivo forma parte de Aplicacion_LOGIN.
 * Licenciado bajo la GNU General Public License v3.0.
 * Más información en https://www.gnu.org/licenses/gpl-3.0.html
 * Autor: Manuel Molina Sánchez
 */

require_once 'config.php';

try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,  // Excepciones para errores
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,        // Resultados como arrays asociativos
        PDO::ATTR_EMULATE_PREPARES   => false,                   // Preparación nativa
    ];

    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
    die("❌ Error de conexión: " . $e->getMessage());
}
?>
