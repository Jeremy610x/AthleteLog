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