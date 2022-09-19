<?php 

use \App\Http\Response;
use \App\Controllers\Home;
use \App\Controllers\About;

$obRouter->get('/', [
    function () {
        return new Response(200, Home::getHome());
    }
]
);

$obRouter->get('/about', [
    function () {
        return new Response(200, About::getAbout());
    }
]
);
$obRouter->get('/pagina/{idPage}/{action}', [
    function ($idPage, $action) {
        return new Response(200, 'Página ' . $idPage . ' - ' . $action);
    }
]
);

?>