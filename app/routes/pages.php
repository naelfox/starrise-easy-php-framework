<?php 

use App\Http\Response;
use App\Controllers\Home;
use App\Controllers\About;
use App\Controllers\Features;

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

$obRouter->get('/features', [
    function () {
        return new Response(200, Features::getFeatures());
    }
]
);

$obRouter->get('/page/{idPage}/{action}', [
    function ($idPage, $action) {
        return new Response(200, 'Page ' . $idPage . ' - ' . $action);
    }
]
);

//feature post
$obRouter->post('/features', [
    function ($request) {
        // echo '<pre>';
        // print_r($request);
        // echo '</pre>';
        // die;
        return new Response(200, Features::getFeatures());
    }
]
);