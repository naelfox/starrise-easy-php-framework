<?php

use \App\Utils\View;
use \App\Utils\Url;
use \App\Utils\Environment;

// Load environment variables
Environment::load();

// echo getenv('DB_CONNECTION');
// die;


define('URL', (new Url())->getUrl());

View::init([
    'URL' => URL
]);