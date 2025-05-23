<?php

require 'app.php';

function incluirTemplates($nombre, $inicio = false) {
    include TEMPLATES_URL . "/${nombre}.php";
}

function estaAutententicado() : bool {
    session_start();

    $auth = $_SESSION['login'];
    if($auth) {
        return true;
    }

    return false;
}