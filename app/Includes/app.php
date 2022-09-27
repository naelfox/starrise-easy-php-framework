<?php

use App\Utils\View;
use App\Utils\Url;
use App\Database\Config;

print_r((new Config())->getSettings());


define('URL', (new Url())->getUrl());

View::init([
    'URL' => URL
]);