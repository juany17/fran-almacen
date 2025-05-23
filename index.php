<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro almacén</title>
    <link rel="stylesheet" href="build/css/app.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900&display=swap" rel="stylesheet">

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
                    <H1 class="inicio">Despensa Francesca</H1>
                </a>
                <a href="login.php" class="login-link">
                    <h3>Iniciar sesion</h3>
                </a>
            </div>
            </div>
            <h1>Registro de productos</h1>
        </div>
    </header>

    <main class="contenedor seccion">
        <h1 style="text-align: center;">🛒 Elige una opción</h1>

        <div class="enlaces-centrados">
            <a href="contactos.php" class="enlace-img">
                <img src="https://images.unsplash.com/photo-1588702547923-7093a6c3ba33?auto=format&fit=crop&w=600&q=80" alt="Contactos">
                <p>Contactos</p>
            </a>
            <a href="almacen.php" class="enlace-img">
                <img src="src/img/almacen.jpeg" alt="almacen">
                
                <p>Almacén</p>
            </a>
        </div>
    </main>

    <footer class="footer seccion">
        <div class="contenedor contenedor-footer">
            <nav class="navegacion">
                <a href="contactos.php">Contactos</a>
            </nav>
        </div>
        <p class="copyright">Todos los derechos Reservados <?php echo date('d-m-Y'); ?> &copy;</p>
    </footer>

    <script src="build/js/bundle.min.js"></script>
</body>
</html>
