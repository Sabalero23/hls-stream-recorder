// get_recording_details.php
<?php
session_start();
require_once 'config.php';

header('Content-Type: application/json');

try {
    if (!isset($_GET['id'])) {
        throw new Exception('ID de grabación no proporcionado');
    }

    $id = (int)$_GET['id'];
    $db = Database::getInstance()->getConnection();
    
    $stmt = $db->prepare("
        SELECT 
            id,
            filename,
            original_name,
            file_size,
            duration,
            created_at,
            mime_type
        FROM recordings 
        WHERE id = ? AND status = 'active'
    ");
    
    $stmt->execute([$id]);
    $recording = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$recording) {
        throw new Exception('Grabación no encontrada');
    }
    
    // Formatear el tamaño del archivo
    $recording['size'] = formatSize($recording['file_size']);
    
    echo json_encode([
        'success' => true,
        'data' => $recording
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}