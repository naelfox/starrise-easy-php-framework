<?php

namespace App\Core;

use App\Core\View;

class Controller
{

    //render the header
    private static function getHeader()
    {
        return View::render('modules/header');
    }
    // render the footer
    private static function getFooter()
    {
        return View::render(
            'modules/footer',
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
            'index',
            [
                'title' => $title,
                'header' => self::getHeader(),
                'content'  => $content,
                'footer' => self::getFooter()
            ]
        );
    }
}
