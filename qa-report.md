# 🧪 QA Report – E-commerce PHP Simple

## 📋 Pruebas realizadas

### 1. Autenticación y Seguridad (login.php)
#### 1.1 Login y Sesión
- **Caso**: Acceso a index.php sin sesión
- **Resultado esperado**: Redirección automática a login.php
- **Resultado obtenido**: [Anotar aquí]
- **Evidencia**: ![Redirección login](qa-images/index-redirect.png)

- **Caso**: Login con password_verify()
- **Resultado esperado**: Verificación correcta de contraseña hasheada
- **Resultado obtenido**: [Anotar aquí]
- **Evidencia**: ![Verificación password](qa-images/login_fail.png)

- **Caso**: Logout y destrucción de sesión
- **Resultado esperado**: Sesión destruida y redirección a login
- **Resultado obtenido**: [Anotar aquí]
- **Evidencia**: ![Logout sesión](qa-images/logout-session.png)

#### 1.2 Seguridad y Control de Acceso
- **Caso**: Intento de inyección SQL en login (`' OR '1'='1`)
- **Resultado esperado**: Login fallido, sin vulnerabilidad SQL
- **Resultado obtenido**: [Anotar aquí]
- **Evidencia**: ![SQL Injection test](qa-images/sql-injection.png)

- **Caso**: Acceso directo a create_product.php sin ser admin
- **Resultado esperado**: Redirección a login o mensaje de acceso denegado
- **Resultado obtenido**: [Anotar aquí]
- **Evidencia**: ![Admin check](qa-images/admin-check.png)

### 2. Gestión de Productos (create_product.php)
#### 2.1 Control de Acceso y Validación
- **Caso**: Acceso a create_product.php como usuario normal
- **Resultado esperado**: Redirección a products.php por no ser admin
- **Resultado obtenido**: [Anotar aquí]
- **Evidencia**: ![Control acceso](qa-images/admin-access.png)

- **Caso**: Validación de campos del producto
- **Resultado esperado**: Error si nombre vacío o precio <= 0
- **Resultado obtenido**: [Anotar aquí]
- **Evidencia**: ![Validación campos](qa-images/product-validation.png)

- **Caso**: Creación exitosa de producto
- **Resultado esperado**: Mensaje de éxito y producto en base de datos
- **Resultado obtenido**: [Anotar aquí]
- **Evidencia**: ![Producto creado](qa-images/product-created.png)

### 3. Carrito de Compras (carrito.php, ver_carrito.php)
#### 3.1 Gestión del Carrito en Sesión
- **Caso**: Agregar producto al carrito (quantity = 1)
- **Resultado esperado**: Producto agregado y redirección a products.php
- **Resultado obtenido**: [Anotar aquí]
- **Evidencia**: ![Agregar carrito](qa-images/add-cart.png)

- **Caso**: Ver carrito sin productos
- **Resultado esperado**: Mensaje "Tu carrito está vacío"
- **Resultado obtenido**: [Anotar aquí]
- **Evidencia**: ![Carrito vacío](qa-images/empty-cart.png)

- **Caso**: Cálculo de subtotales y total
- **Resultado esperado**: Suma correcta de (precio * cantidad)
- **Resultado obtenido**: [Anotar aquí]
- **Evidencia**: ![Cálculos carrito](qa-images/cart-totals.png)

### 4. Proceso de Checkout (checkout.php)
#### 4.1 Validación y Procesamiento de Orden
- **Caso**: Acceso a checkout con carrito vacío
- **Resultado esperado**: Redirección a ver_carrito.php
- **Resultado obtenido**: [Anotar aquí]
- **Evidencia**: ![Checkout vacío](qa-images/empty-checkout.png)

- **Caso**: Validación de campos obligatorios
- **Resultado esperado**: Error si falta nombre, email o dirección
- **Resultado obtenido**: [Anotar aquí]
- **Evidencia**: ![Validación campos](qa-images/checkout-validation.png)

- **Caso**: Proceso de orden exitoso
- **Resultado esperado**: Transacción completa y carrito limpio
- **Resultado obtenido**: [Anotar aquí]
- **Evidencia**: ![Orden exitosa](qa-images/order-success.png)

### 5. Persistencia de Datos
- **Caso**: Verificar orden en base de datos
- **Resultado esperado**: Orden almacenada con todos sus detalles
- **Resultado obtenido**: [Anotar aquí]
- **Evidencia**: ![Orden en BD](qa-images/order-database.png)

- **Caso**: Consistencia del carrito en sesión
- **Resultado esperado**: Carrito mantiene productos entre páginas
- **Resultado obtenido**: [Anotar aquí]
- **Evidencia**: ![Persistencia carrito](qa-images/cart-persistence.png)

## ✅ Conclusiones QA
### Aspectos Positivos
- [Listar funcionalidades que operan correctamente]

### Aspectos a Mejorar
- [Listar problemas encontrados o mejoras sugeridas]

### Bugs Críticos
- [Listar bugs que requieren atención inmediata]

## 📊 Resumen de Pruebas
- Total de pruebas realizadas: XX
- Pruebas exitosas: XX
- Pruebas fallidas: XX
- Bugs críticos: XX
