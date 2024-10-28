// download_recording.php
<?php
session_start();
require_once 'config.php';

if (!isset($_GET['id'])) {
    die('ID de grabación no proporcionado');
}

try {
    $id = (int)$_GET['id'];
    $db = Database::getInstance()->getConnection();
    
    $stmt = $db->prepare("
        SELECT file_path, mime_type, filename 
        FROM recordings 
        WHERE id = ? AND status = 'active'
    ");
    
    $stmt->execute([$id]);
    $recording = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$recording) {
        throw new Exception('Grabación no encontrada');
    }
    
    if (!file_exists($recording['file_path'])) {
        throw new Exception('Archivo no encontrado en el servidor');
    }
    
    // Configurar headers para streaming
    header('Content-Type: ' . $recording['mime_type']);
    header('Content-Length: ' . filesize($recording['file_path']));
    header('Accept-Ranges: bytes');
    header('Cache-Control: no-cache, must-revalidate');
    
    // Streaming del archivo
    $fp = fopen($recording['file_path'], 'rb');
    fpassthru($fp);
    fclose($fp);
    exit;

} catch (Exception $e) {
    die('Error: ' . $e->getMessage());
}

// Función de utilidad para formatear tamaños
function formatSize($bytes) {
    $units = ['B', 'KB', 'MB', 'GB'];
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= pow(1024, $pow);
    return round($bytes, 2) . ' ' . $units[$pow];
}