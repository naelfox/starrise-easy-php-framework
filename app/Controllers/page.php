<?php


namespace App\Controllers;

use App\Utils\View;

class Page
{
    
    //render the header
    private static function getHeader()
    {
        return View::render('templates/header');
    }
    // render the footer
    private static function getFooter()
    {
        return View::render('templates/footer', 
        [
            'data' => date('Y')
        ]

    );
    }

    // method return the page view
    /**
     * @param string $title
     * @param string $content
     */

    public static function getPage($title, $content)
    {
        return View::render(
            'layouts/page',
            [
                'title' => $title,
                'header' => self::getHeader(),
                'content'  => $content,
                'footer' => self::getFooter()
            ]
        );
    }
}
