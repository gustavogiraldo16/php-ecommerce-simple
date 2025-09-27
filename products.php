<?php
session_start();
require_once 'models/Product.php';
require_once 'models/Cart.php'; // Necesario para el carrito

// Si no está logueado, redirige al login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$productModel = new Product();
$products = $productModel->getAllActive();

$isAdmin = ($_SESSION['user_role'] ?? 'USER') === 'ADMIN';

// Inicializa el servicio del carrito para obtener el conteo
$cartService = new Cart();
$totalItemsInCart = $cartService->getTotalItems();
?>
<!DOCTYPE html>
<html lang="es">
<head><title>Lista de Productos</title></head>
<body>

    <h1>Catálogo de Productos</h1>
    <p>
        Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?>.
        | <a href="ver_carrito.php">Ver Carrito (<?php echo $totalItemsInCart; ?>)</a>
        | <a href="mis_compras.php">Mis Compras</a>
        | <a href="logout.php">Cerrar Sesión</a>
    </p>

    <?php if ($isAdmin): ?>
        <p style="font-weight: bold; color: blue;">
            [ADMIN] <a href="create_product.php">Crear Nuevo Producto</a>
        </p>
    <?php endif; ?>

    <hr>

    <?php if (empty($products)): ?>
        <p>No hay productos activos en este momento.</p>
    <?php else: ?>
        <?php foreach ($products as $product): ?>
            <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
                <?php if (!empty($product['image_url'])): ?>
                    <img src="uploads/<?php echo htmlspecialchars($product['image_url']); ?>"
                        alt="<?php echo htmlspecialchars($product['name']); ?>"
                        style="width: 100px; height: 100px; object-fit: cover; margin-right: 15px;">
                <?php endif; ?>
                <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                <p><?php echo htmlspecialchars($product['description']); ?></p>
                <p><strong>Precio:</strong> $<?php echo number_format($product['price'], 2); ?></p>

                <form method="POST" action="carrito.php">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit">Agregar al Carrito</button>
                </form>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>