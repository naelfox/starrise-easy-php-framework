<?php 

use App\Http\Response;
use App\Controllers\Home;
use App\Controllers\About;
use App\Controllers\Features;
use App\Controllers\Database as DatabaseView;

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

$objRouter->get('/database', [
    function () {
        return new Response(200, DatabaseView::getDataBaseView());
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