<?php

declare(strict_types=1);

$pageTitle = 'Inicio';

require_once __DIR__ . '/includes/bootstrap.php';


require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';

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
</main>

<?php
require_once __DIR__ . '/includes/footer.php';
?>