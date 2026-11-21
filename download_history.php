<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';

requireLogin();

$file = __DIR__ . '/data/trainings.csv';

$username = $_SESSION['user']['username'];

$trainings = readTrainings($file, $username);

// Preparamos la descarga
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="mi_historial.csv"');

// Abrimos la salida para generar el CSV
$output = fopen('php://output', 'w');

if ($output === false) {
    exit;
}

fputcsv($output, [
    'username',
    'date',
    'type',
    'duration',
    'rpe',
    'notes',
    'injury'
]);

// Escribimos los entrenamientos del usuario
foreach ($trainings as $training) {
    fputcsv($output, $training);
}

fclose($output);
exit;
