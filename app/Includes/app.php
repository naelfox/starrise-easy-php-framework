<?php

use App\Utils\View;
use App\Utils\Url;
use App\Database\Config;


define('URL', (new Url())->getUrl());

View::init([
    'URL' => URL
]);