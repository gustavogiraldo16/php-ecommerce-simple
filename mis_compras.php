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
<head><title>Mis Compras</title></head>
<body>
    <h1>Mis Compras (Historial)</h1>
    <p><a href="products.php">Volver al Catálogo</a> | <a href="logout.php">Cerrar Sesión</a></p>

    <?php if (empty($orders)): ?>
        <p>Aún no has realizado ninguna compra con esta cuenta.</p>
    <?php else: ?>
        <table border="1" style="width: 80%; border-collapse: collapse; margin-top: 20px;">
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
</body>
</html>