<?php
session_start();

// Verifica si la variable de sesión 'user_id' existe, lo que indica que hay una sesión activa.
if (isset($_SESSION['user_id'])) {
    // Sesión iniciada: Redirige al catálogo de productos.
    header('Location: products.php');
    exit;
} else {
    // Sesión no iniciada: Redirige a la página de inicio de sesión.
    header('Location: login.php');
    exit;
}
