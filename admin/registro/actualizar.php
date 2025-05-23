<?php
// 1. Conexión a la base de datos y funciones
require '../../includes/funciones.php';
require '../../includes/config/database.php';
$db = conectarDB();

// 2. Obtener el ID del producto a editar
$id = $_GET['id'] ?? null; // Obtenemos el ID de la URL

// 3. Validar que el ID sea numérico
if (!$id || !is_numeric($id)) {
    header('Location: adalmacen.php'); // Redirigir si no hay ID válido
    exit;
}

// 4. Obtener los datos actuales del producto
$consulta = "SELECT * FROM registro WHERE id_producto = $id";
$resultado = mysqli_query($db, $consulta);
$producto = mysqli_fetch_assoc($resultado);

// 5. Procesar el formulario cuando se envía (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 6. Sanitizar los datos del formulario
    $nombre = mysqli_real_escape_string($db, $_POST['nombre'] ?? '');
    $precio = mysqli_real_escape_string($db, $_POST['precio'] ?? 0);
    
    // 7. Validar los datos
    $errores = [];
    
    if (!$nombre) {
        $errores[] = "El nombre es obligatorio";
    }
    
    if (!$precio || !is_numeric($precio)) {
        $errores[] = "El precio debe ser un número válido";
    }
    
    // 8. Si no hay errores, actualizar en la base de datos
    if (empty($errores)) {
        $query = "UPDATE registro SET 
                 nombre = '$nombre',
                 precio = $precio
                 WHERE id_producto = $id";
        
        $resultado = mysqli_query($db, $query);
        
        if ($resultado) {
            header('Location: adalmacen.php?exito=1'); // Redirigir con mensaje de éxito
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="../../build/css/app.css">
</head>
<body>
    <header>
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="/admin/index.php">
                    <h1 class="inicio">Despensa Francesca</h1>
                </a>
                <a href="/logout.php" class="login-link">Cerrar Sesión</a>
            </div>
        </div>
    </header>

    <main class="contenedor seccion">
        <h1>Editar Producto</h1>
        
        <!-- Botón para volver -->
        <a href="adalmacen.php" class="boton boton-verde">← Volver al Listado</a>
        
        <!-- Mostrar errores -->
        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>
        
        <!-- Formulario de edición -->
        <form class="formulario" method="POST">
            <fieldset>
                <legend>Información del Producto</legend>
                
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" placeholder="Nombre del producto" 
                       value="<?php echo htmlspecialchars($producto['nombre'] ?? ''); ?>">
                
                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" placeholder="Precio" step="0.01" min="0"
                       value="<?php echo htmlspecialchars($producto['precio'] ?? 0); ?>">
            </fieldset>
            
            <input type="submit" value="Guardar Cambios" class="boton boton-verde">
        </form>
    </main>

    <footer class="footer seccion">
        <div class="contenedor contenedor-footer">
            <p class="copyright">Todos los derechos Reservados <?php echo date('Y'); ?> &copy;</p>
        </div>
    </footer>
</body>
</html>