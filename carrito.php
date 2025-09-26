<?php
session_start();
require_once 'models/Cart.php';

$cart = new Cart();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = (int)$_POST['product_id'];
    // Asumimos que la cantidad siempre es 1 desde el formulario de products.php
    $quantity = (int)($_POST['quantity'] ?? 1);

    if ($productId > 0) {
        $cart->add($productId, $quantity);
    }
}

// Redirigir de vuelta a la lista de productos o a la página de carrito (la crearemos después)
header('Location: products.php');
exit;