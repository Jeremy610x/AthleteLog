<?php

declare(strict_types=1);
require_once __DIR__ . '/includes/bootstrap.php';

requireLogin();



$pageTitle = 'Preferences';


$errors = [];
$success = false;

$themes = ['light','dark'];
$weightUnits = ['kg', 'lb'];


//valores de las cookies 
$theme = $_COOKIE['athlete_theme'] ?? 'light';
$weightUnit = $_COOKIE['athlete_weight_unit'] ?? 'kg';
$showTips = ($_COOKIE['athlete_show_tips'] ?? '1') === '1';


if (!in_array($theme, $themes, true)){

$theme = 'light';
}


if (!in_array($weightUnit, $weightUnits, true)){

    $weightUnit ='kg';
}

//opciones de seguridad de las cookies
$cookieOptions = [

    'expires' =>time() + (30*24*60*60),
    'path' => '/',
    'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
    'httponly' => true,
    'samesite' => 'Lax'

];


if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    if (isset($_POST['reset'])){
                //se restablece 

            setcookie('athlete_theme', '',[
                    ...$cookieOptions,
                    'expires' => time() - 3600

            ]);

            setcookie('athlete_weight_unit', '',[

                    ...$cookieOptions,
                    'expires'=>time() - 3600
            ]);

            setcookie ('athlete_show_tips','',[
                    ...$cookieOptions,
                    'expires'=>time() - 3600

            ]);

  
        header('Location: preferences.php');
        exit;

    }



        $theme = $_POST['theme'] ?? '';
        $weightUnit = $_POST['weight_unit'] ?? '';
        $showTipsValue = $_POST['show_tips'] ?? '0';

        if (!in_array($theme, $themes, true)){

                $errors['theme'] = 'Selecciona un tema valido';

        }

        if (!in_array($weightUnit, $weightUnits, true)) {
    $errors['weight_unit'] = 'Selecciona una unidad valida';
        }
        if (!in_array($showTipsValue, ['0', '1'], true)){

                $errors['show_tips'] = 'Selecciona una opcion valida ';
        }



    // guardamos las preferencias si no hay errores 
        if (empty($errors)){

            setcookie('athlete_theme', $theme, $cookieOptions);
            setcookie('athlete_weight_unit', $weightUnit, $cookieOptions);
            setcookie('athlete_show_tips', $showTipsValue, $cookieOptions);
            header('Location: preferences.php');
            exit;
        }

        $showTips = $showTipsValue === '1';

}



require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';

?>

<main>
    <h1>Preferences</h1>
        <form action="preferences.php" method="POST">
            <?= csrfField() ?>
        <div class="form-group">
        <p>Tema de la aplicacion : </p>
        <label><input type="radio" name="theme" value="light" <?= $theme ==='light' ? 'checked' : '' ?>> Claro</label>
        <label><input type="radio" name="theme" value="dark" <?= $theme ==='dark' ? 'checked' : '' ?>> Oscuro</label>
        <?php if (isset($errors['theme'])): ?>
            <p class="error"><?=  e($errors['theme']) ?></p>
        <?php endif;?>
        </div>


        <div class="form-group">
            <label for="weight_unit">Unidad de peso : </label>

            <select name="weight_unit" id="weight_unit">
                <option value="kg" <?=  $weightUnit=== 'kg' ? 'selected' : '' ?> >Kilogramos(kg)</option>
                <option value="lb" <?= $weightUnit === 'lb' ? 'selected' : '' ?>>Libras </option>
            </select>

            <?php  if (isset($errors['weight_unit'])): ?>
                <p class="error"><?=  e($errors['weight_unit']) ?></p>
            <?php endif;?>


        </div>


        <div class="form-group">
            <label>
                <input
                    type="checkbox"
                    name="show_tips"
                    value="1"
                    <?= $showTips ? 'checked' : '' ?>
                >
                Mostrar consejos
            </label>
        </div>
        <button type="submit">Guardar preferencias</button>

        </form>

        <form action="preferences.php" method="POST">

        <button type="submit" name="reset" value="1"> restablecer preferencias</button>


        </form>
    <?php if ($success): ?>
        <p class="success">Preferencias guardadas correctamente.</p>
    <?php endif; ?>

</main>

<?php

require_once __DIR__ . '/includes/footer.php';

?>