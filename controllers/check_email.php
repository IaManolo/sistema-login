<?php
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
