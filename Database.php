<?php
// Define los detalles de conexión
class Database {
    private static $instance = null;
    private $conn;

    private $host = 'sql107.infinityfree.com';
    private $db   = 'if0_40018814_ecommerce_db'; // ¡Asegúrate de que este nombre sea correcto!
    private $user = 'if0_40018814';
    private $pass = 'GZBU9o1tTp'; // ¡Cambia tu contraseña!
    private $port = '3306';
    private $charset = 'utf8mb4';

    private function __construct() {
        $dsn = "mysql:host={$this->host};dbname={$this->db};charset={$this->charset}";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $this->conn = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            die("Error de conexión a la base de datos: " . $e->getMessage());
        }
    }

    public static function getConnection(): PDO {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance->conn;
    }
}
