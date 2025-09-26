<?php
session_start();
$orderId = (int)($_GET['id'] ?? 0);
?>
<!DOCTYPE html>
<html lang="es">
<head><title>Confirmación</title></head>
<body>
    <h1>¡Pedido Confirmado! 🎉</h1>
    <?php if ($orderId > 0): ?>
        <p>Tu pedido número **<?php echo $orderId; ?>** ha sido procesado exitosamente.</p>
        <p>Recibirás un email de confirmación en breve.</p>
    <?php else: ?>
        <p>No se pudo encontrar el ID de tu pedido. ¡Gracias por tu compra!</p>
    <?php endif; ?>
    <p><a href="products.php">Volver al catálogo</a></p>
</body>
</html>