<?php
session_start();
require_once 'config.php';

header('Content-Type: application/json');

try {
    // Verificar si hay suficiente espacio en disco
    $freeSpace = disk_free_space(UPLOAD_DIR);
    if ($freeSpace < MAX_FILE_SIZE) {
        throw new Exception('No hay suficiente espacio en disco');
    }

    // Verificar si se recibió el archivo
    if (empty($_FILES['recording'])) {
        throw new Exception('No se recibió ningún archivo');
    }

    $file = $_FILES['recording'];
    
    // Validaciones básicas
    if ($file['error'] !== UPLOAD_ERR_OK) {
        switch ($file['error']) {
            case UPLOAD_ERR_INI_SIZE:
                throw new Exception('El archivo excede el tamaño permitido por PHP');
            case UPLOAD_ERR_FORM_SIZE:
                throw new Exception('El archivo excede el tamaño permitido por el formulario');
            case UPLOAD_ERR_PARTIAL:
                throw new Exception('El archivo se subió parcialmente');
            case UPLOAD_ERR_NO_FILE:
                throw new Exception('No se subió ningún archivo');
            case UPLOAD_ERR_NO_TMP_DIR:
                throw new Exception('Falta la carpeta temporal');
            case UPLOAD_ERR_CANT_WRITE:
                throw new Exception('Error al escribir el archivo');
            default:
                throw new Exception('Error desconocido al subir el archivo');
        }
    }

    // Generar nombre único para el archivo
    $fileName = uniqid('rec_') . '_' . date('Ymd_His') . '.webm';
    $filePath = UPLOAD_DIR . $fileName;

    // Mover el archivo
    if (!move_uploaded_file($file['tmp_name'], $filePath)) {
        throw new Exception('Error al mover el archivo');
    }

    // Guardar en la base de datos
    $db = Database::getInstance()->getConnection();
    
    $stmt = $db->prepare("
        INSERT INTO recordings (
            filename,
            original_name,
            file_path,
            file_size,
            mime_type,
            user_ip,
            duration,
            user_agent
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $duration = isset($_POST['duration']) ? $_POST['duration'] : '00:00:00';

    $stmt->execute([
        $fileName,
        $file['name'],
        $filePath,
        $file['size'],
        $file['type'],
        $_SERVER['REMOTE_ADDR'],
        $duration,
        $_SERVER['HTTP_USER_AGENT']
    ]);

    $recordingId = $db->lastInsertId();

    echo json_encode([
        'success' => true,
        'message' => 'Grabación guardada correctamente',
        'data' => [
            'id' => $recordingId,
            'filename' => $fileName,
            'path' => $filePath,
            'size' => formatSize($file['size']),
            'created_at' => date('Y-m-d H:i:s')
        ]
    ]);

} catch (Exception $e) {
    error_log("Error en save_recording.php: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

function formatSize($bytes) {
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= pow(1024, $pow);
    return round($bytes, 2) . ' ' . $units[$pow];
}
?>