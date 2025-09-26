# Proyecto Ecommerce Simple

Este proyecto es una tienda en línea sencilla desarrollada en PHP. Permite a los usuarios navegar productos, agregarlos al carrito, realizar compras y gestionar pedidos. Incluye autenticación de usuarios y administración básica de productos.

## Estructura del Proyecto

```
├── carrito.php                # Página para gestionar el carrito de compras
├── checkout.php               # Página de pago y finalización de compra
├── create_product.php         # Página para crear nuevos productos (admin)
├── index.php                  # Página principal
├── login.php                  # Página de inicio de sesión
├── logout.php                 # Página de cierre de sesión
├── order_confirmation.php     # Confirmación de pedido
├── products.php               # Listado de productos
├── ver_carrito.php            # Visualización del carrito
├── config/
│   └── Database.php           # Configuración de la base de datos
├── models/
│   ├── Cart.php               # Modelo de carrito
│   ├── Order.php              # Modelo de pedido
│   ├── Product.php            # Modelo de producto
│   └── User.php               # Modelo de usuario
```

## Despliegue en InfinityFree

1. **Regístrate en InfinityFree**: Ve a [infinityfree.net](https://infinityfree.net/) y crea una cuenta gratuita.
2. **Crea una nueva cuenta de hosting** y toma nota de los datos FTP.
3. **Sube los archivos del proyecto**:
   - Usa un cliente FTP (como FileZilla) y conecta con los datos proporcionados.
   - Sube todos los archivos y carpetas del proyecto a la carpeta `htdocs` de tu hosting.
4. **Configura la base de datos**:
   - En el panel de InfinityFree, crea una base de datos MySQL.
   - Actualiza el archivo `config/Database.php` con los datos de la base de datos (host, usuario, contraseña, nombre de la base de datos).
5. **Importa la estructura de la base de datos**:
   - Si tienes un archivo `.sql`, impórtalo desde phpMyAdmin en InfinityFree.
6. **Accede a tu sitio**:
   - Ve a la URL pública que te proporciona InfinityFree para ver tu tienda en línea.

## Requisitos
- PHP 7.x o superior
- MySQL

## Notas
- InfinityFree no permite el envío de correos desde PHP por defecto. Si tu tienda requiere notificaciones por email, considera usar un servicio externo.
- Para mayor seguridad, protege las páginas de administración y valida los datos de usuario.

---

¡Listo! Tu ecommerce simple estará disponible en InfinityFree.