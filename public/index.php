<?php

require_once "../vendor/autoload.php";

use \App\Controllers\Home;


$obResponse = new \App\Http\Response(470, 'Olá aqui é o conteúdo', 'text');


// $obResponse->sendResponse();



echo '<pre>';
print_r($obResponse);
echo '</pre>';



exit;
echo Home::getHome();
