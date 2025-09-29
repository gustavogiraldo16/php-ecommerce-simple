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
<head>
    <title>MERCADO FREE - Retail | Lista de Productos</title>
    <link rel="stylesheet" href="static/assets/styles/products.css">
</head>
<body>
    <div class="products-container">
        <header class="header">
            <div class="header-logo">
                <img src="static/assets/images/logo.png" alt="Logo de MERCADO FREE" width="40">
                <h1>Catálogo de Productos</h1>

            </div>
            <div class="header-options">
                <span>
                    Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?>.
                </span>

                <?php if ($isAdmin): ?>
                    <p>
                        [ADMIN]
                    </p>
                    <span>|</span><a href="create_product.php">Crear Nuevo Producto</a>
                <?php endif; ?>

                |
                <a href="ver_carrito.php">Ver Carrito (<?php echo $totalItemsInCart; ?>)</a>
                <a href="mis_compras.php">Mis Compras</a>
                <a href="logout.php">Cerrar Sesión</a>
            </div>
        </header>

        <hr>

        <?php if (empty($products)): ?>
            <p>No hay productos activos en este momento.</p>
        <?php else: ?>
            <div class="products-grid">
                <?php foreach ($products as $product): ?>
                    <div class="product-card">

                        <?php
                            $assetsPath = 'static/assets';
                            $image = "{$assetsPath}/images/image-not-found.png";
                            if (!empty($product['image_url'])):

                                $imageUrl = "{$assetsPath}/uploads/{$product['image_url']}";
                                if (file_exists($imageUrl)) {
                                    $image = $imageUrl;
                                }

                            endif;
                        ?>

                        <img src="<?= $image ?>" alt="Imagen del producto" class="product-image">


                        <h3><?= htmlspecialchars($product['name']) ?></h3>
                        <p><?= htmlspecialchars($product['description']) ?></p>
                        <p><strong>Precio:</strong> $<?= number_format($product['price'], 2) ?></p>

                        <form method="POST" action="carrito.php">
                            <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit">Agregar al Carrito</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>
