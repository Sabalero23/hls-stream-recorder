<?php
session_start();
require_once 'config.php';

header('Content-Type: application/json');

try {
    $db = Database::getInstance()->getConnection();
    
    // Obtener todas las grabaciones activas ordenadas por fecha
    $stmt = $db->prepare("
        SELECT 
            id,
            filename,
            file_size,
            duration,
            created_at,
            original_name
        FROM recordings 
        WHERE status = 'active' 
        ORDER BY created_at DESC
    ");
    
    $stmt->execute();
    $recordings = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Formatear los datos para la respuesta
    foreach ($recordings as &$recording) {
        $recording['size'] = formatSize($recording['file_size']);
        $recording['created_at'] = date('Y-m-d H:i:s', strtotime($recording['created_at']));
    }
    
    echo json_encode([
        'success' => true,
        'data' => $recordings
    ]);

} catch (Exception $e) {
    error_log("Error en list_recordings.php: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error al obtener la lista de grabaciones: ' . $e->getMessage()
    ]);
}

// Función para formatear el tamaño
function formatSize($bytes) {
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= pow(1024, $pow);
    return round($bytes, 2) . ' ' . $units[$pow];
}
?>