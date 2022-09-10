<?php

require_once "../vendor/autoload.php";
use \App\Controllers\Home;

// $obResponse = new \App\Http\Response(200, 'Olá mundo');
$obResponse = new \App\Http\Response(200, 'Ola1');

$obResponse->sendResponse();


// echo '<pre>';
// print_r($obResponse);
// echo '</pre>';



exit;
echo Home::getHome();




?>