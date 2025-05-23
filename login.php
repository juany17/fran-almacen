<?php
require 'includes/config/database.php';
$db = conectarDB();

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Validar inputs
    $email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
    $password = mysqli_real_escape_string($db, $_POST['password']);

    if (!$email) {
        $errores[] = "El usuario es obligatorio";
    }
    if (!$password) {
        $errores[] = "La contraseña es obligatoria";
    }

    // Si no hay errores, consultar base de datos
    if (empty($errores)) {
        $query = "SELECT * FROM usuarios WHERE email = '$email' LIMIT 1";
        $resultado = mysqli_query($db, $query);

        if ($resultado && mysqli_num_rows($resultado) > 0) {
            $usuario = mysqli_fetch_assoc($resultado);

            // Verificar la contraseña
            $auth = password_verify($password, $usuario['password']);

            var_dump($password); // Lo que escribió el usuario
            var_dump($usuario['password']); // El hash guardado en la base


            if ($auth) {
                session_start();
                $_SESSION['usuario'] = $usuario['email'];
                $_SESSION['login'] = true;

                header('Location: /admin');
                exit;
            } else {
                $errores[] = "La contraseña es incorrecta";
            }
        } else {
            $errores[] = "El usuario no existe";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Registro Almacén</title>
    <link rel="stylesheet" href="build/css/app.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900&display=swap" rel="stylesheet">
</head>
<body>
    <header class="header">
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="/">
                    <h1 class="inicio">Despensa Francesca</h1>
                </a>
            </div>
        </div>
    </header>

    <main class="contenedor">
        <div class="login-container">
            <h2>Iniciar Sesión</h2>

            <?php foreach ($errores as $error): ?>
                <div class="alerta error">
                    <?php echo $error; ?>
                </div>
            <?php endforeach; ?>

            <form class="formulario" method="POST">
                <label for="email">Usuario</label>
                <input type="email" id="email" name="email" placeholder="Tu correo" required>

                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="Tu contraseña" required>

                <input type="submit" value="Entrar">
            </form>
        </div>
    </main>

    <footer class="footer seccion">
        <div class="contenedor contenedor-footer">
            <nav class="navegacion">
                <a href="index.php">Inicio</a>
            </nav>
        </div>
        <p class="copyright">
            Todos los derechos Reservados <?php echo date('d-m-Y'); ?> &copy;
        </p>
    </footer>

    <script src="build/js/bundle.min.js"></script>
</body>
</html>
