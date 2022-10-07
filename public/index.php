<?php
require_once "../vendor/autoload.php";
require_once "../app/core/app.php";

use \App\Http\Router;


$objRouter = new Router(URL);

//include  routes
require_once '../app/routes/pages.php';



$objRouter->run()->sendResponse();
