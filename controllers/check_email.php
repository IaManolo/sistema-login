<?php
/**
 * Este archivo forma parte de Aplicacion_LOGIN.
 * Licenciado bajo la GNU General Public License v3.0.
 * Más información en https://www.gnu.org/licenses/gpl-3.0.html
 * Autor: Manuel Molina Sánchez
 */

header('Content-Type: application/json');
require_once '../includes/conexion.php';

$correo = $_GET['correo'] ?? '';

if (empty($correo)) {
    echo json_encode(['error' => 'Correo no recibido']);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE correo = :correo");
    $stmt->execute([':correo' => $correo]);
    $existe = $stmt->fetchColumn() > 0;

    echo json_encode(['existe' => $existe]);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error de base de datos']);
}
