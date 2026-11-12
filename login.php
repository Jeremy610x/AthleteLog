<?php 

declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';

if (isset($_SESSION['user'])){
    header('Location:training.php');
    exit;

}

$pageTitle = 'Login';

$error ='';
$username='';
$password = '';

if ($_SERVER['REQUEST_METHOD']=== 'POST'){

    $username = trim($_POST['username' ]??'');
    $password= $_POST['password'] ?? '';

    if (isset($users[$username]) && password_verify($password, $users[$username]['password_hash'])){

    session_regenerate_id(true);

    $_SESSION['user'] = [
        'username'=>$username,
        'name' =>$users[$username]['name'],
        'sport' =>$users[$username]['sport']

    ];

       header('Location: training.php');
        exit;
    }else{

        $error= 'Usuario o contraseña incorrectos';
    }
    }

    require_once __DIR__  . '/includes/header.php';
    require_once __DIR__ . '/includes/navbar.php';

?>


<main>
        <h1>Inicio de sesion </h1>

        <form action="login.php" method="POST">

        <div class="form-group">
            <label for="username">Nombre de usuario :</label>

            <input type="text" id="username" name="username" value="<?=  e($username) ?>" required>
        </div>


         <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required  >
        </div>

        <?php if ($error !== ''): ?>
            <p class="error"><?= e($error) ?></p>
        <?php endif; ?>

        <button type="submit">Entrar</button>

        </form>


</main>

<?php
require_once __DIR__ . '/includes/footer.php';



