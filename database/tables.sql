-- #########################################
-- Script SQL de Creación de Tablas (MySQL)
-- #########################################

-- =========================================
-- Tabla: users
-- Almacena la información de los usuarios registrados.
-- =========================================
CREATE TABLE `users` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `role` ENUM('ADMIN','USER') NOT NULL DEFAULT 'USER',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- =========================================
-- Tabla: products
-- Almacena la información de los productos disponibles.
-- =========================================
CREATE TABLE `products` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `description` TEXT,
    `price` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    `active` TINYINT(1) NOT NULL DEFAULT 1, -- 1 para activo, 0 para inactivo
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- =========================================
-- Tabla: orders
-- Almacena los pedidos realizados.
-- =========================================
CREATE TABLE `orders` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT UNSIGNED NULL, -- NULL si es compra sin registro (usuario invitado)
    `customer_name` VARCHAR(100) NOT NULL,
    `customer_email` VARCHAR(100) NOT NULL,
    `customer_address` TEXT NOT NULL,
    `total` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    `status` ENUM('PENDING','PAID','CANCELLED') NOT NULL DEFAULT 'PENDING',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    -- Clave foránea a la tabla users
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- =========================================
-- Tabla: order_items (Corregida y Completa)
-- Almacena los detalles de los productos en cada pedido.
-- =========================================
CREATE TABLE `order_items` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `order_id` INT UNSIGNED NOT NULL,
    `product_id` INT UNSIGNED NOT NULL,
    `quantity` INT UNSIGNED NOT NULL DEFAULT 1,
    `price` DECIMAL(10,2) NOT NULL, -- Precio del producto al momento de la compra
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    -- Claves foráneas
    FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE RESTRICT,

    -- Restricción para asegurar que un producto solo aparezca una vez por orden
    UNIQUE KEY `order_product_unique` (`order_id`, `product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO users (username, email, password, role) VALUES
('admin', 'admin@shop.com', '$2y$10$VwDsCK/mvwISgk.4jXWiXOJbLMzFX6vstA3pIyGO1PeU8XaGDNT1K', 'ADMIN'),
('user', 'user@shop.com', '$2y$10$VwDsCK/mvwISgk.4jXWiXOJbLMzFX6vstA3pIyGO1PeU8XaGDNT1K', 'USER');