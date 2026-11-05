<?php

declare(strict_types=1);

//se usa para que la pagina activa este resaltada 
$currentPage = basename($_SERVER['PHP_SELF']);

$menu = [
    'index.php' => 'Inicio',
    'register.php' =>'Registro',
    'login.php' =>'Login',
    'training.php' => 'Entrenamiento',
    'history.php' =>'Historial',
    'preferences.php' => 'Preferencias'
];

?>

<nav>

    <ul>

        <?php foreach($menu as $file => $label):?>
            <li>
             <a
                href="<?= htmlspecialchars($file, ENT_QUOTES, 'UTF-8') ?>"
                class="<?= $currentPage === $file ? 'activo' : '' ?>"
            >
                <?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?>
                </a>
            </li>


        <?php endforeach; ?>


    </ul>


</nav>