<?php

use App\Http\Response;
use App\Controllers\Home;
use App\Controllers\About;
use App\Controllers\Tester as TesterView;

$objRouter->get(
    '/',
    [
        function () {
            return new Response(200, Home::getHome());
        }
    ]
);

$objRouter->get(
    '/about',
    [
        function () {
            return new Response(200, About::getAbout());
        }
    ]
);

$objRouter->get(
    '/tests',
    [
        function () {
            return new Response(200, TesterView::getTester());
        }
    ]
);

$objRouter->get(
    '/page/{idPage}/{action}',
    [
        function ($idPage, $action) {
            return new Response(200, 'Page ' . $idPage . ' - ' . $action);
        }
    ]
);
