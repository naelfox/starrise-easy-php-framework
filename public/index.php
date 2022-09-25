<?php

require_once "../vendor/autoload.php";

use \App\Http\Router;
use \App\Utils\View;
use \App\Utils\Url;
use \App\Utils\Environment;

Environment::load();

// echo getenv('DB_CONNECTION');
// die;

$url = new Url();

define('URL', $url->getUrl());

View::init([
    'URL' => URL
]);

$obRouter = new Router(URL);

//include  routes

include '../app/routes/pages.php';


$obRouter->run()->sendResponse();
