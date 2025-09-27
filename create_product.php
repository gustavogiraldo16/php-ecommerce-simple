<?php
session_start();
require_once 'models/Product.php';

// 1. CONTROL DE ACCESO (PROTECCIÓN)
if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] ?? 'USER') !== 'ADMIN') {
    header('Location: products.php'); // Redirige si no es ADMIN
    exit;
}

$message = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = (float)($_POST['price'] ?? 0.00);

    if (empty($name) || $price <= 0) {
        $error = "El nombre y el precio deben ser válidos.";
    } else {
        $productModel = new Product();
        if ($productModel->create($name, $description, $price)) {
            $message = "Producto '{$name}' creado exitosamente.";
        } else {
            $error = "Error al guardar el producto en la base de datos.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>MERCADO FREE - Retail | Crear Producto</title>
    <link rel="stylesheet" href="static/assets/styles/create_product.css">
</head>
<body>
    <div class="container">
        <h1 class="page-title">Crear nuevo producto [ADMIN]</h1>
        <p class="back-link"><a href="products.php">← Volver al Catálogo</a></p>

        <?php if ($message): ?>
            <p class="message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <?php if ($error): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form method="POST" action="create_product.php">
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="description">Descripción</label>
                <textarea id="description" name="description"></textarea>
            </div>

            <div class="form-group">
                <label for="price">Precio</label>
                <input type="number" id="price" name="price" step="0.01" min="0.01" required>
            </div>

            <div class="btn-container">
                <button type="submit" class="btn">Guardar Producto</button>
            </div>
        </form>
    </div>
</body>
</html>