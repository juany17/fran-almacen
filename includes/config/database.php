<?php
require_once __DIR__ . '/../vendor/autoload.php'; // Asegurate de que el path sea correcto

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

function conectarDB(): mysqli {
    $db = mysqli_init();
    mysqli_ssl_set($db, NULL, NULL, NULL, NULL, NULL);
    mysqli_real_connect(
        $db,
        $_ENV['DB_HOST'],
        $_ENV['DB_USER'],
        $_ENV['DB_PASS'],
        $_ENV['DB_NAME'],
        intval($_ENV['DB_PORT']),
        NULL,
        MYSQLI_CLIENT_SSL
    );
    if (!$db) {
        die('Error de conexión (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
    }
    return $db;
}
