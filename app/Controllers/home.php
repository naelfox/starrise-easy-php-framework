<?php


namespace App\Controllers;

use App\Utils\View;
use App\Models\Book;

class Home extends Page
{
    public static function getHome()
    {
        $obBook = new Book;

        // return home view
        $content = View::render('layouts/home', [
            'name' => $obBook->name,
            'description' =>  $obBook->description,
            'site' =>  $obBook->site
        ]);

        // return page view
        return self::getPage('Home', $content);
    }
}
