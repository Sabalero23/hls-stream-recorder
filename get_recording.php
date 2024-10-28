<?php
session_start();
require_once 'config.php';

if (!isset($_GET['id'])) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'ID de grabación no proporcionado'
    ]);
    exit;
}

try {
    $id = (int)$_GET['id'];
    $db = Database::getInstance()->getConnection();
    
    $stmt = $db->prepare("
        SELECT file_path, mime_type, filename, file_size
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

    if (isset($_GET['stream'])) {
        // Configuración para streaming
        $filePath = $recording['file_path'];
        $fileSize = filesize($filePath);
        $offset = 0;
        $length = $fileSize;

        // Soporte para Range requests
        if (isset($_SERVER['HTTP_RANGE'])) {
            preg_match('/bytes=(\d+)-(\d+)?/', $_SERVER['HTTP_RANGE'], $matches);
            $offset = intval($matches[1]);
            $length = isset($matches[2]) ? (intval($matches[2]) - $offset + 1) : ($fileSize - $offset);
            header('HTTP/1.1 206 Partial Content');
            header('Content-Range: bytes ' . $offset . '-' . ($offset + $length - 1) . '/' . $fileSize);
        }

        // Headers para streaming
        header('Content-Type: ' . $recording['mime_type']);
        header('Content-Length: ' . $length);
        header('Accept-Ranges: bytes');
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: 0');
        header('Pragma: no-cache');
        
        // Enviar archivo
        $file = fopen($filePath, 'rb');
        fseek($file, $offset);
        $sent = 0;
        while (!feof($file) && $sent < $length) {
            $chunk = min(1024 * 1024, $length - $sent); // Enviar en chunks de 1MB
            echo fread($file, $chunk);
            $sent += $chunk;
            flush();
        }
        fclose($file);
        exit;
    }
    
    // Si es una solicitud de descarga
    if (isset($_GET['download'])) {
        header('Content-Type: ' . $recording['mime_type']);
        header('Content-Disposition: attachment; filename="' . $recording['filename'] . '"');
        header('Content-Length: ' . $recording['file_size']);
        header('Cache-Control: no-cache');
        readfile($recording['file_path']);
        exit;
    }
    
    // Si es una solicitud de información
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'data' => [
            'url' => 'get_recording.php?id=' . $id . '&stream=1',
            'type' => $recording['mime_type'],
            'size' => $recording['file_size']
        ]
    ]);

} catch (Exception $e) {
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>