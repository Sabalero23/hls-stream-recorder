<?php
session_start();
require_once 'config.php';

// Verificar si hay una URL en la sesión
if (!isset($_SESSION['streamUrl'])) {
    header("Location: index.php");
    exit();
}

$streamUrl = $_SESSION['streamUrl'];

// Registrar sesión de streaming
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
        $streamUrl,
        session_id(),
        $_SERVER['REMOTE_ADDR'],
        $_SERVER['HTTP_USER_AGENT']
    ]);
} catch (PDOException $e) {
    error_log("Error al registrar sesión de streaming: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reproductor de Stream HLS</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/hls.js/1.4.12/hls.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
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
            padding: 20px;
            min-height: 100vh;
        }

        .video-container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: var(--border-radius);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: var(--border-radius);
        }

        .url-display {
            flex: 1;
            margin-right: 20px;
            font-size: 0.9rem;
            color: #666;
            word-break: break-all;
            padding: 10px;
            background: white;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .button {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: all 0.3s ease;
        }

        .primary-button {
            background: var(--primary-color);
            color: white;
        }

        .secondary-button {
            background: var(--secondary-color);
            color: white;
        }

        .button:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        #videoPlayer {
            width: 100%;
            background: #000;
            border-radius: var(--border-radius);
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .controls-container {
            background: #f8f9fa;
            padding: 20px;
            border-radius: var(--border-radius);
            margin-top: 20px;
        }

        .controls-row {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }

        .control-group {
            flex: 1;
            min-width: 200px;
        }

        .slider-container {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 10px 0;
        }

        .slider {
            flex: 1;
            height: 4px;
            border-radius: 2px;
            background: #ddd;
            appearance: none;
            outline: none;
        }

        .slider::-webkit-slider-thumb {
            appearance: none;
            width: 16px;
            height: 16px;
            background: var(--primary-color);
            border-radius: 50%;
            cursor: pointer;
        }

        .status-container {
            margin-top: 20px;
            padding: 15px;
            background: white;
            border-radius: var(--border-radius);
            border: 1px solid #ddd;
        }

        .status-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 5px 0;
            border-bottom: 1px solid #eee;
        }

        .status-row:last-child {
            border-bottom: none;
        }

        .status-label {
            font-weight: 500;
            color: #666;
        }

        .status-value {
            color: var(--primary-color);
            font-weight: 500;
        }

        .record-button {
            background-color: #dc3545 !important;
        }

        .record-button.recording {
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
            100% {
                opacity: 1;
            }
        }

        .recordings-list {
            margin-top: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: var(--border-radius);
        }

        .recording-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px;
            margin: 5px 0;
            background: white;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .recording-info {
            flex: 1;
        }

        .recording-actions {
            display: flex;
            gap: 10px;
        }

        .storage-info {
            background: #f8f9fa;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
            font-size: 0.9em;
        }

        .storage-progress {
            width: 100%;
            height: 4px;
            background: #ddd;
            border-radius: 2px;
            margin: 5px 0;
        }

        .storage-progress-bar {
            height: 100%;
            background: var(--primary-color);
            border-radius: 2px;
            transition: width 0.3s ease;
        }

        .upload-progress {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: #ddd;
            z-index: 1000;
        }

        .upload-progress-bar {
            height: 100%;
            background: var(--primary-color);
            width: 0;
            transition: width 0.3s ease;
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 10px;
            }

            .url-display {
                margin-right: 0;
                margin-bottom: 10px;
            }

            .controls-row {
                flex-direction: column;
            }

            .control-group {
                width: 100%;
            }
        }
    </style>
</head>
<header>
<?php include 'header.php'; ?>
</header>
<body>
    <!-- Barra de progreso de subida -->
    <div class="upload-progress" style="display: none;">
        <div class="upload-progress-bar"></div>
    </div>

    <div class="video-container">
        <div class="header">
            <div class="url-display">
                <i class="fas fa-link"></i>
                <strong>Stream URL:</strong> <?php echo htmlspecialchars($streamUrl); ?>
            </div>
            <div class="action-buttons">
                <a href="index.php" class="button secondary-button">
                    <i class="fas fa-plus"></i> Nueva URL
                </a>
            </div>
        </div>

        <video id="videoPlayer" controls></video>

        <div class="controls-container">
            <div class="controls-row">
                <button class="button primary-button" onclick="playPause()">
                    <i class="fas fa-play"></i> Play/Pause
                </button>
                <button class="button primary-button" onclick="reloadVideo()">
                    <i class="fas fa-sync"></i> Recargar
                </button>
                <button class="button primary-button" onclick="fullScreen()">
                    <i class="fas fa-expand"></i> Pantalla Completa
                </button>
                <button class="button primary-button" onclick="captureSnapshot()">
                    <i class="fas fa-camera"></i> Capturar
                </button>
            </div>

            <!-- Controles de Grabación -->
            <div class="controls-row">
                <button class="button primary-button" id="recordButton" onclick="toggleRecording()">
                    <i class="fas fa-circle"></i> Iniciar Grabación
                </button>
                <button class="button primary-button" id="stopButton" onclick="stopRecording()" disabled>
                    <i class="fas fa-stop"></i> Detener Grabación
                </button>
            </div>

            <div class="control-group">
                <div class="slider-container">
                    <i class="fas fa-volume-up"></i>
                    <input type="range" class="slider" id="volumeSlider" 
                           min="0" max="100" value="100" 
                           oninput="updateVolume(this.value)">
                    <span id="volumeValue">100%</span>
                </div>
            </div>

            <div class="control-group">
                <div class="slider-container">
                    <i class="fas fa-tachometer-alt"></i>
                    <select class="button primary-button" onchange="updatePlaybackRate(this.value)">
                        <option value="0.25">0.25x</option>
                        <option value="0.5">0.5x</option>
                        <option value="0.75">0.75x</option>
                        <option value="1" selected>1x</option>
                        <option value="1.25">1.25x</option>
                        <option value="1.5">1.5x</option>
                        <option value="2">2x</option>
                    </select>
                </div>
            </div>

            <div class="status-container">
                <div class="status-row">
                    <span class="status-label">Estado:</span>
                    <span id="status" class="status-value">Inicializando...</span>
                </div>
                <div class="status-row">
                    <span class="status-label">Calidad:</span>
                    <span id="quality" class="status-value">-</span>
                </div>
                <div class="status-row">
                    <span class="status-label">Buffer:</span>
                    <span id="buffer" class="status-value">-</span>
                </div>
                <div class="status-row">
                    <span class="status-label">Tiempo de reproducción:</span>
                    <span id="playbackTime" class="status-value">00:00:00</span>
                </div>
            </div>
        </div>

        <!-- Información de almacenamiento -->
        <div class="storage-info">
            <p>Espacio de almacenamiento</p>
            <div class="storage-progress">
                <div class="storage-progress-bar" style="width: 0%"></div>
            </div>
            <small>Usado: <span id="storageUsed">0 MB</span> / Disponible: <span id="storageAvailable">100 MB</span></small>
        </div>

        <!-- Lista de grabaciones -->
        <div id="recordingsList" class="recordings-list" style="display: none;">
            <h3>Grabaciones</h3>
            <div id="recordingsContainer"></div>
        </div>
    </div>

<script>
        // Configuración de toastr
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "3000"
        };

        // Variables globales
        const video = document.getElementById('videoPlayer');
        const statusElement = document.getElementById('status');
        const qualityElement = document.getElementById('quality');
        const bufferElement = document.getElementById('buffer');
        const playbackTimeElement = document.getElementById('playbackTime');
        const volumeValueElement = document.getElementById('volumeValue');
        
        const streamUrl = <?php echo json_encode($streamUrl); ?>;
        const maxStorageSize = 10 * 1024 * 1024 * 1024; // 10GB en bytes

        // Variables de grabación
        let mediaRecorder;
        let recordedChunks = [];
        let recordingNumber = 1;
        let isRecording = false;

        // Función para formatear tiempo
        function formatTime(seconds) {
            const h = Math.floor(seconds / 3600);
            const m = Math.floor((seconds % 3600) / 60);
            const s = Math.floor(seconds % 60);
            return `${h.toString().padStart(2, '0')}:${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
        }

        // Actualizar tiempo de reproducción
        setInterval(() => {
            if (!video.paused) {
                playbackTimeElement.textContent = formatTime(video.currentTime);
            }
        }, 1000);

        // Inicialización de HLS
        if (Hls.isSupported()) {
            const hls = new Hls({
                debug: false,
                enableWorker: true,
                lowLatencyMode: true,
                backBufferLength: 90,
                maxBufferLength: 30,
                maxMaxBufferLength: 600,
                maxBufferSize: 60 * 1024 * 1024,
                maxBufferHole: 0.5,
                highBufferWatchdogPeriod: 2,
                nudgeOffset: 0.1,
                nudgeMaxRetry: 5,
                maxFragLookUpTolerance: 0.25,
                liveSyncDurationCount: 3,
                liveMaxLatencyDurationCount: 10,
                enableWebVTT: true,
                enableCEA708Captions: true,
                stretchShortVideoTrack: true,
                maxAudioFramesDrift: 1,
                forceKeyFrameOnDiscontinuity: true,
                abrEwmaFastLive: 3,
                abrEwmaSlowLive: 9,
                abrEwmaFastVoD: 3,
                abrEwmaSlowVoD: 9,
                abrBandWidthFactor: 0.95,
                abrBandWidthUpFactor: 0.7,
                abrMaxWithRealBitrate: true,
                maxStarvationDelay: 4,
                maxLoadingDelay: 4,
                minAutoBitrate: 0,
                emeEnabled: true,
                widevineLicenseUrl: undefined,
                drmSystemOptions: {},
            });

            hls.loadSource(streamUrl);
            hls.attachMedia(video);

            hls.on(Hls.Events.MANIFEST_PARSED, function() {
                statusElement.textContent = 'Stream cargado - Listo para reproducir';
                video.play().catch(function(error) {
                    console.log("Reproducción automática bloqueada:", error);
                    statusElement.textContent = 'Haga clic en play para comenzar';
                });
            });

            hls.on(Hls.Events.ERROR, function(event, data) {
                if (data.fatal) {
                    switch(data.type) {
                        case Hls.ErrorTypes.NETWORK_ERROR:
                            statusElement.textContent = 'Error de red - Intentando reconectar...';
                            hls.startLoad();
                            break;
                        case Hls.ErrorTypes.MEDIA_ERROR:
                            statusElement.textContent = 'Error de medio - Intentando recuperar...';
                            hls.recoverMediaError();
                            break;
                        default:
                            statusElement.textContent = 'Error fatal - Recargue la página';
                            hls.destroy();
                            break;
                    }
                }
            });

            hls.on(Hls.Events.LEVEL_SWITCHED, function(event, data) {
                const levels = hls.levels[data.level];
                if (levels) {
                    qualityElement.textContent = `${levels.width}x${levels.height}@${Math.round(levels.bitrate/1000)}kbps`;
                }
            });

            // Monitor de buffer
            setInterval(() => {
                const buffered = video.buffered;
                if (buffered.length > 0) {
                    const bufferedEnd = buffered.end(buffered.length-1);
                    const duration = video.duration;
                    if (duration > 0) {
                        const bufferedPercent = (bufferedEnd / duration * 100).toFixed(1);
                        bufferElement.textContent = `${bufferedPercent}%`;
                    }
                }
            }, 1000);
        } else {
            statusElement.textContent = 'Tu navegador no soporta HLS';
        }

        // Funciones de grabación
        function setupRecording() {
            const stream = video.captureStream();
            mediaRecorder = new MediaRecorder(stream, {
                mimeType: 'video/webm;codecs=vp8,opus'
            });

            mediaRecorder.ondataavailable = handleDataAvailable;
            mediaRecorder.onstop = handleStop;
        }

        function toggleRecording() {
            if (!isRecording) {
                startRecording();
            } else {
                stopRecording();
            }
        }

        function startRecording() {
            if (!mediaRecorder) {
                setupRecording();
            }

            recordedChunks = [];
            mediaRecorder.start(100); // Grabar en chunks de 100ms
            isRecording = true;

            const recordButton = document.getElementById('recordButton');
            recordButton.classList.add('record-button', 'recording');
            recordButton.innerHTML = '<i class="fas fa-circle"></i> Grabando...';
            
            document.getElementById('stopButton').disabled = false;
            statusElement.textContent = 'Grabando...';
        }

        function stopRecording() {
            if (mediaRecorder && mediaRecorder.state !== 'inactive') {
                mediaRecorder.stop();
                isRecording = false;

                const recordButton = document.getElementById('recordButton');
                recordButton.classList.remove('record-button', 'recording');
                recordButton.innerHTML = '<i class="fas fa-circle"></i> Iniciar Grabación';
                
                document.getElementById('stopButton').disabled = true;
                statusElement.textContent = video.paused ? 'Pausado' : 'Reproduciendo';
            }
        }

        function handleDataAvailable(event) {
            if (event.data.size > 0) {
                recordedChunks.push(event.data);
            }
        }

        async function handleStop() {
            const blob = new Blob(recordedChunks, {
                type: 'video/webm'
            });
            
            const recordingInfo = {
                duration: formatTime(video.currentTime),
                timestamp: new Date().toISOString()
            };

            await saveRecordingToServer(blob, recordingInfo);
        }

        async function saveRecordingToServer(blob, recordingInfo) {
            const formData = new FormData();
            formData.append('recording', blob, 'recording.webm');
            formData.append('duration', recordingInfo.duration);
            formData.append('timestamp', recordingInfo.timestamp);

            try {
                $('.upload-progress').show();
                
                const response = await fetch('save_recording.php', {
                    method: 'POST',
                    body: formData,
                    xhr: function() {
                        const xhr = new XMLHttpRequest();
                        xhr.upload.addEventListener('progress', function(e) {
                            if (e.lengthComputable) {
                                const percentComplete = (e.loaded / e.total) * 100;
                                $('.upload-progress-bar').css('width', percentComplete + '%');
                            }
                        }, false);
                        return xhr;
                    }
                });

                const result = await response.json();
                
                if (result.success) {
                    toastr.success('Grabación guardada correctamente');
                    addRecordingToList(result.data);
                    updateStorageInfo();
                } else {
                    throw new Error(result.message);
                }
            } catch (error) {
                toastr.error('Error al guardar la grabación: ' + error.message);
            } finally {
                $('.upload-progress').hide();
                $('.upload-progress-bar').css('width', '0%');
            }
        }

        function updateStorageInfo() {
    fetch('get_storage_info.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Usar el límite del servidor en lugar del valor fijo
                const maxSize = data.data.limit || (10 * 1024 * 1024 * 1024); // 10GB como respaldo
                const usedPercentage = (data.data.used / maxSize) * 100;
                $('.storage-progress-bar').css('width', usedPercentage + '%');
                $('#storageUsed').text(formatSize(data.data.used));
                $('#storageAvailable').text(formatSize(maxSize));

                // Cambiar color de la barra de progreso según el uso
                if (usedPercentage > 90) {
                    $('.storage-progress-bar').css('background-color', '#dc3545'); // rojo
                } else if (usedPercentage > 70) {
                    $('.storage-progress-bar').css('background-color', '#ffc107'); // amarillo
                } else {
                    $('.storage-progress-bar').css('background-color', 'var(--primary-color)'); // color normal
                }

                // Mostrar advertencia si queda poco espacio
                if (usedPercentage > 90) {
                    toastr.warning('¡Queda poco espacio de almacenamiento!');
                }
            }
        })
        .catch(error => {
            console.error('Error al actualizar info de almacenamiento:', error);
            toastr.error('Error al obtener información de almacenamiento');
        });
}

        // Funciones de control básicas
        function playPause() {
            if (video.paused) {
                video.play();
            } else {
                video.pause();
            }
        }

        function reloadVideo() {
            const currentTime = video.currentTime;
            video.load();
            video.currentTime = currentTime;
            video.play();
        }

        function fullScreen() {
            if (video.requestFullscreen) {
                video.requestFullscreen();
            } else if (video.webkitRequestFullscreen) {
                video.webkitRequestFullscreen();
            } else if (video.msRequestFullscreen) {
                video.msRequestFullscreen();
            }
        }

        function updateVolume(value) {
            video.volume = value / 100;
            volumeValueElement.textContent = `${value}%`;
        }

        function updatePlaybackRate(value) {
            video.playbackRate = parseFloat(value);
        }

        function captureSnapshot() {
            const canvas = document.createElement('canvas');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            const ctx = canvas.getContext('2d');
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            
            const link = document.createElement('a');
            link.download = `snapshot_${new Date().toISOString()}.png`;
            link.href = canvas.toDataURL('image/png');
            link.click();
        }

        // Eventos del reproductor
        video.addEventListener('playing', () => {
            statusElement.textContent = 'Reproduciendo';
        });

        video.addEventListener('pause', () => {
            statusElement.textContent = 'Pausado';
        });

        video.addEventListener('waiting', () => {
            statusElement.textContent = 'Buffering...';
        });

        video.addEventListener('error', (e) => {
            statusElement.textContent = 'Error: ' + (e.message || 'Error desconocido');
        });

        video.addEventListener('ended', () => {
            if (isRecording) {
                stopRecording();
            }
        });

        // Control por teclado
        document.addEventListener('keydown', (e) => {
            switch(e.key.toLowerCase()) {
                case ' ':  // Espacio
                case 'k':  // YouTube style
                    playPause();
                    e.preventDefault();
                    break;
                case 'f':  // Pantalla completa
                    fullScreen();
                    e.preventDefault();
                    break;
                case 'r':  // Recargar
                    reloadVideo();
                    e.preventDefault();
                    break;
                case 'm':  // Mutear/Desmutear
                    video.muted = !video.muted;
                    volumeSlider.value = video.muted ? 0 : (video.volume * 100);
                    volumeValueElement.textContent = video.muted ? '0%' : `${Math.round(video.volume * 100)}%`;
                    e.preventDefault();
                    break;
                case 'arrowleft':  // Retroceder 5 segundos
                    video.currentTime = Math.max(0, video.currentTime - 5);
                    e.preventDefault();
                    break;
                case 'arrowright':  // Adelantar 5 segundos
                    video.currentTime = Math.min(video.duration, video.currentTime + 5);
                    e.preventDefault();
                    break;
                case 'arrowup':  // Subir volumen
                    const newVolUp = Math.min(1, video.volume + 0.05);
                    video.volume = newVolUp;
                    volumeSlider.value = newVolUp * 100;
                    volumeValueElement.textContent = `${Math.round(newVolUp * 100)}%`;
                    e.preventDefault();
                    break;
                case 'arrowdown':  // Bajar volumen
                    const newVolDown = Math.max(0, video.volume - 0.05);
                    video.volume = newVolDown;
                    volumeSlider.value = newVolDown * 100;
                    volumeValueElement.textContent = `${Math.round(newVolDown * 100)}%`;
                    e.preventDefault();
                    break;
            }
        });

        // Inicialización
        document.addEventListener('DOMContentLoaded', () => {
            updateStorageInfo();
            
            // Cargar grabaciones existentes
            fetch('list_recordings.php')
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.data.length > 0) {
                        const recordingsList = document.getElementById('recordingsList');
                        recordingsList.style.display = 'block';
                        data.data.forEach(recording => addRecordingToList(recording));
                    }
                })
                .catch(error => console.error('Error al cargar grabaciones:', error));
        });

        // Función para añadir grabación a la lista
        function addRecordingToList(recording) {
            const recordingsContainer = document.getElementById('recordingsContainer');
            const recordingItem = document.createElement('div');
            recordingItem.className = 'recording-item';
            recordingItem.dataset.id = recording.id;
            
            recordingItem.innerHTML = `
                <div class="recording-info">
                    <strong>${recording.filename}</strong>
                    <div class="recording-size">
                        Tamaño: ${recording.size}
                        <br>
                        Fecha: ${new Date(recording.created_at).toLocaleString()}
                    </div>
                </div>
                <div class="recording-actions">
                    <button class="button primary-button" onclick="playRecording(${recording.id})">
                        <i class="fas fa-play"></i>
                    </button>
                    <button class="button primary-button" onclick="downloadRecording(${recording.id})">
                        <i class="fas fa-download"></i>
                    </button>
                    <button class="button record-button" onclick="deleteRecording(${recording.id})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;
            
            recordingsContainer.insertBefore(recordingItem, recordingsContainer.firstChild);
        }

        // Funciones para manipular grabaciones
        async function playRecording(id) {
    try {
        const response = await fetch(`get_recording.php?id=${id}`);
        const data = await response.json();
        
        if (data.success) {
            // Crear el contenedor modal
            const modal = document.createElement('div');
            modal.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0,0,0,0.9);
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                z-index: 1000;
                padding: 20px;
            `;

            // Crear el contenedor del video
            const videoContainer = document.createElement('div');
            videoContainer.style.cssText = `
                width: 100%;
                max-width: 800px;
                position: relative;
                background: #000;
                border-radius: 8px;
                overflow: hidden;
            `;

            // Crear el video player
            const videoPlayer = document.createElement('video');
            videoPlayer.style.cssText = `
                width: 100%;
                height: auto;
                max-height: 80vh;
            `;
            videoPlayer.controls = true;
            videoPlayer.preload = 'auto';
            videoPlayer.autoplay = true;

            // Crear el botón de cierre
            const closeButton = document.createElement('button');
            closeButton.innerHTML = '×';
            closeButton.style.cssText = `
                position: absolute;
                top: 10px;
                right: 10px;
                background: rgba(255,255,255,0.3);
                border: none;
                color: white;
                font-size: 24px;
                width: 40px;
                height: 40px;
                border-radius: 20px;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: background 0.3s;
            `;
            closeButton.onmouseover = () => closeButton.style.background = 'rgba(255,255,255,0.5)';
            closeButton.onmouseout = () => closeButton.style.background = 'rgba(255,255,255,0.3)';

            // Crear mensajes de estado
            const statusMessage = document.createElement('div');
            statusMessage.style.cssText = `
                color: white;
                margin-top: 15px;
                text-align: center;
                font-size: 14px;
            `;
            statusMessage.textContent = 'Cargando video...';

            // Agregar fuentes de video
            const source = document.createElement('source');
            source.src = `get_recording.php?id=${id}&stream=1`;
            source.type = 'video/webm';
            videoPlayer.appendChild(source);

            // Manejar eventos del video
            videoPlayer.addEventListener('loadeddata', () => {
                statusMessage.textContent = 'Video cargado';
                setTimeout(() => statusMessage.style.display = 'none', 1000);
            });

            videoPlayer.addEventListener('error', (e) => {
                statusMessage.textContent = 'Error al cargar el video. Intentando método alternativo...';
                // Método alternativo usando Blob
                fetch(`get_recording.php?id=${id}&stream=1`)
                    .then(response => response.blob())
                    .then(blob => {
                        const url = URL.createObjectURL(blob);
                        videoPlayer.src = url;
                        videoPlayer.onended = () => URL.revokeObjectURL(url);
                    })
                    .catch(error => {
                        statusMessage.textContent = 'Error al reproducir el video: ' + error.message;
                    });
            });

            // Agregar elementos al DOM
            videoContainer.appendChild(videoPlayer);
            videoContainer.appendChild(closeButton);
            modal.appendChild(videoContainer);
            modal.appendChild(statusMessage);
            document.body.appendChild(modal);

            // Manejar cierre
            closeButton.onclick = () => {
                videoPlayer.pause();
                modal.remove();
            };
            modal.onclick = (e) => {
                if (e.target === modal) {
                    videoPlayer.pause();
                    modal.remove();
                }
            };

            // Manejar tecla ESC
            const handleEsc = (e) => {
                if (e.key === 'Escape') {
                    videoPlayer.pause();
                    modal.remove();
                    document.removeEventListener('keydown', handleEsc);
                }
            };
            document.addEventListener('keydown', handleEsc);

        } else {
            throw new Error(data.message);
        }
    } catch (error) {
        toastr.error('Error al reproducir grabación: ' + error.message);
    }
}

        async function downloadRecording(id) {
            try {
                window.location.href = `get_recording.php?id=${id}&download=1`;
            } catch (error) {
                toastr.error('Error al descargar grabación: ' + error.message);
            }
        }

        async function deleteRecording(id) {
            if (confirm('¿Estás seguro de que quieres eliminar esta grabación?')) {
                try {
                    const response = await fetch('delete_recording.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ id: id })
                    });
                    
                    const result = await response.json();
                    
                    if (result.success) {
                        const recordingElement = document.querySelector(`[data-id="${id}"]`);
                        if (recordingElement) {
                            recordingElement.remove();
                        }
                        toastr.success('Grabación eliminada correctamente');
                        updateStorageInfo();

                        // Ocultar la lista si no hay más grabaciones
                        const recordingsContainer = document.getElementById('recordingsContainer');
                        if (!recordingsContainer.children.length) {
                            document.getElementById('recordingsList').style.display = 'none';
                        }
                    } else {
                        throw new Error(result.message);
                    }
                } catch (error) {
                    toastr.error('Error al eliminar grabación: ' + error.message);
                }
            }
        }

        // Funciones de utilidad
        function formatSize(bytes) {
            const units = ['B', 'KB', 'MB', 'GB'];
            let size = bytes;
            let unitIndex = 0;
            
            while (size >= 1024 && unitIndex < units.length - 1) {
                size /= 1024;
                unitIndex++;
            }
            
            return `${size.toFixed(2)} ${units[unitIndex]}`;
        }
    </script>
<br>
<?php include 'footer.php'; ?>
</body>
</html>