<?php

declare(strict_types=1);

// Detecta qué página está abierta
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<nav>
    <ul>
        <?php if (isset($_SESSION['user'])): ?>

            <li> Hola, <?= e($_SESSION['user']['name']) ?></li>

            <li>
                <a href="index.php">Inicio</a>
            </li>

            <li>
                <a href="training.php" class="<?= $currentPage === 'training.php' ? 'activo' : '' ?>">Nuevo entrenamiento</a>
            </li>

            <li>
                <a href="history.php">Historial</a>
            </li>

            <li>
                <a href="preferences.php">Preferencias</a>
            </li>

            <li>
                <a href="logout.php">Cerrar sesión</a>
            </li>

        <?php else: ?>

            <li>
                <a href="index.php">Inicio</a>
            </li>

            <li>
                <a href="register.php">Registro</a>
            </li>

            <li>
                <a href="login.php">Login</a>
            </li>

        <?php endif; ?>
    </ul>
</nav>