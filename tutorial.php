<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutorial - Sistema de Reproductor y Grabador HLS</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/themes/prism.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #1a73e8;
            --secondary-color: #34a853;
            --background-color: #f8f9fa;
            --text-color: #f30202;
            --code-bg: #2d2d2d;
            --border-radius: 10px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--text-color);
            background: var(--background-color);
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 280px;
            height: 100vh;
            background: white;
            padding: 20px;
            overflow-y: auto;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }

        .main-content {
            margin-left: 300px;
            padding: 20px;
        }

        .section {
            background: white;
            padding: 30px;
            margin-bottom: 30px;
            border-radius: var(--border-radius);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        h1, h2, h3, h4 {
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        h1 {
            font-size: 2.5em;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--primary-color);
        }

        h2 {
            font-size: 2em;
            margin-top: 40px;
        }

        h3 {
            font-size: 1.5em;
            color: var(--secondary-color);
        }

        .nav-list {
            list-style: none;
        }

        .nav-list li {
            margin-bottom: 10px;
        }

        .nav-list a {
            color: var(--text-color);
            text-decoration: none;
            display: block;
            padding: 8px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .nav-list a:hover {
            background: var(--background-color);
            color: var(--primary-color);
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }

        .feature-card {
            background: var(--background-color);
            padding: 20px;
            border-radius: var(--border-radius);
            border: 1px solid #ddd;
        }

        .code-block {
            background: var(--code-bg);
            padding: 20px;
            border-radius: var(--border-radius);
            margin: 20px 0;
            overflow-x: auto;
        }

        .info-box {
            background: #e3f2fd;
            border-left: 4px solid var(--primary-color);
            padding: 15px;
            margin: 15px 0;
            border-radius: 0 var(--border-radius) var(--border-radius) 0;
        }

        .warning-box {
            background: #fff3e0;
            border-left: 4px solid #ff9800;
            padding: 15px;
            margin: 15px 0;
            border-radius: 0 var(--border-radius) var(--border-radius) 0;
        }

        .step-list {
            list-style: none;
            counter-reset: step-counter;
        }

        .step-list li {
            position: relative;
            padding-left: 50px;
            margin-bottom: 20px;
            counter-increment: step-counter;
        }

        .step-list li::before {
            content: counter(step-counter);
            position: absolute;
            left: 0;
            top: 0;
            width: 35px;
            height: 35px;
            background: var(--primary-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .keyboard-shortcut {
            background: #eee;
            padding: 3px 8px;
            border-radius: 4px;
            font-family: monospace;
            margin: 0 2px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: var(--background-color);
            font-weight: 600;
        }

        .search-box {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            margin-bottom: 20px;
        }

        @media (max-width: 1024px) {
            .sidebar {
                width: 240px;
            }
            .main-content {
                margin-left: 260px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }
            .main-content {
                margin-left: 0;
            }
        }

        .copy-button {
            position: absolute;
            right: 10px;
            top: 10px;
            padding: 5px 10px;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .video-tutorial {
            width: 100%;
            max-width: 800px;
            margin: 20px auto;
            border-radius: var(--border-radius);
            overflow: hidden;
        }
    </style>
</head>
<header>
<?php include 'header.php'; ?>
</header>
<body>
    <div class="sidebar">
        <input type="text" class="search-box" placeholder="Buscar en el tutorial..." id="searchBox">
        <ul class="nav-list">
            <li><a href="#introduccion">Introducción</a></li>
            <li><a href="#instalacion">Instalación</a></li>
            <li><a href="#configuracion">Configuración</a></li>
            <li><a href="#uso">Uso del Sistema</a></li>
            <li><a href="#reproduccion">Reproducción</a></li>
            <li><a href="#grabacion">Grabación</a></li>
            <li><a href="#almacenamiento">Almacenamiento</a></li>
            <li><a href="#troubleshooting">Solución de Problemas</a></li>
            <li><a href="#seguridad">Seguridad</a></li>
            <li><a href="#mantenimiento">Mantenimiento</a></li>
            <li><a href="#optimizacion">Optimización</a></li>
            <li><a href="#api">API</a></li>
        </ul>
    </div>

    <div class="main-content">
        <h1>Tutorial del Sistema de Reproductor y Grabador HLS</h1>

        <section id="introduccion" class="section">
            <h2>Introducción</h2>
            <p>Este sistema proporciona una solución completa para la reproducción y grabación de streams HLS con almacenamiento en servidor.</p>

            <div class="feature-grid">
                <div class="feature-card">
                    <h3><i class="fas fa-play"></i> Reproducción</h3>
                    <ul>
                        <li>Soporte HLS nativo</li>
                        <li>Adaptación de calidad</li>
                        <li>Buffer optimizado</li>
                        <li>Modo de baja latencia</li>
                    </ul>
                </div>
                <div class="feature-card">
                    <h3><i class="fas fa-record-vinyl"></i> Grabación</h3>
                    <ul>
                        <li>Formato WebM optimizado</li>
                        <li>Codificación VP8 + Opus</li>
                        <li>Grabación por segmentos</li>
                        <li>Gestión de almacenamiento</li>
                    </ul>
                </div>
            </div>
        </section>

        <section id="instalacion" class="section">
            <h2>Instalación</h2>
            
            <div class="info-box">
                <strong>Requisitos Previos:</strong>
                <ul>
                    <li>PHP 7.4+</li>
                    <li>MySQL 5.7+</li>
                    <li>Apache/Nginx</li>
                    <li>10GB+ espacio libre</li>
                </ul>
            </div>

            <ol class="step-list">
                <li>
                    <h3>Clonar Repositorio</h3>
                    <div class="code-block">
                        <button class="copy-button">Copiar</button>
                        <pre><code>git clone https://github.com/sabalero23/hls-recorder.git
cd hls-recorder</code></pre>
                    </div>
                </li>
                <li>
                    <h3>Configurar Base de Datos</h3>
                    <div class="code-block">
                        <button class="copy-button">Copiar</button>
                        <pre><code>mysql -u root -p < database.sql</code></pre>
                    </div>
                </li>
                <li>
                    <h3>Configurar config.php</h3>
                    <div class="code-block">
                        <button class="copy-button">Copiar</button>
                        <pre><code>define('DB_HOST', 'localhost');
define('DB_NAME', 'video_system');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
define('UPLOAD_DIR', '/path/to/recordings/');
define('MAX_FILE_SIZE', 10 * 1024 * 1024 * 1024); // 10GB</code></pre>
                    </div>
                </li>
                <li>
                    <h3>Configurar Permisos</h3>
                    <div class="code-block">
                        <button class="copy-button">Copiar</button>
                        <pre><code>chmod 755 recordings/
chown www-data:www-data recordings/</code></pre>
                    </div>
                </li>
            </ol>
        </section>

        <section id="uso" class="section">
            <h2>Uso del Sistema</h2>
            
            <div class="info-box">
                Acceso rápido a funciones principales a través de atajos de teclado.
            </div>

            <h3>Atajos de Teclado</h3>
            <table>
                <tr>
                    <th>Tecla</th>
                    <th>Función</th>
                </tr>
                <tr>
                    <td><span class="keyboard-shortcut">Espacio</span> / <span class="keyboard-shortcut">K</span></td>
                    <td>Play/Pause</td>
                </tr>
                <tr>
                    <td><span class="keyboard-shortcut">F</span></td>
                    <td>Pantalla Completa</td>
                </tr>
                <tr>
                    <td><span class="keyboard-shortcut">M</span></td>
                    <td>Mutear/Desmutear</td>
                </tr>
                <tr>
                    <td><span class="keyboard-shortcut">←</span> / <span class="keyboard-shortcut">→</span></td>
                    <td>Retroceder/Avanzar 5 segundos</td>
                </tr>
                <tr>
                    <td><span class="keyboard-shortcut">↑</span> / <span class="keyboard-shortcut">↓</span></td>
                    <td>Subir/Bajar Volumen</td>
                </tr>
                <tr>
                    <td><span class="keyboard-shortcut">ESC</span></td>
                    <td>Cerrar Modal</td>
                </tr>
            </table>
        </section>

        <section id="reproduccion" class="section">
            <h2>Sistema de Reproducción</h2>
            
            <div class="feature-grid">
                <div class="feature-card">
                    <h3>Características</h3>
                    <ul>
                        <li>Reproducción adaptativa</li>
                        <li>Control de buffer</li>
                        <li>Recuperación de errores</li>
                        <li>Múltiples calidades</li>
                    </ul>
                </div>
                <div class="feature-card">
                    <h3>Formatos Soportados</h3>
                    <ul>
                        <li>HLS (.m3u8)</li>
                        <li>WebM (reproducciones)</li>
                        <li>Streams seguros (HTTPS)</li>
                    </ul>
                </div>
            </div>
        </section>

        <section id="grabacion" class="section">
            <h2>Sistema de Grabación</h2>
            
            <div class="warning-box">
                Asegúrese de tener suficiente espacio en disco antes de iniciar grabaciones largas.
            </div>

            <div class="feature-grid">
                <div class="feature-card">
                    <h3>Proceso de Grabación</h3>
                    <ol>
                        <li>Iniciar grabación</li>
                        <li>Monitorear estado</li>
                        <li>Detener cuando sea necesario</li>
                        <li>Procesamiento automático</li>
                    </ol>
                </div>
                <div class="feature-card">
                    <h3>Especificaciones Técnicas</h3>
                    <ul>
                        <li>Formato: WebM</li>
                        <li>Códec Video: VP8</li>
                        <li>Códec Audio: Opus</li>
                        <li>Chunks de 100ms</li>
                        <li>Buffer optimizado</li>
                    </ul>
                </div>
            </div>

            <h3>Gestión de Grabaciones</h3>
            <div class="info-box">
                <p>Las grabaciones se pueden:</p>
                <ul>
                    <li>Reproducir en el navegador</li>
                    <li>Descargar al dispositivo</li>
                    <li>Eliminar del servidor</li>
                    <li>Previsualizar antes de descargar</li>
                </ul>
            </div>
        </section>

        <section id="almacenamiento" class="section">
            <h2>Sistema de Almacenamiento</h2>

            <div class="feature-grid">
                <div class="feature-card">
                    <h3>Estructura de Archivos</h3>
                    <pre><code>recordings/
├── rec_[timestamp].webm
├── rec_[timestamp].webm
└── ...</code></pre>
                </div>
                <div class="feature-card">
                    <h3>Base de Datos</h3>
                    <pre><code>recordings
├── id (AUTO_INCREMENT)
├── filename
├── original_name
├── file_path
├── file_size
├── duration
├── created_at
└── status</code></pre>
                </div>
            </div>

            <h3>Configuración de Almacenamiento</h3>
            <div class="code-block">
                <button class="copy-button">Copiar</button>
                <pre><code>// Límites de almacenamiento
define('MAX_FILE_SIZE', 10 * 1024 * 1024 * 1024); // 10GB
define('STORAGE_WARN_THRESHOLD', 0.9);  // 90%
define('STORAGE_CRITICAL_THRESHOLD', 0.95);  // 95%

// Configuración PHP
ini_set('upload_max_filesize', '10G');
ini_set('post_max_size', '10G');
ini_set('memory_limit', '10G');
ini_set('max_execution_time', '3600');</code></pre>
            </div>
        </section>

        <section id="troubleshooting" class="section">
            <h2>Solución de Problemas</h2>

            <div class="feature-grid">
                <div class="feature-card">
                    <h3>Problemas de Reproducción</h3>
                    <table>
                        <tr>
                            <th>Problema</th>
                            <th>Solución</th>
                        </tr>
                        <tr>
                            <td>"No supported source"</td>
                            <td>
                                <ul>
                                    <li>Verificar formato WebM</li>
                                    <li>Comprobar codecs</li>
                                    <li>Revisar MIME types</li>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td>Buffer frecuente</td>
                            <td>
                                <ul>
                                    <li>Revisar conexión</li>
                                    <li>Ajustar calidad</li>
                                    <li>Verificar servidor</li>
                                </ul>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="feature-card">
                    <h3>Problemas de Grabación</h3>
                    <table>
                        <tr>
                            <th>Problema</th>
                            <th>Solución</th>
                        </tr>
                        <tr>
                            <td>Error de almacenamiento</td>
                            <td>
                                <ul>
                                    <li>Verificar permisos</li>
                                    <li>Comprobar espacio</li>
                                    <li>Revisar logs</li>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td>Archivo corrupto</td>
                            <td>
                                <ul>
                                    <li>Verificar stream</li>
                                    <li>Comprobar memoria</li>
                                    <li>Revisar codecs</li>
                                </ul>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </section>

        <section id="seguridad" class="section">
            <h2>Seguridad</h2>

            <div class="warning-box">
                <strong>Importante:</strong> Mantener actualizados todos los componentes del sistema.
            </div>

            <div class="feature-grid">
                <div class="feature-card">
                    <h3>Protección de Archivos</h3>
                    <div class="code-block">
                        <button class="copy-button">Copiar</button>
                        <pre><code># .htaccess
<Directory /recordings>
    Options -Indexes
    Order deny,allow
    Deny from all
    <FilesMatch "\.(webm)$">
        Order allow,deny
        Allow from all
        Require all granted
    </FilesMatch>
</Directory></code></pre>
                    </div>
                </div>
                <div class="feature-card">
                    <h3>Validaciones</h3>
                    <ul>
                        <li>Sanitización de entrada</li>
                        <li>Verificación de MIME types</li>
                        <li>Control de acceso</li>
                        <li>Protección XSS</li>
                        <li>Validación de sesiones</li>
                    </ul>
                </div>
            </div>
        </section>

        <section id="mantenimiento" class="section">
            <h2>Mantenimiento</h2>

            <h3>Tareas Programadas</h3>
            <div class="code-block">
                <button class="copy-button">Copiar</button>
                <pre><code># Crontab
# Limpiar archivos antiguos
0 0 * * * php /path/to/cleanup.php

# Verificar espacio
0 */6 * * * php /path/to/check_storage.php

# Backup base de datos
0 2 * * * /path/to/backup_db.sh</code></pre>
            </div>

            <h3>Monitoreo</h3>
            <div class="feature-grid">
                <div class="feature-card">
                    <h3>Logs del Sistema</h3>
                    <pre><code>tail -f /var/log/apache2/error.log
tail -f /path/to/app/error.log</code></pre>
                </div>
                <div class="feature-card">
                    <h3>Métricas</h3>
                    <ul>
                        <li>Uso de disco</li>
                        <li>Rendimiento</li>
                        <li>Errores</li>
                        <li>Accesos</li>
                    </ul>
                </div>
            </div>
        </section>

        <section id="optimizacion" class="section">
            <h2>Optimización</h2>

            <h3>Configuración PHP Optimizada</h3>
            <div class="code-block">
                <button class="copy-button">Copiar</button>
                <pre><code>; php.ini optimizado
memory_limit = 10G
post_max_size = 10G
upload_max_filesize = 10G
max_execution_time = 3600
max_input_time = 3600
opcache.enable = 1
opcache.memory_consumption = 256
opcache.interned_strings_buffer = 16
opcache.max_accelerated_files = 10000</code></pre>
            </div>
        </section>

        <section id="api" class="section">
            <h2>API del Sistema</h2>

            <h3>Endpoints Disponibles</h3>
            <table>
                <tr>
                    <th>Endpoint</th>
                    <th>Método</th>
                    <th>Descripción</th>
                </tr>
                <tr>
                    <td>/save_recording.php</td>
                    <td>POST</td>
                    <td>Guardar nueva grabación</td>
                </tr>
                <tr>
                    <td>/get_recording.php</td>
                    <td>GET</td>
                    <td>Obtener grabación</td>
                </tr>
                <tr>
                    <td>/delete_recording.php</td>
                    <td>POST</td>
                    <td>Eliminar grabación</td>
                </tr>
                <tr>
                    <td>/list_recordings.php</td>
                    <td>GET</td>
                    <td>Listar grabaciones</td>
                </tr>
            </table>
        </section>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.24.1/prism.min.js"></script>
    <script>
        // Funcionalidad de búsqueda
        document.getElementById('searchBox').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const sections = document.querySelectorAll('section');
            
            sections.forEach(section => {
                const text = section.textContent.toLowerCase();
                section.style.display = text.includes(searchTerm) ? 'block' : 'none';
            });
        });

        // Funcionalidad de copiar código
        document.querySelectorAll('.copy-button').forEach(button => {
            button.addEventListener('click', function() {
                const code = this.nextElementSibling.textContent;
                navigator.clipboard.writeText(code).then(() => {
                    const originalText = this.textContent;
                    this.textContent = '¡Copiado!';
                    setTimeout(() => {
                        this.textContent = originalText;
                    }, 2000);
                });
            });
        });

        // Scroll suave
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
<?php include 'footer.php'; ?>
</body>
</html>