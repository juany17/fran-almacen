<?php
// Verificar si la constante ya está definida
if (!defined('TEMPLATES_URL')) {
    require '../../includes/funciones.php';
    require '../../includes/config/database.php';
}

// Conexión a la base de datos
$db = conectarDB();

// Eliminar registro - Versión segura con consultas preparadas
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_producto'])) {
    $id = $_POST['id_producto'];
    
    // Validar que el ID sea numérico
    if (is_numeric($id)) {
        try {
            $stmt = $db->prepare("DELETE FROM registro WHERE id_producto = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            
            // Redireccionar para evitar reenvío del formulario
            header('Location: adalmacen.php');
            exit;
        } catch (mysqli_sql_exception $e) {
            die("Error al eliminar: " . $e->getMessage());
        }
    }
}

// Búsqueda segura
$buscar = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';

// Consulta para productos con búsqueda - Versión segura
$sql = "SELECT id_producto, nombre, precio FROM registro";
if (!empty($buscar)) {
    $sql .= " WHERE nombre LIKE ?";
    $param_buscar = "%$buscar%";
}

$stmt = $db->prepare($sql);
if (!empty($buscar)) {
    $stmt->bind_param("s", $param_buscar);
}
$stmt->execute();
$resultado = $stmt->get_result();
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Producto</title>
    <link rel="stylesheet" href="../../build/css/app.css">
</head>
<body>
    <header>
    <div class="contenedor contenido-header">
        <div class="barra">
            <a href="/admin/index.php">
                    <H1 class="inicio">Despensa Francesca</H1>
                </a>
                <a href="/logout.php" class="login-link">Cerrar Sesión</a>
                </a>
            </div>
            </div>
    </header>

<div class="container">
    <h1>📦 Resumen de Almacén</h1>

    <!-- Formulario de búsqueda -->
    <form method="GET" action="">
        <input type="text" name="buscar" value="<?php echo htmlspecialchars($buscar); ?>" placeholder="Buscar productos..." class="search-input">
        <button type="submit" class="search-button" aria-label="Buscar">
            <!-- SVG de la lupa -->
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="black" viewBox="0 0 24 24" class="icono-lupa">
                <path d="M10 2a8 8 0 015.29 13.71l4 4a1 1 0 01-1.42 1.42l-4-4A8 8 0 1110 2zm0 2a6 6 0 100 12 6 6 0 000-12z"/>
            </svg>
        </button>
    </form>

    <a href="/admin/index.php" class="volver">← Volver al inicio</a>

    <!-- Contenedor de productos -->
    <div class="grid-productos">
        <?php 
        $contador = 0;
        while($producto = mysqli_fetch_assoc($resultado)): 
            $contador++;
        ?>
            <div class="producto">
                <h3><?php echo htmlspecialchars($producto['nombre']); ?></h3>
                <p>Precio: $<?php echo number_format($producto['precio'], 2); ?></p>
                
                <!-- Botones de Acción -->
                <div class="acciones">
                    <!-- Botón Eliminar -->
                    <form method="POST" onsubmit="return confirm('¿Seguro que querés eliminar este producto?');">
                     <input type="hidden" name="id_producto" value="<?php echo $producto['id_producto']; ?>">
                    <input type="submit" value="Eliminar" class="boton-eliminar">
                    </form>
                    
                    <!-- Botón Actualizar (enlace a formulario de edición) -->
                    <!-- Botón Actualizar -->
                    <a href="actualizar.php?id=<?php echo $producto['id_producto']; ?>" class="boton-actualizar">
                    Actualizar
                    </a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <div class="total">
        Total de productos: <span id="total-productos"><?php echo $contador; ?></span>
    </div>
</div>

<footer class="footer seccion">
        <div class="contenedor contenedor-footer">
            <nav class="navegacion">
            </nav>
        </div>
        <p class="copyright">
            Todos los derechos Reservados <?php echo date('d-m-Y'); ?> &copy;
        </p>
</footer>