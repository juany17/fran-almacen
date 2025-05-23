<?php

require '../../includes/funciones.php';
$auth = estaAutententicado();

if(!$auth) {
    header('Location: /');
}

// Conexión a la base de datos
require '../../includes/config/database.php';
$db = conectarDB();

// Arreglo de errores
$errores = [];

$nombre = '';
$telefono = '';

//Ejecuta el codigo despues de que el ususario envie el forulario
if($_SERVER ['REQUEST_METHOD'] === 'POST') {
    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";

    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];

    if(!$nombre) {
        $errores[] = "Debes añadir un nombre";
    }

    if(!$telefono) {
        $errores[] = "Debes añadir un telefono";
    }

    //Revisar el arreglo de errores este vacio
    if(empty($errores)) {
        //insertar en la base de datos 
    $query = " INSERT INTO contactos (nombre, telefono) VALUES ( '$nombre', '$telefono' )";

    $resultado = mysqli_query($db, $query);

    if($resultado) {
        echo "Insertado correctamente";
        } 
    }

   
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Contactos</title>
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
    <h1>Gestión de Contactos</h1>

    <!-- Mostrar errores -->
    <?php foreach($errores as $error): ?>
        <div class="alerta error"><?php echo $error; ?></div>
    <?php endforeach; ?>

    <!-- Formulario de agregado -->
    <form method="POST" class="formulario" action="/admin/registro/contacto.php">
        <div class="campo">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" required>
        </div>
        <div class="campo">
            <label for="telefono">Número:</label>
            <input type="tel" name="telefono" id="telefono" required>
        </div>
        <button type="submit" name="agregar" class="boton">Agregar</button>
    </form>

    <!-- Lista de contactos -->
    <div class="lista-contactos">
        <h2>Contactos Registrados</h2>
    
    </div>

    <!-- Volver al inicio -->
    <div class="volver">
        <a href="/admin/index.php" class="volver">← Volver al inicio</a>
    </div>
</main>
</body>
</html>
