<?php
session_start();
// Se requieren ambos, el servicio del carrito (sesión) y el modelo de producto (DB)
require_once 'models/Cart.php';
require_once 'models/Product.php';

// Si no está logueado, redirige al login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$cartService = new Cart();
$productModel = new Product();

$cartItems = $cartService->getItems();
$productsInCart = [];
$totalGeneral = 0.00;

// Iterar sobre los IDs del carrito para obtener la información completa del producto
if (!empty($cartItems)) {
    foreach ($cartItems as $productId => $quantity) {
        // Obtener detalles del producto (nombre y precio) de la DB
        $product = $productModel->find($productId);
        
        // Solo si el producto existe y está activo
        if ($product) {
            $subtotal = $product['price'] * $quantity;
            $productsInCart[] = [
                'name' => $product['name'],
                'price' => (float)$product['price'],
                'quantity' => $quantity,
                'subtotal' => $subtotal
            ];
            $totalGeneral += $subtotal;
        } else {
            // Manejo: el producto ya no existe en la DB (se podría eliminar de la sesión)
            // No implementado aquí para mantener la simplicidad.
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head><title>Ver Carrito</title></head>
<body>
    <h1>Tu Carrito de Compras</h1>
    <p><a href="products.php">Volver al Catálogo</a></p>

    <?php if (empty($productsInCart)): ?>
        <p>Tu carrito está vacío.</p>
    <?php else: ?>
        <table border="1" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio Unitario</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productsInCart as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td style="text-align: right;">$<?php echo number_format($item['price'], 2); ?></td>
                    <td style="text-align: center;"><?php echo $item['quantity']; ?></td>
                    <td style="text-align: right;">$<?php echo number_format($item['subtotal'], 2); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align: right; font-weight: bold;">TOTAL:</td>
                    <td style="text-align: right; font-weight: bold;">$<?php echo number_format($totalGeneral, 2); ?></td>
                </tr>
            </tfoot>
        </table>

        <br>
        <a href="checkout.php"><button>Proceder a la Compra</button></a>
    <?php endif; ?>
</body>
</html>