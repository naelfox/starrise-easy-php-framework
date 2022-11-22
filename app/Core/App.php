<?php

use App\Core\View;
use App\Utils\Url;


define('URL', Url::getUrl());
// define('URL', (new Url())->getUrl());

View::init([
    'URL' => URL
]);