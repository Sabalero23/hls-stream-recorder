<?php
// validar.php - Script para validar la URL y redirigir al reproductor
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $streamUrl = filter_input(INPUT_POST, 'streamUrl', FILTER_SANITIZE_URL);
    
    // Validación adicional en el servidor
    if (filter_var($streamUrl, FILTER_VALIDATE_URL) && 
        strtolower(pathinfo($streamUrl, PATHINFO_EXTENSION)) === 'm3u8') {
        
        $_SESSION['streamUrl'] = $streamUrl;
        header("Location: reproductor.php");
        exit();
    } else {
        header("Location: index.php?error=url_invalida");
        exit();
    }
}