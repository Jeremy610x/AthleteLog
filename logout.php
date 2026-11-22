<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';

unset($_SESSION['csrf_token']);

$_SESSION = [];


session_destroy();

header('Location: login.php');
exit;
