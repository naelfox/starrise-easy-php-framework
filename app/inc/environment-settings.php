<?php


if (isset($_SERVER['HTTP_HOST'])) {
    define("HOST", $_SERVER['HTTP_HOST']);
}

if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
    define("PROTOCOL", "https");
} else {
    define("PROTOCOL", "http");
}

$config = [
    'localhost' =>  [
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'databasename',
        'name' => 'localhost'
    ],
];

$server = $_SERVER['SERVER_NAME'];

if ($config[$server]['host'] != 'prod') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}


// $cacheDuration = 15552000; // 5 meses em segundos
// $expireTime = time() + $cacheDuration;
// header("Cache-Control: max-age=$cacheDuration, public");
// header("Expires: " . gmdate("D, d M Y H:i:s", $expireTime) . " GMT");