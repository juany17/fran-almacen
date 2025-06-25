<?php

require '../../includes/funciones.php';
$auth = estaAutenticado();

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

// Insertar nuevo contacto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['agregar'])) {
        $nombre = $_POST['nombre'];
        $telefono = $_POST['telefono'];

        if (!$nombre) {
            $errores[] = "Debes añadir un nombre";
        }

        if (!$telefono) {
            $errores[] = "Debes añadir un teléfono";
        }

        if (empty($errores)) {
            $query = "INSERT INTO contactos (nombre, telefono) VALUES (?, ?)";
            $stmt = $db->prepare($query);
            $stmt->bind_param("ss", $nombre, $telefono);
            $stmt->execute();
        }
    }

    // Eliminar contacto
    if (isset($_POST['eliminar']) && isset($_POST['id_contactos'])) {
        $id = $_POST['id_contactos'];
        if (is_numeric($id)) {
            $query = "DELETE FROM contactos WHERE id_contactos = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
        }
    }
}

// Consultar todos los contactos
$contactos = $db->query("SELECT * FROM contactos");

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
                <h1 class="inicio">Despensa Francesca</h1>
            </a>
            <a href="/logout.php" class="login-link">Cerrar Sesión</a>
        </div>
    </div>
</header>

<main class="contenedor seccion">
    <h1>Gestión de Contactos</h1>

    <!-- Mostrar errores -->
    <?php foreach ($errores as $error): ?>
        <div class="alerta error"><?php echo $error; ?></div>
    <?php endforeach; ?>

    <!-- Formulario de agregado -->
    <form method="POST" class="formulario">
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

        <?php while ($row = mysqli_fetch_assoc($contactos)): ?>
            <div class="contacto">
                <p><strong>Nombre:</strong> <?php echo htmlspecialchars($row['nombre']); ?></p>
                <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($row['telefono']); ?></p>
                <form method="POST" onsubmit="return confirm('¿Seguro que querés eliminar este contacto?');">
                    <input type="hidden" name="id_contactos" value="<?php echo $row['id_contactos']; ?>">
                    <button type="submit" name="eliminar" class="boton-eliminar">Eliminar</button>
                </form>
            </div>
        <?php endwhile; ?>
    </div>

    <div class="volver">
        <a href="/admin/index.php" class="volver">← Volver al inicio</a>
    </div>
</main>

</body>
</html>
