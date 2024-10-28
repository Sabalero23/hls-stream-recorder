<?php
session_start();
require_once 'config.php';

// Limpiar sesión anterior si existe
if (isset($_SESSION['streamUrl'])) {
    unset($_SESSION['streamUrl']);
}

// Procesar formulario
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['streamUrl'])) {
        $url = filter_var($_POST['streamUrl'], FILTER_SANITIZE_URL);
        
        // Validar URL
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            // Verificar si termina en .m3u8
            if (strtolower(pathinfo($url, PATHINFO_EXTENSION)) === 'm3u8') {
                // Verificar si el stream está accesible
                $headers = @get_headers($url);
                if ($headers && strpos($headers[0], '200') !== false) {
                    $_SESSION['streamUrl'] = $url;
                    
                    // Registrar en la base de datos
                    try {
                        $db = Database::getInstance()->getConnection();
                        $stmt = $db->prepare("
                            INSERT INTO stream_sessions (
                                stream_url, 
                                session_id, 
                                user_ip, 
                                user_agent
                            ) VALUES (?, ?, ?, ?)
                        ");
                        $stmt->execute([
                            $url,
                            session_id(),
                            $_SERVER['REMOTE_ADDR'],
                            $_SERVER['HTTP_USER_AGENT']
                        ]);
                        
                        header("Location: reproductor.php");
                        exit();
                    } catch (PDOException $e) {
                        error_log("Error al registrar sesión: " . $e->getMessage());
                        $error = "Error interno del servidor";
                    }
                } else {
                    $error = "El stream no está accesible. Por favor, verifique la URL.";
                }
            } else {
                $error = "La URL debe ser un stream HLS válido (debe terminar en .m3u8)";
            }
        } else {
            $error = "Por favor, ingrese una URL válida";
        }
    }
}

// Obtener streams recientes (últimos 5)
$recentStreams = [];
try {
    $db = Database::getInstance()->getConnection();
    $stmt = $db->query("
        SELECT DISTINCT stream_url, COUNT(*) as uses
        FROM stream_sessions
        GROUP BY stream_url
        ORDER BY MAX(created_at) DESC
        LIMIT 5
    ");
    $recentStreams = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error al obtener streams recientes: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HLS Stream Recorder - Inicio</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #1a73e8;
            --secondary-color: #34a853;
            --background-color: #f0f2f5;
            --text-color: #333;
            --border-radius: 10px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--background-color);
            color: var(--text-color);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .main-container {
            flex: 1;
            padding: 40px 20px;
        }

        .content-wrapper {
            max-width: 800px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo {
            font-size: 2.5em;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .subtitle {
            color: #666;
            font-size: 1.1em;
        }

        .form-container {
            background: white;
            padding: 30px;
            border-radius: var(--border-radius);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 10px;
            color: #555;
            font-weight: 500;
        }

        .form-input {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: var(--border-radius);
            font-size: 1em;
            transition: border-color 0.3s;
        }

        .form-input:focus {
            border-color: var(--primary-color);
            outline: none;
        }

        .submit-button {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: var(--border-radius);
            font-size: 1em;
            cursor: pointer;
            transition: background 0.3s;
            width: 100%;
        }

        .submit-button:hover {
            background: #1557b0;
        }

        .error-message {
            background: #ffebee;
            color: #c62828;
            padding: 10px;
            border-radius: var(--border-radius);
            margin-bottom: 20px;
        }

        .success-message {
            background: #e8f5e9;
            color: #2e7d32;
            padding: 10px;
            border-radius: var(--border-radius);
            margin-bottom: 20px;
        }

        .recent-streams {
            background: white;
            padding: 20px;
            border-radius: var(--border-radius);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .recent-streams h2 {
            color: var(--primary-color);
            margin-bottom: 15px;
            font-size: 1.3em;
        }

        .stream-list {
            list-style: none;
        }

        .stream-item {
            padding: 10px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stream-item:last-child {
            border-bottom: none;
        }

        .stream-url {
            flex: 1;
            margin-right: 10px;
            word-break: break-all;
            color: #666;
        }

        .use-stream-btn {
            background: var(--secondary-color);
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9em;
            white-space: nowrap;
        }

        .use-stream-btn:hover {
            background: #2d7a48;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .feature-card {
            background: white;
            padding: 20px;
            border-radius: var(--border-radius);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            color: var(--primary-color);
            font-size: 2em;
            margin-bottom: 10px;
        }

        .feature-title {
            color: var(--primary-color);
            margin-bottom: 10px;
            font-size: 1.1em;
        }

        .help-text {
            font-size: 0.9em;
            color: #666;
            margin-top: 5px;
        }

        @media (max-width: 768px) {
            .main-container {
                padding: 20px;
            }

            .form-container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="content-wrapper">
            <header class="header">
                <div class="logo">
                    <i class="fas fa-video"></i> HLS Stream Recorder
                </div>
                <p class="subtitle">Graba y gestiona tus streams HLS con facilidad</p>
            </header>

            <div class="form-container">
                <?php if ($error): ?>
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="success-message">
                        <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($success); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="" onsubmit="return validateForm()">
                    <div class="form-group">
                        <label for="streamUrl" class="form-label">URL del Stream HLS</label>
                        <input type="url" 
                               id="streamUrl" 
                               name="streamUrl" 
                               class="form-input"
                               placeholder="https://ejemplo.com/stream/index.m3u8" 
                               required>
                        <p class="help-text">Introduce la URL del stream HLS (debe terminar en .m3u8)</p>
                    </div>
                    <button type="submit" class="submit-button">
                        <i class="fas fa-play"></i> Iniciar Reproductor
                    </button>
                </form>
            </div>

            <?php if (!empty($recentStreams)): ?>
            <div class="recent-streams">
                <h2><i class="fas fa-history"></i> Streams Recientes</h2>
                <ul class="stream-list">
                    <?php foreach ($recentStreams as $stream): ?>
                        <li class="stream-item">
                            <span class="stream-url"><?php echo htmlspecialchars($stream['stream_url']); ?></span>
                            <button class="use-stream-btn" onclick="useStream('<?php echo htmlspecialchars($stream['stream_url']); ?>')">
                                <i class="fas fa-play"></i> Usar
                            </button>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-video"></i></div>
                    <h3 class="feature-title">Grabación HD</h3>
                    <p>Graba streams en alta calidad con formato WebM optimizado.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-hdd"></i></div>
                    <h3 class="feature-title">Almacenamiento</h3>
                    <p>Gestión automática del almacenamiento con 10GB de espacio.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-download"></i></div>
                    <h3 class="feature-title">Descarga</h3>
                    <p>Descarga tus grabaciones en formato compatible.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function validateForm() {
            const url = document.getElementById('streamUrl').value;
            if (!url.toLowerCase().endsWith('.m3u8')) {
                alert('La URL debe ser un stream HLS válido (debe terminar en .m3u8)');
                return false;
            }
            return true;
        }

        function useStream(url) {
            document.getElementById('streamUrl').value = url;
        }
    </script>

<?php include 'footer.php'; ?>
</body>
</html>