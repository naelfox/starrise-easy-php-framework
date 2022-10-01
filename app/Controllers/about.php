<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Models\Book;

class About extends Controller
{
 

    public static function getAbout()
    {
        $objBook = new Book;

        // return view home
        $content = View::render('layouts/about', [
            'name' => 'Sobre a organização',
            'description' =>  'This structure is made for everyone. It is a user-friendly, lightweight and intuitive framework for all your projects, from the most advanced to the least complex. It comes with everything you need to get up and running right away: MVC framework, data validation and form handling, file system helpers, AJAX support, flexible caching and much more. It helps you build powerful applications with rich domain models and clean, maintainable code.',
            'site' =>  $objBook->site
        ]);

        // return page view
        return self::getPage('', $content);
    }

    
}
