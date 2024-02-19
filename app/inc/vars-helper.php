<?php

define("URL", PROTOCOL . "://" . HOST . "/");
define("IMG", PROTOCOL . "://" . HOST . "/assets/img/");
define("CSS", PROTOCOL . "://" . HOST . "/assets/styles/");
define("JS", PROTOCOL . "://" . HOST . "/assets/js/");

define("CACHE_DEFINE", ($config[$server]['host'] != 'prod') ?  "?v=" .  time() : "");
define("CACHE_OFF", "?v=" .  time());

define("IS_PROD", ($config[$server]['host'] == 'prod'));

define("URI", $_SERVER['REQUEST_URI']);

define("CURRENT_URL", PROTOCOL . "://" . HOST . $_SERVER['REQUEST_URI']);


//
define("CACHE_PATH", dirname(__DIR__) . '/../cache/');
define('VIEWS_PATH', dirname(__DIR__) . '/../views/');
define('ASSETS', dirname(__DIR__) . '/../assets/');


define("DB_DRIVE", 'mysql');
define("DB_HOST", $config[$server]['host']);
define("DB_USERNAME", $config[$server]['username']);
define("DB_PASSWORD", $config[$server]['password']);
define("DB_DATABASE_NAME", $config[$server]['database']);
