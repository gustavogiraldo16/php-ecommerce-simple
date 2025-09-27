<?php
session_start();
require_once 'models/User.php';

// Si ya está logueado, redirige a la lista de productos
if (isset($_SESSION['user_id'])) {
    header('Location: products.php');
    exit;
}

$message = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $passwordConfirm = $_POST['password_confirm'] ?? '';

    // 1. Validaciones básicas
    if (empty($username) || empty($email) || empty($password) || empty($passwordConfirm)) {
        $error = "Todos los campos son obligatorios.";
    } elseif ($password !== $passwordConfirm) {
        $error = "Las contraseñas no coinciden.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "El formato del email no es válido.";
    } elseif (strlen($password) < 6) {
        $error = "La contraseña debe tener al menos 6 caracteres.";
    } else {
        // 2. Intentar crear el usuario
        $userModel = new User();
        if ($userModel->createStandardUser($username, $email, $password)) {
            $message = "¡Registro exitoso! Ya puedes iniciar sesión.";
            // Opcional: Iniciar sesión automáticamente o redirigir al login
            // header('Location: login.php?registered=1'); exit;
        } else {
            $error = "El nombre de usuario o el email ya están registrados.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head><title>Registro</title></head>
<body>
    <h1>Crear Nueva Cuenta</h1>
    <p>¿Ya tienes una cuenta? <a href="login.php">Inicia Sesión aquí</a></p>

    <?php if ($message): ?>
        <p style="color: green; font-weight: bold;"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    <?php if ($error): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST" action="register.php">
        <label for="username">Usuario:</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username ?? ''); ?>" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required><br><br>

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="password_confirm">Confirmar Contraseña:</label>
        <input type="password" id="password_confirm" name="password_confirm" required><br><br>

        <button type="submit">Registrarse</button>
    </form>
</body>
</html>