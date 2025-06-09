<?php
// router.php

if (php_sapi_name() == 'cli-server') {
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];

    if (is_file($file)) {
        // Si el archivo existe (css, js, imagenes, etc) servirlo directamente
        return false;
    }
}

// En cualquier otro caso, cargar index.php para que maneje la ruta
require_once __DIR__ . '/index.php';
