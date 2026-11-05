<?php
declare(strict_types=1);
//array asociativo de deportes
$sports = [
    'running' => ['name'=> 'Running','category'=>'individual', 'unit'=>'km' ],
    'natacion' =>['name'=>'Natacion', 'category'=>'individual', 'unit'=>'km'],
    'tennis' =>['name'=>'tennis', 'category'=>'individual', 'unit'=>'minutos'],
    'futbol' =>['name'=>'futbol', 'category'=>'equipo', 'unit'=>'minutos'],
    'baloncesto' =>['name'=>'baloncesto','category'=> 'equipo', 'unit'=>'minutos'],
    'voleibol'=>['name'=>'voleibol', 'category'=>'equipo', 'unit'=>'minutos']
];

//array asociativo de niveles
$levels = [
    'beginner' => 'Iniciacion',
    'regional' => 'Regional',
    'national' => 'Nacional',
    'international' => 'Internacional'
];
//array asociativo de usuarios
$users = [
    'ana90' => [
        'name' => 'Ana Oliveira',
        'password_hash' => password_hash('ana1234', PASSWORD_DEFAULT),
        'sport' => 'running'
    ],

    'sergi91' => [
        'name' => 'Sergi Lopez',
        'password_hash' => password_hash('sergi1234', PASSWORD_DEFAULT),
        'sport' => 'baloncesto'
    ],

    'hugo92' => [
        'name' => 'Hugo Morillas',
        'password_hash' => password_hash('hugo1234', PASSWORD_DEFAULT),
        'sport' => 'natacion'
    ]
];
