<?php
require 'includes/funciones.php';
require 'includes/config/database.php';
incluirTemplates('header');

// Conexión a la base de datos
$db = conectarDB();

// Si hay algo escrito en el campo de búsqueda
$buscar = '';
if (isset($_GET['buscar'])) {
    $buscar = $_GET['buscar'];
}

// Consulta para traer productos (con búsqueda)
$consulta = "SELECT nombre, precio FROM registro WHERE nombre LIKE '%$buscar%'";
$resultado = mysqli_query($db, $consulta);
?>

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

    <a href="index.php" class="volver">← Volver al inicio</a>

    <!-- Contenedor de productos en formato grid -->
    <div class="grid-productos">
        <?php 
        $contador = 0;
        while($producto = mysqli_fetch_assoc($resultado)): 
            $contador++;
        ?>
            <div class="producto">
                <h3><?php echo htmlspecialchars($producto['nombre']); ?></h3>
                <p>Precio: $<?php echo number_format($producto['precio'], 2); ?></p>
            </div>
        <?php endwhile; ?>
    </div>

    <div class="total">
        Total de productos: <span id="total-productos"><?php echo $contador; ?></span>
    </div>
</div>

<?php
incluirTemplates('footer');
?>
