<?php

require_once "../vendor/autoload.php";
require_once "../app/includes/app.php";

use \App\Http\Router;


$objRouter = new Router(URL);

//include  routes

include '../app/routes/pages.php';


$objRouter->run()->sendResponse();
