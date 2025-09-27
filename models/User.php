<?php
require_once __DIR__ . '/../config/Database.php';

class User {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    // Busca un usuario por nombre de usuario para el login
    public function findByUsername(string $username) {
        $stmt = $this->db->prepare("SELECT id, username, password, role FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Crea un nuevo usuario estándar (rol USER).
     * @param string $username
     * @param string $email
     * @param string $password Sin hashear
     * @return bool True si se creó, false si falló o el usuario/email ya existe.
     */
    public function createStandardUser(string $username, string $email, string $password): bool {
        // Validación básica: asegura que la entrada no esté vacía
        if (empty($username) || empty($email) || empty($password)) {
            return false;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $role = 'USER'; // Siempre asignamos rol USER por defecto en el registro público

        $sql = "INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)";
        $stmt = $this->db->prepare($sql);

        try {
            return $stmt->execute([
                ':username' => $username,
                ':email' => $email,
                ':password' => $hashedPassword,
                ':role' => $role
            ]);
        } catch (\PDOException $e) {
            // Error code 23000 es de integridad de datos (ej. UNIQUE constraint violation)
            if ($e->getCode() === '23000') {
                return false; // Usuario o email duplicado
            }
            // Puedes loguear otros errores aquí si es necesario
            return false;
        }
    }

}