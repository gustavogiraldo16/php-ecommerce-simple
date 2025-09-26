<?php
// No requiere conexión a DB, solo maneja $_SESSION

class Cart {

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        // Inicializa el carrito si no existe
        if (!isset($_SESSION['cart'])) {
            // El carrito guarda [product_id => quantity]
            $_SESSION['cart'] = [];
        }
    }

    /**
     * Añade un producto al carrito o incrementa su cantidad.
     */
    public function add(int $productId, int $quantity = 1): void {
        if ($quantity > 0) {
            if (isset($_SESSION['cart'][$productId])) {
                $_SESSION['cart'][$productId] += $quantity;
            } else {
                $_SESSION['cart'][$productId] = $quantity;
            }
        }
    }

    /**
     * Devuelve el contenido del carrito.
     */
    public function getItems(): array {
        return $_SESSION['cart'];
    }

    /**
     * Devuelve el número total de artículos (cantidad sumada).
     */
    public function getTotalItems(): int {
        return array_sum($_SESSION['cart']);
    }

    /**
     * Vacía el carrito.
     */
    public function clear(): void {
        $_SESSION['cart'] = [];
    }

    // Aquí irían métodos para eliminar, actualizar cantidad, etc.
}