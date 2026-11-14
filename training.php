<?php

declare(strict_types=1);
require_once __DIR__ . '/includes/bootstrap.php';

requireLogin();

if (!isset($_SESSION['trainings'])){
    $_SESSION['trainings'] = [];
}

$errors= [];
$success = false;

$formData=[

    'date' =>'',
    'type'=>'',
    'duration' =>'',
    'rpe' => '',
    'notes'=> '',
    'has_injury'=>'',
    'injury' =>''

];


if ($_SERVER['REQUEST_METHOD']=='POST'){


        foreach($formData as $key => $value){

        if (isset($_POST[$key]) && is_string($_POST[$key])){

                $formData[$key] = $_POST[$key];
        }
        }


        $errors = validateTraining($formData);


      
    if (empty($errors)) {

        $training = [
            'date' => $formData['date'],
            'type' => $formData['type'],
            'duration' => (int) $formData['duration'],
            'rpe' => (int) $formData['rpe'],
            'notes' => trim($formData['notes']),
            'injury' => $formData['has_injury'] === '1'
                ? trim($formData['injury'])
                : ''
        ];

     
        $_SESSION['trainings'][] = $training;

        $success = true;

        
        $formData = [
            'date' => '',
            'type' => '',
            'duration' => '',
            'rpe' => '',
            'notes' => '',
            'has_injury' => '',
            'injury' => ''
        ];
        
        }
}

//calculo de estadisticas de los entrenamientos 
$totalSessions = count($_SESSION['trainings']);

$totalMinutes = 0;
$totalRpe = 0;
$totalLoad =0;

foreach($_SESSION['trainings'] as $training){

        $totalMinutes += $training['duration'];
        $totalRpe += $training['rpe'];

        $totalLoad += calculateLoad($training['duration'], $training['rpe']);


}


$averageRpe = $totalSessions >0 ? $totalRpe / $totalSessions : 0;


$pageTitle = 'Nuevo entrenamiento';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';

?>

<main>
    <h1>Registro Entrenamiento</h1>
    <?php if ($success): ?>
    <p class="success">Entrenamiento guardado correctamente.</p>
    <?php endif; ?>


    <p>Pagina de entrenamientos</p>
    <form action="training.php" method="POST">

    <div class="form-group">
        <label for="date">Fecha : </label>
        <input type="date" name="date" id="date" value="<?= e($formData['date']) ?>">
    </div>
    <?php if (isset($errors['date'])): ?>
    <p class="error"><?= e($errors['date']) ?></p>
    <?php endif; ?>


    <div class="form-group">
    <p>Tipo de sesion : </p>
    <label>
        <input type="radio" name="type" value="Tecnica" <?= $formData['type'] === 'Tecnica' ? 'checked' : '' ?>>Tecnica
    </label>


        <input type="radio" name="type" value="Fuerza" <?= $formData['type'] === 'Fuerza' ? 'checked' : '' ?>>Fuerza
    <label>
        <input type="radio" name="type" value="Resistencia" <?= $formData['type'] === 'Resistencia' ? 'checked' : '' ?>>Resistencia

    </label>

    <label>
                <input type="radio" name="type" value="Competicion" <?= $formData['type'] === 'Competicion' ? 'checked' : '' ?>>Competicion

     </label>

       <label>
                <input type="radio" name="type" value="Recuperacion" <?= $formData['type'] === 'Recuperacion' ? 'checked' : '' ?>>Recuperacion

        </label>

    </div>

    <?php if (isset($errors['type'])): ?>
    <p class="error"><?= e($errors['type']) ?></p>
<?php endif; ?>

    <div class="form-group">
    <label for="duration">Duracion (minutos):</label>
        
    
    <input type="number" name="duration" id="duration" value="<?= e($formData['duration']) ?>">

    </div>



  <?php if (isset($errors['duration'])): ?>
    <p class="error"><?= e($errors['duration']) ?></p>
<?php endif; ?>

    <div class="form-group">
    <p>Esfuerzo percibido (RPE):</p>

    <?php for ($i=1;$i<=10; $i++):?>
        <label>
<input type="radio" name="rpe" value="<?= $i ?>" <?= $formData['rpe'] === (string) $i ? 'checked' : '' ?>><?= $i ?>
        </label>
        <?php endfor;?>

    </div>



     <?php if (isset($errors['rpe'])): ?>
    <p class="error"><?= e($errors['rpe']) ?></p>
    <?php endif; ?> 

      <div class="form-group">
            <label for="notes">Sensaciones:</label>
         <textarea name="notes" id="notes" rows="4"><?= e($formData['notes']) ?></textarea>
        </div>


           <?php if (isset($errors['notes'])): ?>
             <p class="error"><?= e($errors['notes']) ?></p>
            <?php endif; ?>

        <div class="form-group">
            <label>
<input type="checkbox" name="has_injury" value="1"<?= $formData['has_injury'] === '1' ? 'checked' : '' ?>> Tengo una lesión o molestia </label>

            <label for="injury">Describe la lesión o molestia:</label>
           <input type="text" name="injury" id="injury" value="<?= e($formData['injury']) ?>">
        </div>

           <?php if (isset($errors['injury'])): ?>
             <p class="error"><?= e($errors['injury']) ?></p>
            <?php endif; ?>

        <button type="submit">Guardar entrenamiento</button>

    </form>

            <h2>Entrenamientos registrados </h2>
            <?php if (empty($_SESSION['trainings'])): ?>

            <p>Todavia no hay entrenamientos registrados </p>

            <?php else: ?>

                <table>
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Tipo</th>
                            <th>Duracion</th>
                            <th>RPE</th>
                            <th>Sensaciones</th>
                            <th>Lesion o molestia </th>
                        </tr>

                    </thead>

                    <tbody>
                        <?php foreach ($_SESSION['trainings'] as $training):?>
                                <tr>
                                    <td><?=  e($training['date']) ?></td>
                                    <td><?= e($training['type']) ?></td>
                                    <td><?=  e((string)$training['duration']) ?> min</td>
                                    <td><?=  e((string) $training['rpe']) ?></td>
                                    <td><?= e($training['notes']) ?></td>
                                    <td>
                                        <?=  e($training['injury'] !== ''? $training['injury'] : 'Ninguna') ?>
                                    </td>
                                </tr>
                                        <?php endforeach;?>
                                </tbody>
                    </table>
            <?php endif; ?>


                            <h2>Estadisiticas de entrenamiento</h2>
                            <p>Total de sesiones <?=  $totalSessions ?></p>
                            <p>Minutos totales : <?= $totalMinutes?> minutos</p>
                            <p>RPE medio : <?= number_format($averageRpe,2) ?></p>
                            <p>Carga total : <?=  $totalLoad?> </p>

    
 

</main>

<?php

require_once __DIR__ . '/includes/footer.php';

?>