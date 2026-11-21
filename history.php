<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';

requireLogin();

$pageTitle = 'Historial';


$file = __DIR__ . '/data/trainings.csv';

// Obtenemos el nombre del usuario conectado
$username = $_SESSION['user']['username'];



$trainings = readTrainings($file, $username);

// Comprobamos si ha ocurrido un error al leer el CSV
$fileError = ($trainings === null);

if ($fileError) {
    $trainings = [];
} else {
    
    usort($trainings, function ($a, $b) {
        return strcmp($b['date'], $a['date']);
    });
}






$trainingTypes = [
    'Tecnica',
    'Fuerza',
    'Resistencia',
    'Competicion',
    'Recuperacion'
];

// Recogemos el tipo seleccionado
$selectedType = $_GET['type'] ?? '';

// Filtramos los entrenamientos por tipo
if (in_array($selectedType, $trainingTypes, true)) {
    $trainings = array_values(array_filter(
        $trainings,
        function ($training) use ($selectedType) {
            return $training['type'] === $selectedType;
        }
    ));
}
// Calculo de  estadísticas
$totalSessions = count($trainings);
$totalMinutes = 0;
$totalRpe = 0;
$totalLoad = 0;

foreach ($trainings as $training) {
    $duration = (int) $training['duration'];
    $rpe = (int) $training['rpe'];

    $totalMinutes += $duration;
    $totalRpe += $rpe;
    $totalLoad += calculateLoad($duration, $rpe);
}

$averageRpe = $totalSessions > 0
    ? $totalRpe / $totalSessions
    : 0;



require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';

?>

<main>
    <h1>Historial de entrenamientos</h1>
    <?php if ($fileError): ?>

    <p>No se ha podido acceder al fichero de entrenamientos. Inténtalo más tarde.</p>

<?php else: ?>

<form method="GET" action="history.php">

    <label for="type">Filtrar por tipo de entrenamiento:</label>

    <select name="type" id="type">
        <option value="">Todos los tipos</option>

        <?php foreach ($trainingTypes as $type): ?>
            <option
                value="<?= e($type) ?>"
                <?= $selectedType === $type ? 'selected' : '' ?>
            >
                <?= e($type) ?>
            </option>
        <?php endforeach; ?>

    </select>

    <button type="submit">Filtrar</button>

    <a href="history.php">Limpiar filtro</a>

</form>

<form action="download_history.php" method="GET">
    <button type="submit">Descargar mi historial en CSV</button>
</form>





    <?php if (empty($trainings)): ?>

        <p>Todavía no hay entrenamientos registrados.</p>

    <?php else: ?>

        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Tipo</th>
                    <th>Duración</th>
                    <th>RPE</th>
                    <th>Sensaciones</th>
                    <th>Lesión</th>
                    <th>Carga</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($trainings as $training): ?>
                    <tr>
                        <td><?= e($training['date']) ?></td>
                        <td><?= e($training['type']) ?></td>
                        <td><?= e($training['duration']) ?> minutos</td>
                        <td><?= e($training['rpe']) ?></td>
                        <td><?= e($training['notes']) ?></td>
                        <td><?= e($training['injury'] !== '' ? $training['injury'] : 'No') ?></td>
                        <td>
                            <?= calculateLoad(
                                (int) $training['duration'],
                                (int) $training['rpe']
                            ) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Estadísticas de entrenamiento</h2>

        <p>Total de sesiones: <?= $totalSessions ?></p>

        <p>Minutos totales: <?= $totalMinutes ?> minutos</p>

        <p>RPE medio: <?= number_format($averageRpe, 2) ?></p>

        <p>Carga total: <?= $totalLoad ?></p>


                 <?php endif; ?>
    <?php endif; ?>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
