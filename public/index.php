<?php

require_once "../vendor/autoload.php";

use \App\Http\Router;
use \App\Controllers\Home;

define('URL', 'http://localhost/mcv');

$obRouter = new Router(URL);

echo '<pre>';
print_r($obRouter);
echo '</pre>';
exit;
echo Home::getHome();
