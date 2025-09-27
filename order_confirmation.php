<?php
session_start();
$orderId = (int)($_GET['id'] ?? 0);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>MERCADO FREE - Retail | Confirmación</title>
    <link rel="stylesheet" href="static/assets/styles/order_confirmation.css">
</head>
<body>
    <div class="card">
        <h1>¡Pedido Confirmado! 🎉</h1>
        <?php if ($orderId > 0): ?>
            <p>Tu pedido número <strong><?php echo $orderId; ?></strong> ha sido procesado exitosamente.</p>
            <p>Recibirás un email de confirmación en breve.</p>
        <?php else: ?>
            <p>No se pudo encontrar el ID de tu pedido. ¡Gracias por tu compra!</p>
        <?php endif; ?>
        <a href="products.php">Volver al Catálogo</a>
    </div>
</body>
</html>