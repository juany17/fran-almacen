<?php
require_once __DIR__ . '/../../vendor/autoload.php'; // Ajusta si es necesario

use Dotenv\Dotenv;

$envPath = __DIR__ . '/../../.env';

if (file_exists($envPath)) {
    $dotenv = Dotenv::createImmutable(dirname($envPath));
    $dotenv->load();  // Primero cargo el .env

} else {
    error_log('.env file not found. Using environment variables from the system.');
}

function conectarDB(): mysqli {
    $db = mysqli_init();
    mysqli_ssl_set($db, NULL, NULL, NULL, NULL, NULL);
    mysqli_real_connect(
        $db,
        $_ENV['DB_HOST'] ?? getenv('DB_HOST'),
        $_ENV['DB_USER'] ?? getenv('DB_USER'),
        $_ENV['DB_PASS'] ?? getenv('DB_PASS'),
        $_ENV['DB_NAME'] ?? getenv('DB_NAME'),
        intval($_ENV['DB_PORT'] ?? getenv('DB_PORT')),
        NULL,
        MYSQLI_CLIENT_SSL
    );

    if (!$db) {
        die('Error de conexión (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
    }

    return $db;
}
