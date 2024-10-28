<?php
// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_NAME', 'stream');
define('DB_USER', 'stream');     // Cambia esto por tu usuario
define('DB_PASS', 'ZhMhs7KifMayaX3x');         // Cambia esto por tu contraseña

// Configuración de directorios
define('UPLOAD_DIR', dirname(__FILE__) . '/recordings/');
define('MAX_FILE_SIZE', 1024 * 1024 * 2048); // 2GB

// Crear directorio si no existe
if (!file_exists(UPLOAD_DIR)) {
    mkdir(UPLOAD_DIR, 0777, true);
}

// Clase de conexión a la base de datos
class Database {
    private static $instance = null;
    private $conn;

    private function __construct() {
        try {
            $this->conn = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
                DB_USER,
                DB_PASS,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }
}