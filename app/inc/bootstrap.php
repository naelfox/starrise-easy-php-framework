<?php

define("APP_ROOT_PROJECT", dirname(__DIR__) . "/");
define("ROOT", dirname(__DIR__, 2) . "/");

require_once APP_ROOT_PROJECT . "inc/environment-settings.php";
require_once APP_ROOT_PROJECT . "inc/vars-helper.php";
require_once APP_ROOT_PROJECT . "inc/helper-functions.php";
require_once APP_ROOT_PROJECT . "inc/init-router.php";
