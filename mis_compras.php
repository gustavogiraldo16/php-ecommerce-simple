<?php
session_start();
require_once 'models/Order.php';

// Control de acceso: Solo usuarios logueados pueden ver sus compras
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];
$orderModel = new Order();
$orders = $orderModel->getOrdersByUserId($userId);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Mis Compras</title>
    <link rel="stylesheet" href="static/assets/styles/my_orders.css">
</head>
<body>
    <div class="container">
        <h1 class="orders-title">Mis Compras (Historial)</h1>
        <p class="back-link"><a href="products.php">← Volver al Catálogo</a></p>

        <?php if (empty($orders)): ?>
            <p class="empty-cart">Aún no has realizado ninguna compra con esta cuenta.</p>
        <?php else: ?>
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>ID Pedido</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Cliente</th>
                        </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                    <tr>
                        <td>#<?php echo htmlspecialchars($order['id']); ?></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></td>
                        <td>$<?php echo number_format($order['total'], 2); ?></td>
                        <td><?php echo htmlspecialchars($order['status']); ?></td>
                        <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

</body>
</html>