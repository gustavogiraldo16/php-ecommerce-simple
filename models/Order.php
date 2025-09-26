<?php
require_once __DIR__ . '/../config/Database.php';

class Order {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    /**
     * Crea una orden y sus ítems dentro de una transacción.
     * @param int|null $userId ID del usuario logueado o null.
     * @param string $name Nombre del cliente.
     * @param string $email Email del cliente.
     * @param string $address Dirección de envío.
     * @param float $total Total del pedido.
     * @param array $items Array de [product_id, quantity, price]
     * @return int|false ID de la orden creada o false en caso de error.
     */
    public function createOrder(?int $userId, string $name, string $email, string $address, float $total, array $items) {
        try {
            // 1. Iniciar la transacción
            $this->db->beginTransaction();

            // Insertar en la tabla 'orders'
            $sqlOrder = "INSERT INTO orders (user_id, customer_name, customer_email, customer_address, total) 
                         VALUES (:user_id, :name, :email, :address, :total)";
            $stmtOrder = $this->db->prepare($sqlOrder);
            $stmtOrder->execute([
                ':user_id' => $userId,
                ':name' => $name,
                ':email' => $email,
                ':address' => $address,
                ':total' => $total,
            ]);
            $orderId = $this->db->lastInsertId();

            // Insertar en la tabla 'order_items'
            $sqlItem = "INSERT INTO order_items (order_id, product_id, quantity, price)
                        VALUES (:order_id, :product_id, :quantity, :price)";
            $stmtItem = $this->db->prepare($sqlItem);

            foreach ($items as $item) {
                $stmtItem->execute([
                    ':order_id' => $orderId,
                    ':product_id' => $item['product_id'],
                    ':quantity' => $item['quantity'],
                    ':price' => $item['price'], // Precio unitario de venta
                ]);
            }

            // 2. Confirmar la transacción
            $this->db->commit();

            return $orderId;

        } catch (Exception $e) {
            // 3. Deshacer la transacción en caso de error
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            error_log("Error al crear orden: " . $e->getMessage());
            return false;
        }
    }
}