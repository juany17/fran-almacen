<?php
//importar la conexion
require 'includes/config/database.php';
$db = conectarDB();

//crear un email y un password
$email = "correo@correo.com";
$password = "123456";

$passwordHash = password_hash($password, PASSWORD_BCRYPT);

//query para crear el ususario 
$query = " INSERT INTO usuarios (email, password) VALUES ( '${email}', '${passwordHash}' ); ";

//agregar a la base de datos 
mysqli_query($db, $query);

if ($resultado) {
    echo "✅ Usuario insertado correctamente.";
} else {
    echo "❌ Error al insertar: " . mysqli_error($db);
}
?>