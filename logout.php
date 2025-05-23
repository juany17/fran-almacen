<?php
session_start();
$_SESSION = []; // Vacía el arreglo de sesión
session_destroy(); // Destruye la sesión
header('Location: /'); // Redirige al inicio o login
exit;
?>
