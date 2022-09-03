<?php
// definir o namespace

namespace App\Controllers;

use \App\Utils\View;

class Page
{
    
    // metodo responsável por renderizar o topo da página
    private static function getHeader()
    {
        return View::render('templates/header');
    }
    // metodo responsável por renderizar o rodapé da página
    private static function getFooter()
    {
        return View::render('templates/footer', 
        [
            'data' => date('Y')
        ]

    );
    }

    // metodos responsável por retornar o conteúdo (view) da nossa página generica

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
