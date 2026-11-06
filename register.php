<?php 

declare(strict_types=1);

require_once __DIR__ . '/includes/data.php';

$pageTitle = 'Registro';


$errors = [];

$success = false;

$fullName = '';
$username = '';
$email = '';
$age ='';
$sport='';
$level ='';
$days=[];
$acceptData = false;


$trainingDays = [

    'monday' =>'Lunes',
    'tuesday' => 'Martes',
    'wednesday' => 'Miércoles',
    'thursday' => 'Jueves',
    'friday' => 'Viernes',
    'saturday' => 'Sábado',
    'sunday' => 'Domingo'

];

//comprovacion del formulario 

if ($_SERVER['REQUEST_METHOD'] === 'POST'){


    $fullName = trim($_POST['full_name'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email']?? '');
    $password= $_POST['password']?? '';
    $passwordConfirm = $_POST['password_confirm'] ?? '';
    $age = trim($_POST['age']?? '');
    $sport = $_POST['sport'] ?? '';
    $level= $_POST['level']?? '';
    $days = $_POST['days']??[];
    $acceptData = isset($_POST['accept_data']);

    //Validaciones 
    if (strlen($fullName)<3 || strlen($fullName)> 50 ){

        $errors['full_name'] = 'El nombre debe tener entre 3 y 50 caracteres.';
    }

    if (!preg_match('/^[a-zA-Z0-9_]{4,15}$/',$username)){
        $errors['username'] = 'El usuario debe tener entre 4 y 15 caracteres y solo puede contener letras , numeros y _.';     
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Introduce un correo electrónico válido.';
    }

    if (strlen($password)<8){
        $errors['password'] = 'La contraseña debe tener al menos 8 caracteres';
    }
    if ($password !==$passwordConfirm){

        $errors['password_confirm'] = 'Los passwords no coinciden ';
    }

      if (filter_var($age, FILTER_VALIDATE_INT) === false || (int)$age < 16 || (int)$age > 60) {
        $errors['age'] = 'La edad debe estar entre 16 y 60 años.';
    }

   
    if (!is_string($sport) || !array_key_exists($sport, $sports)) {
        $errors['sport'] = 'Selecciona un deporte valido.';
    }

 
    if (!is_string($level) || !array_key_exists($level, $levels)) {
        $errors['level'] = 'Selecciona un nivel competitivo valido.';
    }

    if (!is_array($days)) {
        $days = [];
    }

    $days = array_intersect(array_keys($trainingDays), $days);

    if (count($days) === 0) {
        $errors['days'] = 'Selecciona al menos un día de entrenamiento.';
    }

   
    if (!$acceptData) {
        $errors['accept_data'] = 'Debes aceptar el tratamiento de tus datos.';
    }

   
    if (empty($errors)) {
        $success = true;
    }

}

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<main>
    <h1>Registro de deportistas</h1>

    <form action="register.php" method="POST">

        <div class="form-group">
            <label for="full_name">Nombre completo:</label>
            <input type="text" id="full_name" name="full_name"
                value="<?= htmlspecialchars($fullName, ENT_QUOTES, 'UTF-8') ?>">

            <?php if (isset($errors['full_name'])): ?>
                <p class="error"><?= htmlspecialchars($errors['full_name'], ENT_QUOTES, 'UTF-8') ?></p>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="username">Nombre de usuario:</label>
            <input type="text" id="username" name="username"
                value="<?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8') ?>">

            <?php if (isset($errors['username'])): ?>
                <p class="error"><?= htmlspecialchars($errors['username'], ENT_QUOTES, 'UTF-8') ?></p>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="email">Correo electrónico:</label>
            <input type="email" id="email" name="email"
                value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>">

            <?php if (isset($errors['email'])): ?>
                <p class="error"><?= htmlspecialchars($errors['email'], ENT_QUOTES, 'UTF-8') ?></p>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password">

            <?php if (isset($errors['password'])): ?>
                <p class="error"><?= htmlspecialchars($errors['password'], ENT_QUOTES, 'UTF-8') ?></p>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="password_confirm">Confirmar password:</label>
            <input type="password" id="password_confirm" name="password_confirm">

            <?php if (isset($errors['password_confirm'])): ?>
                <p class="error"><?= htmlspecialchars($errors['password_confirm'], ENT_QUOTES, 'UTF-8') ?></p>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="age">Edad:</label>
            <input type="number" id="age" name="age" value="<?= htmlspecialchars($age, ENT_QUOTES, 'UTF-8') ?>">

            <?php if (isset($errors['age'])): ?>
                <p class="error"><?= htmlspecialchars($errors['age'], ENT_QUOTES, 'UTF-8') ?></p>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="sport">Deporte principal: </label>
            <select id="sport" name="sport">
                <option value="">Selecciona un deporte : </option>
                <?php foreach ($sports as $key=>$sportinfo):?>

                    <option value="<?=htmlspecialchars($key, ENT_QUOTES, 'UTF-8') ?>"
                    <?=  $sport === $key ? 'selected' : '' ?>>
                    <?= htmlspecialchars($sportinfo['name'], ENT_QUOTES, 'UTF-8') ?>

                    </option>
                    <?php endforeach;?>
            </select>

            <?php if (isset($errors['sport'])): ?>
                <p class="error"><?= htmlspecialchars($errors['sport'], ENT_QUOTES, 'UTF-8') ?></p>
            <?php endif; ?>


        </div>

        <div class="form-group">
            <p>Nivel competitivo:</p>
            <?php foreach ($levels as $key =>$label): ?>
                <label>
                    <input type="radio" name="level" value="<?= htmlspecialchars($key, ENT_QUOTES, 'UTF-8') ?>"
                    <?= $level === $key ? 'checked' : '' ?>>
                    <?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?>
                </label>
            <?php endforeach;?>
            <?php if (isset($errors['level'])): ?>
                    <p class="error"><?= htmlspecialchars($errors['level'], ENT_QUOTES, 'UTF-8') ?></p>
            <?php endif; ?>
        </div>


        <div class="form-group">
            <p>Días de entrenamiento:</p>

            <?php foreach ($trainingDays as $dayKey => $dayLabel): ?>
                <label>
                    <input type="checkbox" name="days[]" value="<?= htmlspecialchars($dayKey, ENT_QUOTES, 'UTF-8') ?>"
                        <?= in_array($dayKey, $days, true) ? 'checked' : '' ?>>
                    <?= htmlspecialchars($dayLabel, ENT_QUOTES, 'UTF-8') ?>
                </label>
            <?php endforeach; ?>

            <?php if (isset($errors['days'])): ?>
                <p class="error"><?= htmlspecialchars($errors['days'], ENT_QUOTES, 'UTF-8') ?></p>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>
                <input type="checkbox" name="accept_data" value="yes"
                    <?= $acceptData ? 'checked' : '' ?>>
                Acepto el tratamiento de mis datos.
            </label>

            <?php if (isset($errors['accept_data'])): ?>
                <p class="error">
                    <?= htmlspecialchars($errors['accept_data'], ENT_QUOTES, 'UTF-8') ?>
                </p>
            <?php endif; ?>
        </div>

                <button type="submit">Registrarme</button>

    </form>
</main>

<?php if ($success): ?>
    <div class="success">
        <h2>¡Registro completado correctamente!</h2>

        <p>Nombre: <?= htmlspecialchars($fullName, ENT_QUOTES, 'UTF-8') ?></p>
        <p>Usuario: <?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8') ?></p>
        <p>Correo: <?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?></p>
        <p>Edad: <?= htmlspecialchars($age, ENT_QUOTES, 'UTF-8') ?></p>
        <p>Deporte: <?= htmlspecialchars($sports[$sport]['name'], ENT_QUOTES, 'UTF-8') ?></p>
        <p>Nivel: <?= htmlspecialchars($levels[$level], ENT_QUOTES, 'UTF-8') ?></p>

        <p>Días de entrenamiento:</p>
        <ul>
            <?php foreach ($days as $day): ?>
                <li><?= htmlspecialchars($trainingDays[$day], ENT_QUOTES, 'UTF-8') ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>





