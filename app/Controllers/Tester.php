<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Models\Book;
use App\Utils\Environment;

class Tester extends Controller
{

    public static function getTester()
    {
        $objBook = new Book;

        // return view home
        $content = View::render('pages/test', [
            'name' => 'Sobre a organização',
            'description' =>  'This structure is made for everyone. It is a user-friendly, lightweight and intuitive framework for all your projects, from the most advanced to the least complex. It comes with everything you need to get up and running right away: MVC framework, data validation and form handling, file system helpers, AJAX support, flexible caching and much more. It helps you build powerful applications with rich domain models and clean, maintainable code.',
            'site' =>  $objBook->site,
            'envConfig' => self::checkEnvFile()
        ]);

        // return page view
        return self::getPage('Tests', $content);
    }

    public static function checkEnvFile()
    {

        if (!Environment::load()) {
            return 'the .env file not found, you need to create it and set your variables in it.';
        }
        return 'your .env is configured';

    }


    
}
