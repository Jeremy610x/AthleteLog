<?php


declare (strict_types =1);

function renderSportsTable(array $sports): string
{
    $html = <<<HTML
    <table border=1>
        <tr>
            <th>Nombre</th>
            <th>Categoría</th>
            <th>Unidad</th>
        </tr>
    HTML;

    foreach ($sports as $sport) {
        $html .= '<tr>'
            . '<td>' . e($sport['name']) . '</td>'
            . '<td>' . e($sport['category']) . '</td>'
            . '<td>' . e($sport['unit']) . '</td>'
            . '</tr>';
    }

    return $html . '</table>';
}



//devuelve en HTML el mensaje de bienvenido 


function renderMensajeBienvenida():string{

        return <<<HTML
        <main>
            <h1>Bienvenido a AtheleteLog </h1>

            <p>
                AtheleteLog es una aplicacion web para deportistas.
            </p>
            <p>        
            Registra, inicia sesión, anota tus entrenamientos y consulta tu historial
            </p>

        </main>

    HTML;


}
