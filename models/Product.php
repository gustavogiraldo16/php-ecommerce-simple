<?php
require_once __DIR__ . '/../config/Database.php';

class Product {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    // Obtiene todos los productos activos.
    public function getAllActive(): array {
        $stmt = $this->db->prepare("SELECT id, name, description, price FROM products WHERE active = 1 ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crea un nuevo producto (ADMIN)
    public function create(string $name, string $desc, float $price): bool {
        $sql = "INSERT INTO products (name, description, price, active) VALUES (:name, :desc, :price, 1)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':name' => $name,
            ':desc' => $desc,
            ':price' => $price
        ]);
    }

    /**
     * Obtiene un producto por ID.
     * @param int $id
     * @return array|false
     */
    public function find(int $id) {
        $stmt = $this->db->prepare("SELECT id, name, price, active FROM products WHERE id = :id AND active = 1");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}