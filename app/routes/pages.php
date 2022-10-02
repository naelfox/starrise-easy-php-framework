<?php 

use App\Http\Response;
use App\Controllers\Home;
use App\Controllers\About;
use App\Controllers\Features;

$objRouter->get('/', [
    function () {
        return new Response(200, Home::getHome());
    }
]
);

$objRouter->get('/about', [
    function () {
        return new Response(200, About::getAbout());
    }
]
);

$objRouter->get('/features', [
    function () {
        return new Response(200, Features::getFeatures());
    }
]
);

$objRouter->get('/page/{idPage}/{action}', [
    function ($idPage, $action) {
        return new Response(200, 'Page ' . $idPage . ' - ' . $action);
    }
]
);

//feature post
$objRouter->post('/features', [
    function ($request) {
        return new Response(200, Features::insertFeature($request));
    }
]
);