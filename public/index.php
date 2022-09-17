<?php

require_once "../vendor/autoload.php";

use \App\Http\Router;
use \App\Http\Response;
use \App\Controllers\Home;

define('URL', 'http://localhost/mcv');

$obRouter = new Router(URL);

$obRouter->get('/', [
        function () {
            return new Response(200, Home::getHome());
        }
    ]
);


$obRouter->run()->sendResponse();
