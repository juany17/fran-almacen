<?php
ob_start(); // Inicia el buffer de salida
require '../includes/funciones.php';
$auth = estaAutenticado();

if (!$auth) {
    header('Location: /');
    exit;
}

$resultado = $_GET['resultado'] ?? null;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro almacén</title>
    <link rel="stylesheet" href="/build/css/app.css">
    <style>
        .enlaces-centrados {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 50px;
            margin-top: 3rem;
            flex-wrap: wrap;
        }
        .enlace-img {
            text-align: center;
            text-decoration: none;
            color: #000;
        }
        .enlace-img img {
            width: 300px;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            transition: transform 0.3s;
        }
        .enlace-img img:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <header class="header <?php echo isset($inicio) && $inicio ? 'inicio' : ''; ?>">
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="/">
                    <h1 class="inicio">Despensa Francesca</h1>
                </a>
                <a href="/logout.php" class="login-link">Cerrar Sesión</a>
            </div>
        </div>
        <h2 style="text-align: center;">Panel de Administración</h2>
    </header>

    <main class="contenedor seccion">
        <?php if (intval($resultado) === 1): ?>
            <p class="alerta exito">Creado correctamente</p>
        <?php endif; ?>

        <h1 style="text-align: center;">🛒 Elige una opción</h1>

        <div class="enlaces-centrados">
            <a href="/admin/registro/resumen-caja.php" class="enlace-img">
                <img src="../src/img/resumen caja.jpg" alt="Resumen de Caja">
                <p>Resumen de caja</p>
            </a>
            <a href="/admin/registro/contacto.php" class="enlace-img">
                <img src="../src/img/contactos.jpg" alt="Contactos">
                <p>Agregar contactos</p>
            </a>
            <a href="/admin/registro/crear.php" class="enlace-img">
                <img src="../src/img/registrar caja.webp" alt="Registrar Caja">
                <p>Registrar caja</p>
            </a>
            <a href="/admin/registro/crear_almacen.php" class="enlace-img">
                <img src="../src/img/gestion almacen.png" alt="Administrar Almacén">
                <p>Administrar almacén</p>
            </a>
        </div>
    </main>

    <footer class="footer seccion">
        <div class="contenedor contenedor-footer">
            <nav class="navegacion"></nav>
        </div>
        <p class="copyright">
            Todos los derechos Reservados <?php echo date('d-m-Y'); ?> &copy;
        </p>
    </footer>

    <script src="/build/js/bundle.min.js"></script>
</body>
</html>

<?php ob_end_flush(); // Finaliza el buffer de salida ?>
