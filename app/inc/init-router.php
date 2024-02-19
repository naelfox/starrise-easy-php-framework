<?php

use Pecee\SimpleRouter\SimpleRouter as Route;
use Pecee\Http\Url;
use Pecee\Http\Response;
use Pecee\Http\Request;

// https://github.com/skipperbent/simple-php-router

Route::group(['prefix' => '/api'], function () {
    require_once APP_ROOT_PROJECT . "routes/api.php";
});

require_once APP_ROOT_PROJECT . "routes/pages.php";

Route::error(function (Request $request, \Exception $exception) {

    switch ($exception->getCode()) {
        case 404:

            redirect('404');
        case 403:

            http_response_code(403);
            echo 'forbidden';
            die;
    }
});

// Route::setDefaultNamespace('\App\Controllers');
Route::setDefaultNamespace('\App');

Route::start();
