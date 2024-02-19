<?php

use Pecee\SimpleRouter\SimpleRouter as Route;

// Route::get('/', [ExempleController::class, 'index'])->name('teste');;

Route::get('/', function(){
    return render('start.twig');
})->name('home');;
