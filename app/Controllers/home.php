<?php


namespace App\Controllers;

use App\Utils\View;
use App\Models\Book;

class Home extends Page
{
    public static function getHome()
    {
        $objBook = new Book;

        // return home view
        $content = View::render('layouts/home', [
            'name' => $objBook->name,
            'description' =>  $objBook->description,
            'site' =>  $objBook->site
        ]);

        // return page view
        return self::getPage('Home', $content);
    }
}
