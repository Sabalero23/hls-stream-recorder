<?php
session_start();
require_once 'config.php';

header('Content-Type: application/json');

try {
    $db = Database::getInstance()->getConnection();
    
    // Obtener el tamaño total de todas las grabaciones activas
    $stmt = $db->query("SELECT SUM(file_size) as total_size FROM recordings WHERE status = 'active'");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $used = $result['total_size'] ?: 0;
    
    // Obtener espacio disponible real en el servidor
    $uploadDir = UPLOAD_DIR;
    $totalSpace = disk_free_space($uploadDir);
    
    // Establecer límite máximo (10GB)
    $maxLimit = 10 * 1024 * 1024 * 1024; // 10GB en bytes
    
    echo json_encode([
        'success' => true,
        'data' => [
            'used' => (int)$used,
            'available' => $totalSpace,
            'limit' => $maxLimit,
            'disk_free' => disk_free_space($uploadDir),
            'disk_total' => disk_total_space($uploadDir)
        ]
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error al obtener información de almacenamiento: ' . $e->getMessage()
    ]);
}