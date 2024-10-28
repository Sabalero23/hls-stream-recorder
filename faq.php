<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - HLS Stream Recorder</title>
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
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .header h1 {
            font-size: 2.5em;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .search-container {
            max-width: 600px;
            margin: 0 auto 40px;
        }

        .search-input {
            width: 100%;
            padding: 15px;
            border: 2px solid #ddd;
            border-radius: var(--border-radius);
            font-size: 1.1em;
            transition: border-color 0.3s;
        }

        .search-input:focus {
            border-color: var(--primary-color);
            outline: none;
        }

        .faq-categories {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .category-button {
            background: white;
            border: none;
            padding: 15px;
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .category-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .category-button.active {
            background: var(--primary-color);
            color: white;
        }

        .faq-section {
            background: white;
            padding: 30px;
            border-radius: var(--border-radius);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .faq-section h2 {
            color: var(--primary-color);
            margin-bottom: 20px;
            font-size: 1.8em;
        }

        .faq-item {
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 20px;
        }

        .faq-question {
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .faq-question:hover {
            background: #e9ecef;
        }

        .faq-question h3 {
            font-size: 1.2em;
            color: var(--text-color);
            margin: 0;
        }

        .faq-answer {
            display: none;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 0 0 5px 5px;
            margin-top: 5px;
        }

        .faq-answer.show {
            display: block;
        }

        .code-block {
            background: #2d2d2d;
            color: #fff;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
            overflow-x: auto;
        }

        .highlight {
            background: #fff3cd;
            padding: 2px 5px;
            border-radius: 3px;
        }

        .related-questions {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .related-questions h4 {
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .related-questions ul {
            list-style: none;
        }

        .related-questions li {
            margin-bottom: 5px;
        }

        .related-questions a {
            color: var(--text-color);
            text-decoration: none;
        }

        .related-questions a:hover {
            color: var(--primary-color);
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            .faq-categories {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<header>
<?php include 'header.php'; ?>
</header>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-question-circle"></i> Preguntas Frecuentes</h1>
            <p>Encuentra respuestas a todas tus dudas sobre HLS Stream Recorder</p>
        </div>

        <div class="search-container">
            <input type="text" 
                   class="search-input" 
                   placeholder="Buscar en las preguntas frecuentes..." 
                   id="faqSearch">
        </div>

        <div class="faq-categories">
            <button class="category-button active" data-category="general">General</button>
            <button class="category-button" data-category="technical">Técnico</button>
            <button class="category-button" data-category="recording">Grabación</button>
            <button class="category-button" data-category="storage">Almacenamiento</button>
            <button class="category-button" data-category="playback">Reproducción</button>
            <button class="category-button" data-category="troubleshooting">Solución de Problemas</button>
        </div>

        <!-- Sección General -->
        <section class="faq-section" id="general">
            <h2><i class="fas fa-info-circle"></i> Preguntas Generales</h2>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h3>¿Qué es HLS Stream Recorder?</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>HLS Stream Recorder es una herramienta profesional diseñada para:</p>
                    <ul>
                        <li>Reproducir streams HLS (HTTP Live Streaming)</li>
                        <li>Grabar contenido en alta calidad</li>
                        <li>Gestionar grabaciones de forma eficiente</li>
                        <li>Proporcionar almacenamiento seguro</li>
                    </ul>
                    <p>Es ideal para profesionales que necesitan capturar y gestionar contenido de streaming.</p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <h3>¿Qué es un stream HLS?</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>HLS (HTTP Live Streaming) es un protocolo de streaming adaptativo desarrollado por Apple que:</p>
                    <ul>
                        <li>Divide el contenido en pequeños segmentos</li>
                        <li>Ofrece múltiples calidades del mismo contenido</li>
                        <li>Se adapta automáticamente a la conexión del usuario</li>
                        <li>Utiliza extensión .m3u8 para las listas de reproducción</li>
                    </ul>
                    <div class="code-block">
                        Ejemplo de URL HLS: https://ejemplo.com/stream/index.m3u8
                    </div>
                </div>
            </div>
        </section>

        <!-- Sección Técnica -->
        <section class="faq-section" id="technical">
            <h2><i class="fas fa-cogs"></i> Preguntas Técnicas</h2>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h3>¿Qué requisitos técnicos necesito?</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Requisitos mínimos del sistema:</p>
                    <ul>
                        <li>Servidor:
                            <ul>
                                <li>PHP 7.4 o superior</li>
                                <li>MySQL 5.7 o superior</li>
                                <li>10GB de espacio libre mínimo</li>
                                <li>Apache/Nginx con mod_rewrite</li>
                            </ul>
                        </li>
                        <li>Cliente:
                            <ul>
                                <li>Navegador moderno (Chrome 70+, Firefox 65+, Safari 12+)</li>
                                <li>JavaScript habilitado</li>
                                <li>Conexión estable a internet</li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <h3>¿Qué formatos y códecs se utilizan?</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Especificaciones técnicas de grabación:</p>
                    <ul>
                        <li>Formato contenedor: WebM</li>
                        <li>Códec de video: VP8
                            <ul>
                                <li>Resolución: Hasta 1080p</li>
                                <li>Framerate: Original del stream</li>
                                <li>Bitrate: Adaptativo</li>
                            </ul>
                        </li>
                        <li>Códec de audio: Opus
                            <ul>
                                <li>Canales: Estéreo</li>
                                <li>Sample rate: 48kHz</li>
                                <li>Bitrate: 128kbps</li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Sección de Grabación -->
        <section class="faq-section" id="recording">
            <h2><i class="fas fa-record-vinyl"></i> Preguntas sobre Grabación</h2>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h3>¿Cómo inicio una grabación?</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Para iniciar una grabación:</p>
                    <ol>
                        <li>Ingresa la URL del stream HLS</li>
                        <li>Espera a que el reproductor cargue</li>
                        <li>Haz clic en el botón "Iniciar Grabación"</li>
                        <li>La grabación comenzará automáticamente</li>
                    </ol>
                    <div class="highlight">
                        Nota: Asegúrate de tener suficiente espacio disponible antes de iniciar.
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <h3>¿Hay límite de tiempo para las grabaciones?</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Los límites de grabación son:</p>
                    <ul>
                        <li>Tiempo máximo por grabación: 12 horas</li>
                        <li>Tamaño máximo por archivo: 10GB</li>
                        <li>Grabaciones simultáneas: 1 por usuario</li>
                    </ul>
                    <p>El sistema dividirá automáticamente grabaciones largas en segmentos manejables.</p>
                </div>
            </div>
        </section>

        <!-- Sección de Almacenamiento -->
        <section class="faq-section" id="storage">
            <h2><i class="fas fa-hdd"></i> Preguntas sobre Almacenamiento</h2>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h3>¿Cuánto espacio de almacenamiento tengo?</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Detalles del almacenamiento:</p>
                    <ul>
                        <li>Espacio base: 10GB por usuario</li>
                        <li>Formato de archivos: WebM optimizado</li>
                        <li>Tiempo de retención: 30 días</li>
                        <li>Backup automático: Sí (diario)</li>
                    </ul>
                    <div class="highlight">
                        Consejo: El sistema te avisará cuando alcances el 90% de uso.
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <h3>¿Cómo gestiono mis grabaciones?</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Opciones de gestión disponibles:</p>
                    <ul>
                        <li>Visualizar:
                            <ul>
                                <li>Lista de grabaciones</li>
                                <li>Detalles técnicos</li>
                                <li>Fecha y duración</li>
                                <li>Tamaño del archivo</li>
                            </ul>
                        </li>
                        <li>Acciones:
                            <ul>
                                <li>Reproducir en navegador</li>
                                <li>Descargar archivo</li>
                                <li>Eliminar grabación</li>
                                <li>Renombrar archivo</li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Sección de Reproducción -->
        <section class="faq-section" id="playback">
            <h2><i class="fas fa-play-circle"></i> Preguntas sobre Reproducción</h2>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h3>¿Qué controles de reproducción están disponibles?</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Controles disponibles:</p>
                    <ul>
                        <li>Básicos:
                            <ul>
                                <li>Play/Pause</li>
                                <li>Control de volumen</li>
                                <li>Pantalla completa</li>
                                <li>Captura de pantalla</li>
                            </ul>
                        </li>
                        <li>Avanzados:
                            <ul>
                                <li>Ajuste de velocidad (0.25x - 2x)</li>
                                <li>Selección de calidad</li>
                                <li>Buffer personalizado</li>
                                <li>Picture-in-Picture</li>
                            </ul>
                        </li>
                        <li>Atajos de teclado:
                            <ul>
                                <li>Espacio/K: Play/Pause</li>
                                <li>F: Pantalla completa</li>
                                <li>M: Mutear</li>
                                <li>←/→: Avanzar/Retroceder</li>
                                <li>↑/↓: Volumen</li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <h3>¿Cómo funciona la adaptación de calidad?</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>El sistema de adaptación de calidad:</p>
                    <ul>
                        <li>Monitorea constantemente:
                            <ul>
                                <li>Velocidad de conexión</li>
                                <li>Estado del buffer</li>
                                <li>Rendimiento del dispositivo</li>
                            </ul>
                        </li>
                        <li>Ajusta automáticamente:
                            <ul>
                                <li>Resolución del video</li>
                                <li>Bitrate</li>
                                <li>Tamaño del buffer</li>
                            </ul>
                        </li>
                    </ul>
                    <div class="highlight">
                        La calidad se puede fijar manualmente si se prefiere.
                    </div>
                </div>
            </div>
        </section>

        <!-- Sección de Solución de Problemas -->
        <section class="faq-section" id="troubleshooting">
            <h2><i class="fas fa-wrench"></i> Solución de Problemas</h2>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h3>Error "No supported source found"</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Este error puede ocurrir por varias razones:</p>
                    <ol>
                        <li>URL incorrecta o inaccesible
                            <ul>
                                <li>Verificar que la URL termina en .m3u8</li>
                                <li>Comprobar acceso directo a la URL</li>
                                <li>Verificar protocolo (http/https)</li>
                            </ul>
                        </li>
                        <li>Problemas de CORS
                            <ul>
                                <li>Verificar configuración del servidor</li>
                                <li>Comprobar headers de respuesta</li>
                            </ul>
                        </li>
                        <li>Stream no válido
                            <ul>
                                <li>Verificar formato del stream</li>
                                <li>Comprobar manifest HLS</li>
                            </ul>
                        </li>
                    </ol>
                    <div class="code-block">
                        // Ejemplo de URL válida
                        https://ejemplo.com/stream/index.m3u8

                        // Headers necesarios
                        Access-Control-Allow-Origin: *
                        Content-Type: application/vnd.apple.mpegurl
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <h3>Problemas con la Grabación</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Soluciones comunes para problemas de grabación:</p>
                    <ul>
                        <li>No inicia la grabación:
                            <ul>
                                <li>Verificar permisos del navegador</li>
                                <li>Comprobar espacio disponible</li>
                                <li>Reiniciar el reproductor</li>
                            </ul>
                        </li>
                        <li>Grabación sin audio:
                            <ul>
                                <li>Verificar códec de audio del stream</li>
                                <li>Comprobar configuración de audio</li>
                                <li>Actualizar navegador</li>
                            </ul>
                        </li>
                        <li>Error al guardar:
                            <ul>
                                <li>Verificar conexión a internet</li>
                                <li>Comprobar espacio en servidor</li>
                                <li>Revisar permisos de escritura</li>
                            </ul>
                        </li>
                    </ul>
                    <div class="highlight">
                        Consejo: Mantén un registro de errores para diagnóstico.
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <h3>Problemas de Rendimiento</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Optimización del rendimiento:</p>
                    <ul>
                        <li>Buffer frecuente:
                            <ul>
                                <li>Reducir calidad del stream</li>
                                <li>Aumentar tamaño del buffer</li>
                                <li>Verificar conexión a internet</li>
                            </ul>
                        </li>
                        <li>Alto uso de CPU:
                            <ul>
                                <li>Cerrar pestañas innecesarias</li>
                                <li>Desactivar extensiones</li>
                                <li>Actualizar controladores de video</li>
                            </ul>
                        </li>
                        <li>Optimizaciones recomendadas:
                            <div class="code-block">
                                // Configuración óptima
                                maxBufferLength: 30
                                maxMaxBufferLength: 600
                                maxBufferSize: 60 * 1000 * 1000
                                enableWorker: true
                                lowLatencyMode: true
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <script>
            // Búsqueda en FAQ
            document.getElementById('faqSearch').addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                document.querySelectorAll('.faq-item').forEach(item => {
                    const question = item.querySelector('.faq-question h3').textContent.toLowerCase();
                    const answer = item.querySelector('.faq-answer').textContent.toLowerCase();
                    
                    if (question.includes(searchTerm) || answer.includes(searchTerm)) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });

            // Mostrar/Ocultar respuestas
            document.querySelectorAll('.faq-question').forEach(question => {
                question.addEventListener('click', function() {
                    const answer = this.nextElementSibling;
                    const icon = this.querySelector('i');
                    
                    answer.classList.toggle('show');
                    icon.classList.toggle('fa-chevron-up');
                    icon.classList.toggle('fa-chevron-down');
                });
            });

            // Filtrar por categoría
            document.querySelectorAll('.category-button').forEach(button => {
                button.addEventListener('click', function() {
                    const category = this.dataset.category;
                    
                    // Actualizar botones activos
                    document.querySelectorAll('.category-button').forEach(btn => {
                        btn.classList.remove('active');
                    });
                    this.classList.add('active');
                    
                    // Mostrar/ocultar secciones
                    document.querySelectorAll('.faq-section').forEach(section => {
                        if (section.id === category || category === 'all') {
                            section.style.display = 'block';
                        } else {
                            section.style.display = 'none';
                        }
                    });
                });
            });
        </script>
    </div>
<?php include 'footer.php'; ?>
</body>
</html>
