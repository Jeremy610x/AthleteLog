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