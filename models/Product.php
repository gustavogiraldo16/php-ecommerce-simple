<?php
require_once __DIR__ . '/../config/Database.php';

class Product {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    /** Obtiene todos los productos activos.
     * @return array
     */
    public function getAllActive(): array {
        $stmt = $this->db->prepare("SELECT id, name, description, price, image_url FROM products WHERE active = 1 ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Crea un nuevo producto.
     * @param string $name
     * @param string $desc
     * @param float $price
     * @param string|null $imageUrl
     * @return bool
     */
    public function create(string $name, string $desc, float $price, ?string $imageUrl): bool {
        $sql = "INSERT INTO products (name, description, price, image_url, active)
                VALUES (:name, :desc, :price, :image_url, 1)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':name' => $name,
            ':desc' => $desc,
            ':price' => $price,
            ':image_url' => $imageUrl
        ]);
    }

    /** Busca un producto por su ID.
     * @param int $id
     * @return array|false
     */
    public function find(int $id) {
        $stmt = $this->db->prepare("SELECT id, name, price, image_url, active FROM products WHERE id = :id AND active = 1");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}