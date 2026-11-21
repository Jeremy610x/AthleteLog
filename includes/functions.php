<?php 

declare(strict_types=1);

function getSportsByCategory(array $sports, string $category): array{

$result =[];

foreach($sports as $key => $sport){
    if ($sport['category'] === $category){        
        $result[$key]= $sport;
    }
}
return $result;

}



function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}


function requireLogin(): void {

if (!isset($_SESSION['user'])){

        header('Location: login.php');
        exit;
        

}
}



function validateTraining(array $input):array{

    $errors =[];

    $date = $input['date'] ?? '';
    $dateObject = DateTime::createFromFormat('!Y-m-d',$date);

    if (!$dateObject || $dateObject->format('Y-m-d') !== $date || $date > date('Y-m-d')){

        $errors['date'] = 'Introduce una fecha valida que no sea futuro';
    }

    $allowedTypes = [
    'Tecnica', 'Fuerza', 'Resistencia', 'Competicion', 'Recuperacion'
    ];

    if (!in_array($input['type'] ?? '', $allowedTypes, true)){
        $errors['type'] = 'Selecciona un tipo sesion valido';
    }

        //Validacion de la duracion
        $duration = filter_var($input['duration'] ??'', FILTER_VALIDATE_INT);

        if ($duration === false || $duration<5 || $duration >360){

            $errors['duration'] = 'La duracion debe estar entre 5 y 360 minutos ';
        }

        //Validacion RPE

        $rpe = filter_var($input['rpe'] ?? '', FILTER_VALIDATE_INT);

        if ($rpe === false || $rpe<1 || $rpe >10){
            $errors['rpe'] = 'El esfuerzo debe estar entre 1 y 10';
        }
        //validaciones de sensaciones
        $notes = trim($input['notes'] ?? '');

        if (strlen($notes)>200){

        $errors['notes'] = 'Las sensaciones no pueden superar los 200 caracteres';
        }

        //Validar lesion o molestia 
        $hasInjury = ($input['has_injury'] ?? '')=== '1';
        $injury = trim($input['injury']?? '');

        if ($hasInjury && $injury === ''){
            $errors ['injury'] = 'Describe la lesion o molestia';

        }
        return $errors;

}

function calculateLoad (int $duration, int $rpe):int{

    return $duration * $rpe;

}

function initializeTrainingFile(string $file): bool
{
    if (file_exists($file)) {
        return true;
    }

    $h = fopen($file, 'w');

    if ($h === false) {
        return false;
    }

    flock($h, LOCK_EX); 

    $headers = [
        'username',
        'date',
        'type',
        'duration',
        'rpe',
        'notes',
        'injury'
    ];
    //escribe en la cabecera
    fputcsv($h, $headers);

    //bloquea el archivo mientras escribe 
    flock($h, LOCK_UN);
    fclose($h);

    return true;
}

function writeTraining(string $file, array $training): bool
{
    if (!initializeTrainingFile($file)) {
        return false;
    }

    $h = @fopen($file, 'a');

    if ($h === false) {
        return false;
    }
    //utiliza un bloqueo mientras escribe
    flock($h, LOCK_EX);

    //se añade una fila
    fputcsv($h, $training);

    flock($h, LOCK_UN);//libera el bloqueo
    fclose($h);

    return true;
}


function readTrainings(string $file, string $username): ?array
{
    $result = [];

    if (!initializeTrainingFile($file)) {
        return null;
    }

    $h = @fopen($file, 'r');

    if ($h === false) {
        return null;
    }

    flock($h, LOCK_SH);

    $headers = fgetcsv($h);

    if ($headers !== false) {
        while (($row = fgetcsv($h)) !== false) {

            if (count($row) !== count($headers)) {
                continue;
            }

            $training = array_combine($headers, $row);

            if ($training !== false && $training['username'] === $username) {
                $result[] = $training;
            }
        }
    }

    flock($h, LOCK_UN);
    fclose($h);

    return $result;
}


