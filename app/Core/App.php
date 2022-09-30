<?php

use App\Core\View;
use App\Utils\Url;


define('URL', (new Url())->getUrl());

View::init([
    'URL' => URL
]);