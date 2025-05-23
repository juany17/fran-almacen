<?php
require '../../includes/funciones.php';
$auth = estaAutententicado();

if(!$auth) {
    header('Location: /');
}

// Base de datos
require '../../includes/config/database.php';
$db = conectarDB();

// Errores
$errores = [];
$nombre = '';
$precio = '';

// Validación y guardado
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = mysqli_real_escape_string($db, $_POST['nombre']);
    $precio = mysqli_real_escape_string($db, $_POST['precio']);

    if(!$nombre) {
        $errores[] = "Debes añadir un nombre";
    }

    if(!$precio) {
        $errores[] = "Debes añadir un precio";
    }

    if(empty($errores)) {
        $query = "INSERT INTO registro (nombre, precio) VALUES ('$nombre', '$precio')";
        $resultado = mysqli_query($db, $query);

        if($resultado) {
            header('Location: /admin?resultado=2');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Producto</title>
    <link rel="stylesheet" href="/build/css/app.css">
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

    <main class="contenedor seccion">
        <h1>Crear Producto</h1>

        <?php foreach($errores as $error): ?>
            <div class="alerta error"><?php echo $error; ?></div>
        <?php endforeach; ?>

        <form class="formulario" method="POST" >
            <fieldset>
                <legend>Información del Producto</legend>

                <div class="campo">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Nombre del producto" value="<?php echo $nombre; ?>">
                </div>

                <div class="campo">
                    <label for="precio">Precio:</label>
                    <input type="number" id="precio" name="precio" placeholder="Ej. 99.99" value="<?php echo $precio; ?>" step="0.01">
                </div>
            </fieldset>

            <button type="submit" class="boton">Registrar Producto</button>
            <a href="/admin/registro/crear_almacen.php" class="boton">← Volver</a>
            <a href="../registro/adalmacen.php" class="boton">← almacen</a>
        </form>
    </main>

    <footer class="footer seccion">
        <div class="contenedor contenedor-footer">
            <nav class="navegacion">
                <a href="contactos.php">Contactos</a>
            </nav>
        </div>
        <p class="copyright">
            Todos los derechos Reservados <?php echo date('d-m-Y'); ?> &copy;
        </p>
    </footer>
</body>
</html>
