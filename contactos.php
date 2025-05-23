<?php
require 'includes/funciones.php';
incluirTemplates('header');

require 'includes/config/database.php';

$db = conectarDB();

$consulta = "SELECT nombre, telefono FROM contactos";
$resultado = mysqli_query($db, $consulta);
?>


<main class="contenedor seccion">
    <div class="lista-contactos">
        <h2>Contactos Registrados</h2>

        <?php if (mysqli_num_rows($resultado) > 0): ?>
            <ul>
                <?php while($contacto = mysqli_fetch_assoc($resultado)): ?>
                    <li>
                        <strong>Nombre:</strong> <?php echo htmlspecialchars($contacto['nombre']); ?> <br>
                        <strong>Teléfono:</strong> <?php echo htmlspecialchars($contacto['telefono']); ?>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>No hay contactos registrados.</p>
        <?php endif; ?>
    </div>

    <a href="index.php" class="volver">← Volver al inicio</a>
</main>

<?php
incluirTemplates('footer');
?>
