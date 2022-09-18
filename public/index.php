<?php

require_once "../vendor/autoload.php";

use \App\Http\Router;
use \App\Utils\View;

echo '<pre>';
print_r($_SERVER);
echo '</pre>';

die;

define('URL', 'http://localhost:8081');


View::init([
    'URL' => URL
]);

$obRouter = new Router(URL);

//include  routes

include '../app/routes/pages.php';


$obRouter->run()->sendResponse();
