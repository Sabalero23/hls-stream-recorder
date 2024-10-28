<?php
session_start();
require_once 'config.php';

header('Content-Type: application/json');

try {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['id'])) {
        throw new Exception('ID de grabación no proporcionado');
    }

    $id = (int)$data['id'];
    $db = Database::getInstance()->getConnection();

    // Obtener información del archivo
    $stmt = $db->prepare("
        SELECT file_path 
        FROM recordings 
        WHERE id = ? AND status = 'active'
    ");
    $stmt->execute([$id]);
    $recording = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$recording) {
        throw new Exception('Grabación no encontrada');
    }

    // Eliminar el archivo físico
    if (file_exists($recording['file_path'])) {
        if (!unlink($recording['file_path'])) {
            throw new Exception('No se pudo eliminar el archivo físico');
        }
    }

    // Marcar como eliminado en la base de datos
    $stmt = $db->prepare("
        UPDATE recordings 
        SET status = 'deleted' 
        WHERE id = ?
    ");
    $stmt->execute([$id]);

    echo json_encode([
        'success' => true,
        'message' => 'Grabación eliminada correctamente'
    ]);

} catch (Exception $e) {
    error_log("Error en delete_recording.php: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>