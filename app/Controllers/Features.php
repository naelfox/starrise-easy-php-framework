<?php 

namespace App\Controllers;

use App\Utils\View;
use App\Models\Book;

class Features extends Page
{

    // method responsible for returning home content

    public static function getFeatures()
    {

        // return view home
        $content = View::render('layouts/features', []);

        // return page view
        return self::getPage('Features', $content);
    }
}
