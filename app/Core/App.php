<?php

use App\Utils\View;
use App\Utils\Url;


define('URL', (new Url())->getUrl());

View::init([
    'URL' => URL
]);