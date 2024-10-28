# Sistema de Reproductor y Grabador de Streams HLS

Sistema profesional para reproducción y grabación de streams HLS (HTTP Live Streaming) con almacenamiento en servidor y gestión completa de grabaciones.

## 🌟 Características Principales

### Reproducción
- 📺 Reproductor HLS optimizado
- 🎚️ Control de calidad adaptativo
- 🔄 Modo de baja latencia
- 📊 Monitor de calidad y buffer
- ⚡ Recuperación automática de errores

### Grabación
- 🎥 Grabación en tiempo real
- 💾 Formato WebM optimizado (VP8 + Opus)
- 📁 Almacenamiento en servidor
- 📈 Gestión de espacio
- 🔄 Streaming de reproducciones

### Controles
- ⏯️ Play/Pause
- 🔊 Control de volumen
- 🎚️ Velocidad de reproducción (0.25x - 2x)
- 📺 Pantalla completa
- 📸 Captura de pantalla
- ⏺️ Control de grabación

### Sistema de Archivos
- 📁 Gestión automática de archivos
- 🗃️ Organización por fecha
- 🔍 Previsualización de grabaciones
- 📥 Sistema de descargas
- 🗑️ Eliminación segura

## 💻 Requisitos del Sistema

### Servidor
- PHP 7.4 o superior
- MySQL 5.7 o superior
- Apache/Nginx
- Espacio en disco recomendado: 10GB+

### PHP Extensions
- PDO
- PDO_MySQL
- FileInfo
- JSON
- OpenSSL

### Navegadores Soportados
- Chrome 70+
- Firefox 65+
- Safari 12+
- Edge 79+

## 🚀 Instalación

1. Clonar el repositorio:
```bash
git clone https://github.com/yourusername/hls-recorder.git
cd hls-recorder
```

2. Configurar base de datos:
```bash
mysql -u root -p < database.sql
```

3. Configurar config.php:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'video_system');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
define('UPLOAD_DIR', '/path/to/recordings/');
define('MAX_FILE_SIZE', 10 * 1024 * 1024 * 1024); // 10GB
```

4. Configurar permisos:
```bash
chmod 755 recordings/
chown www-data:www-data recordings/
```

5. Configurar PHP (php.ini):
```ini
upload_max_filesize = 10G
post_max_size = 10G
memory_limit = 10G
max_execution_time = 3600
max_input_time = 3600
```

## 📖 Uso

### Reproducción
1. Acceder a index.php
2. Ingresar URL del stream HLS
3. Usar controles de reproducción

### Grabación
1. Clic en "Iniciar Grabación"
2. La grabación se almacena automáticamente
3. Clic en "Detener Grabación" para finalizar

### Atajos de Teclado
- `Espacio/K`: Play/Pause
- `F`: Pantalla completa
- `M`: Mutear/Desmutear
- `←/→`: Retroceder/Avanzar 5 segundos
- `↑/↓`: Volumen
- `ESC`: Cerrar modal de reproducción

## 🛠️ Configuración Avanzada

### Límites de Almacenamiento
```php
// config.php
define('MAX_FILE_SIZE', 10 * 1024 * 1024 * 1024); // 10GB
define('STORAGE_WARN_THRESHOLD', 0.9);  // Advertencia al 90%
define('STORAGE_CRITICAL_THRESHOLD', 0.95); // Crítico al 95%
```

### Optimización de Streaming
```php
// PHP Streaming Configuration
set_time_limit(0);
ini_set('max_execution_time', 0);
ini_set('memory_limit', '1G');
```

### Seguridad
```apache
# .htaccess para proteger grabaciones
<Directory /recordings>
    Options -Indexes
    Order deny,allow
    Deny from all
    <FilesMatch "\.(webm)$">
        Order allow,deny
        Allow from all
    </FilesMatch>
</Directory>
```

## 🔒 Seguridad

- ✅ Validación de entrada
- 🔐 Control de acceso
- 🛡️ Protección contra XSS
- 📝 Registro de actividad
- 🔍 Validación de MIME types

## 📝 Mantenimiento

### Limpieza Automática
```bash
# Ejemplo de cron para limpieza
0 0 * * * /usr/bin/php /path/to/cleanup.php
```

### Monitoreo
```php
// Ejemplo de log
error_log("Error en grabación: " . $e->getMessage());
```

## 🐛 Solución de Problemas

### Problemas Comunes
1. Error "No supported source":
   - Verificar formato del video (WebM)
   - Comprobar MIME types
   - Verificar permisos de archivos

2. Error de almacenamiento:
   - Verificar permisos de directorio
   - Comprobar límites de PHP
   - Verificar espacio disponible

### Logs
```bash
tail -f /var/log/apache2/error.log
tail -f /path/to/custom/error.log
```

## 📄 Licencia

Este proyecto está bajo la Licencia MIT - ver archivo [LICENSE.md](LICENSE.md)

## 👥 Soporte

Para reportar problemas o solicitar funciones:
1. Abrir un issue
2. Describir el problema/función
3. Proporcionar logs si es necesario

## 🙏 Agradecimientos

- HLS.js por la biblioteca de reproducción
- WebM por el formato de video
- Comunidad de código abierto

---
Realizado por ❤️ by [Sabalero23]# hls-stream-recorder
