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
                'subtotal' => $subtotal,
                'image_url' => $product['image_url']
            ];
            $totalGeneral += $subtotal;
        }  else {
            // Manejo: el producto ya no existe en la DB (se podría eliminar de la sesión)
            // No implementado aquí para mantener la simplicidad.
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head><title>Ver Carrito</title>
<link rel="stylesheet" href="static/assets/styles/cart.css">
</head>
<body>
   <div class="container">
    <h1 class="cart-title">Tu carrito de compras</h1>
    <p class="back-link"><a href="products.php">← Volver al Catálogo</a></p>

    <?php if (empty($productsInCart)): ?>
        <p class="empty-cart">Tu carrito está vacío.</p>
    <?php else: ?>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Producto</th>
                    <th>Precio unitario</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productsInCart as $item): ?>
                <tr>
                    <td>
                        <?php
                            $assetsPath = 'static/assets';
                            $image = "{$assetsPath}/images/image-not-found.png";
                            if (!empty($item['image_url'])):

                                $imageUrl = "{$assetsPath}/uploads/{$item['image_url']}";
                                if (file_exists($imageUrl)) {
                                    $image = $imageUrl;
                                }

                            endif;
                        ?>
                        <img src="<?= $image ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="car-table-td-img">
                    </td>

                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td>$<?php echo number_format($item['price'], 2); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>$<?php echo number_format($item['subtotal'], 2); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align: right;">TOTAL:</td>
                    <td>$<?php echo number_format($totalGeneral, 2); ?></td>
                </tr>
            </tfoot>
        </table>

        <div class="btn-container">
            <a href="checkout.php" class="btn">Proceder a la compra</a>
        </div>
    <?php endif; ?>
</div>
</body>
</html>