<?php 

declare(strict_types=1);

require_once __DIR__ . '/includes/data.php';
require_once __DIR__ . '/includes/functions.php';


require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';



$individuales = getSportsByCategory($sports, 'individual');

$equipo = getSportsByCategory($sports, 'equipo');

?>

<main>
    <h2>Deportes individuales</h2>

    <table>
    <tr>
        <th>Deporte</th>
        <th>Unidad</th>
    </tr>
    <?php foreach ($individuales as $sport):?>

        <tr>
            <td><?= htmlspecialchars($sport['name'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?=  htmlspecialchars($sport['unit'], ENT_QUOTES, 'UTF-8') ?></td>
        </tr>
        <?php endforeach;?>
    </table>

    <h2>Deportes de equipo</h2>

        <table>
            <tr>
                <td>Deporte</td>
                <td>Unidad</td>
            </tr>
            <?php foreach ($equipo as $sport):?>

                <tr>
                        <td><?= htmlspecialchars($sport['name'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($sport['unit'], ENT_QUOTES, 'UTF-8') ?></td>
                </tr>
            <?php endforeach;?>
        </table>
</main>

<?php 
require_once __DIR__ . '/includes/footer.php';
?>