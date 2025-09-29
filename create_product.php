<?php
session_start();
require_once 'models/Product.php';

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
    $imageUrl = null; // Inicializamos a null

    // 1. Validaciones básicas (existencia y precio)
    if (empty($name) || $price <= 0) {
        $error = "El nombre y el precio deben ser válidos.";
    } else {
        // 2. Lógica de Subida de Imagen
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['image']['tmp_name'];
            $fileName = basename($_FILES['image']['name']);
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');

            if (in_array($fileExtension, $allowedfileExtensions)) {
                // Generar un nombre único para evitar colisiones
                $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
                $uploadFileDir = './static/assets/uploads/';
                $destPath = $uploadFileDir . $newFileName;

                if (move_uploaded_file($fileTmpPath, $destPath)) {
                    $imageUrl = $newFileName; // Guardamos solo el nombre del archivo
                } else {
                    $error = "Error al mover el archivo subido.";
                }
            } else {
                $error = "Tipo de imagen no permitido. Usa JPG, PNG o GIF.";
            }
        }

        // Si no hay error, intentar crear el producto
        if (!$error) {
            $productModel = new Product();
            // Llama al método create con el nuevo parámetro $imageUrl
            if ($productModel->create($name, $description, $price, $imageUrl)) {
                $message = "Producto '{$name}' creado exitosamente.";
                // Limpiar variables de formulario para un nuevo producto
            } else {
                $error = "Error al guardar el producto en la base de datos.";
            }
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

    <form method="POST" action="create_product.php" enctype="multipart/form-data">

        <div class="form-group">
            <label for="name">Nombre:</label>
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

        <div class="form-group">
            <label for="image">Imagen del Producto:</label>
            <input type="file" id="image" name="image" accept="image/*">
        </div>

        <button type="submit" class="btn">Guardar Producto</button>
    </form>
</body>
</html>