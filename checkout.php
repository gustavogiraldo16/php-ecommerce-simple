<?php
session_start();
require_once 'models/Cart.php';
require_once 'models/Product.php';
require_once 'models/Order.php';

// Si no está logueado, redirige al login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$cartService = new Cart();
$productModel = new Product();
$orderModel = new Order();

$cartItems = $cartService->getItems();

if (empty($cartItems)) {
    // Si el carrito está vacío, redirigir al catálogo o carrito
    header('Location: ver_carrito.php');
    exit;
}

$totalGeneral = 0.00;
$orderItemsForDB = []; // Estructura para guardar en la base de datos

// --- Lógica Común (Calcular Total y preparar ítems) ---
foreach ($cartItems as $id => $quantity) {
    $product = $productModel->find($id); // Obtenemos el precio actual de la DB
    if ($product) {
        $subtotal = $product['price'] * $quantity;
        $totalGeneral += $subtotal;

        // Prepara los datos para el Order Model
        $orderItemsForDB[] = [
            'product_id' => $id,
            'quantity' => $quantity,
            'price' => (float)$product['price'] // Precio unitario fijo al momento de la compra
        ];
    }
}
// --------------------------------------------------------

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // --- PROCESAMIENTO DE LA ORDEN (POST) ---

    $userId = $_SESSION['user_id'] ?? null;
    $name = trim($_POST['customer_name'] ?? '');
    $email = trim($_POST['customer_email'] ?? '');
    $address = trim($_POST['customer_address'] ?? '');

    // Validaciones mínimas
    if (empty($name) || empty($email) || empty($address)) {
        $error = "Por favor, complete todos los campos de envío.";
    } else {
        // Crear la orden en la base de datos
        $orderId = $orderModel->createOrder($userId, $name, $email, $address, $totalGeneral, $orderItemsForDB);

        if ($orderId) {
            $cartService->clear(); // Vaciar el carrito después de la compra exitosa
            // Redirigir a una página de confirmación (simulada aquí)
            header('Location: order_confirmation.php?id=' . $orderId);
            exit;
        } else {
            $error = "Hubo un error al procesar el pedido. Intente de nuevo.";
        }
    }
}

// --- VISTA DEL FORMULARIO (GET) ---
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>MERCADO FREE - Retail | Finalizar compra</title>
    <link rel="stylesheet" href="static/assets/styles/checkout.css">
</head>
<body>
    <div class="container">
        <h1 class="page-title">Finalizar compra</h1>
        <h2 class="total">Total a Pagar: $<?php echo number_format($totalGeneral, 2); ?></h2>

        <?php if (isset($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form method="POST" action="checkout.php">
            <div class="form-section">
                <h3>Información de envío</h3>

                <div class="form-group">
                    <label for="customer_name">Nombre completo</label>
                    <input type="text" id="customer_name" name="customer_name" 
                        value="<?php echo htmlspecialchars($_SESSION['username'] ?? ''); ?>" required>
                </div>

                <div class="form-group">
                    <label for="customer_email">Email</label>
                    <input type="email" id="customer_email" name="customer_email" required>
                </div>

                <div class="form-group">
                    <label for="customer_address">Dirección de envío</label>
                    <textarea id="customer_address" name="customer_address" required></textarea>
                </div>
            </div>

            <button type="submit" class="btn">Pagar y confirmar pedido</button>
            <p class="cancel-link"><a href="ver_carrito.php">Cancelar y volver al carrito</a></p>
        </form>
    </div>
</body>
</html>