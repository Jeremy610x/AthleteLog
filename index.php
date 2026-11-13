<?php

declare(strict_types=1);

$pageTitle = 'Inicio';

require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';


$previousVisits = $_COOKIE['visits'] ?? '0';


if (!is_string($previousVisits) || !ctype_digit($previousVisits)) {
    $previousVisits = '0';
}


$visits = (int) $previousVisits + 1;

// Guarda el contador durante 30 días
setcookie('visits', (string) $visits, [
    'expires' => time() + (30 * 24 * 60 * 60),
    'path' => '/',
    'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
    'httponly' => true,
    'samesite' => 'Lax'
]);


// Muestra el mensaje de bienvenida
echo renderMensajeBienvenida();

// Separa los deportes por categoría
$individuales = getSportsByCategory($sports, 'individual');
$equipo = getSportsByCategory($sports, 'equipo');
?>

<main>
    <h2>Deportes individuales</h2>

    <?= renderSportsTable($individuales) ?>

    <h2>Deportes de equipo</h2>

    <?= renderSportsTable($equipo) ?>
    <p>Visitas a la página de inicio: <?= e((string) $visits) ?></p>
    
</main>

<?php
require_once __DIR__ . '/includes/footer.php';
?>