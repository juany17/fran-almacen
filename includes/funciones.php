<?php

require 'app.php';

function incluirTemplates($nombre, $inicio = false) {
    include TEMPLATES_URL . "/${nombre}.php";
}

function estaAutenticado(): bool {
    // Solo inicia la sesión si no está ya iniciada
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    return $_SESSION['login'] ?? false;
}
