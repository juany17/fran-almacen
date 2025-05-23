<?php
require '../../includes/funciones.php';
$auth = estaAutententicado();

if(!$auth) {
    header('Location: /');
}

//base de datos
require '../../includes/config/database.php';
$db = conectarDB();

//Consulta para obtener los vendedores
//$consulta = "SELECT * FROM vendedores";
//$resultado = mysqli_query($db, $consulta);

//Arreglo con mensajes de errores
$errores = [];

$fecha = '';
$hora = '';
$total = '';
$estado = '';
$descripcion = '';

//Ejecuta el codigo despues de que el ususario envie el forulario
if($_SERVER ['REQUEST_METHOD'] === 'POST') {
    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";

    $fecha = mysqli_real_escape_string( $db,  $_POST['fecha'] );
    $hora = mysqli_real_escape_string ($db,  $_POST['hora'] );
    $total = mysqli_real_escape_string( $db,  $_POST['total'] );
    $estado = mysqli_real_escape_string( $db,  $_POST['estado'] );
    $descripcion = mysqli_real_escape_string( $db,  $_POST['descripcion'] );

    if(!$fecha) {
        $errores[] = "Debes añadir una fecha";
    }

    if(!$hora) {
        $errores[] = "Debes añadir una hora";
    }

    if(!$total) {
        $errores[] = "El total es obligatorio";
    }

    if(!$estado) {
        $errores[] = "El estado es obligatorio";
    }

    if(!$descripcion) {
        $errores[] = "Debe de tener una descripción";
    }
    

    //Revisar el arreglo de errores este vacio
    if(empty($errores)) {
        //insertar en la base de datos 
    $query = " INSERT INTO cierre_caja (fecha, hora, total, estado, descripcion) VALUES ( '$fecha', '$hora', '$total', '$estado', '$descripcion' )";

    $resultado = mysqli_query($db, $query);

    if($resultado) {
        //Redirecciona al usuario
        header('Location: /admin?resultado=1');
    }

    
    }

   
}


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Registro</title>
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
<main>
    <?php foreach($errores as $error): ?>
    <div class="alerta error"> 
        <?php echo $error; ?>
    </div>
    <?php endforeach ; ?>

    <form class="formulario" action="/admin/registro/crear.php" method="POST">
        <h1>Administrador</h1>
        <h2>Registro de Movimientos</h2>
        <fieldset>
            <div class="campo">
                <label for="fecha">Fecha:</label>
                <input type="date" id="fecha" name="fecha" value="<?php echo $fecha; ?>">
            </div>

            <div class="campo">
                <label for="hora">Hora:</label>
                <input type="time" id="hora" name="hora" value="<?php echo $hora; ?>">
            </div>

            <div class="campo">
                <label for="total">Total:</label>
                <input type="number" id="total" name="total" placeholder="Ej. 150.00" value="<?php echo $total; ?>">
            </div>

            <div class="campo">
                <label for="descripcion">descripcion:</label>
                <input type="text" id="descripcion" name="descripcion" value="<?php echo $descripcion; ?>">
            </div>

            <fieldset>
                <label for="estado">Tipo:</label>
                <legend>Tipo de movimiento</legend>
                <select name="estado">
                <option value="">-- Seleccione --</option>
                <option value="entrada">Entrada</option>
                <option value="salida">Salida</option>
            </select>
        </fieldset>

            <button type="submit" class="boton">Registrar</button>
            <a href="/admin/index.php" class="boton">← Volver al inicio</a>
        </fieldset>
    </form>
</main>
    <footer class="footer seccion">
        <div class="contenedor contenedor-footer">
            <nav class="navegacion">
                <a href="contactos.php">Contactos</a>
            </nav>
        </div>

        <p class="copyright">Todos los derechos Reservados <?php echo date('d-m-Y'); ?> &copy;</p>
    </footer>

    <script src="/build/js/bundle.min.js"></script>

<?php 
/*
while($vendedor = mysqli_fetch_assoc($resultado)): 
    echo "<option value=''>" . $vendedor['nombre'] . " " . $vendedor['apellido'] . "</option>";
endwhile; 
*/
?>

</body>
</html>

