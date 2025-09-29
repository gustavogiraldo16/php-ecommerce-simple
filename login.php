<?php
session_start();
require_once 'models/User.php';

// Si ya está logueado, redirige a la lista de productos
if (isset($_SESSION['user_id'])) {
    header('Location: products.php');
    exit;
}

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $userModel = new User();
    $user = $userModel->findByUsername($username);

    // Usa password_verify() para verificar la contraseña hasheada
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['username'] = $user['username'];

        header('Location: products.php');
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>MERCADO FREE - Retail | Iniciar sesión </title>
    <link rel="stylesheet" href="static/assets/styles/login.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="static/assets/images/favicon.ico">
</head>
<body>
    <div class="login-container">
        <section class="branding">
            <img src="static/assets/images/logo.png" alt="MERCADO FREE Logo" width="150">
            <h1>MERCADO FREE</h1>
            <p>Tu tienda de retail en línea de confianza</p>
        </section>
        <section class="login-form">
            <div>
                <h1>Iniciar sesión</h1>
                <?php if ($error): ?>
                    <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
                <?php endif; ?>
                <form method="POST" action="login.php">
                    <div class="form-group">
                        <label for="username">Usuario</label>
                        <input type="text" id="username" name="username" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" id="password" name="password" required>
                    </div>

                    <button type="submit">Entrar</button>
                </form>
                <p class="register-link">¿No tienes cuenta? <a href="register.php">Regístrate aquí</a>.</p>
            </div>
        </section>
    </div>
    </form>
</body>
</html>