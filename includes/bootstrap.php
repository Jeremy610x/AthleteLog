<?php

declare(strict_types=1);

//Inicia la sesion si todavia no esta iniciado
// Configuración de seguridad de la cookie de sesión
if (session_status() === PHP_SESSION_NONE) {

    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => !empty($_SERVER['HTTPS']),
        'httponly' => true,
        'samesite' => 'Lax'
    ]);

    session_start();
}

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/components.php';
require_once __DIR__ . '/data.php';


