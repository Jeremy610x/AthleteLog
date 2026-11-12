<?php

declare(strict_types=1);
//permite que cada pagina tenga un titulo diferente como Inicio | AtheleteLog
$pageTitle = $pageTitle ?? 'AthleLog';

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?> | <?= APP_NAME ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
