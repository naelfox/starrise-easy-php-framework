<?php
// definir o namespace

namespace App\Controllers;

use \App\Utils\View;
use \App\Models\Organization;

class About extends Page
{

    // method responsible for returning home content

    public static function getAbout()
    {
        $obOrganization = new Organization;

        // return view home
        $content = View::render('layouts/about', [
            'name' => 'Sobre a organização',
            'description' =>  'Esta estrutura é feita para todos. É uma estrutura amigável, leve e intuitiva para todos os seus projetos, desde os mais avançados até os menos complexos. Ela vem com tudo o que você precisa para começar a trabalhar imediatamente: Estrutura MVC, validação de dados e manuseio de formulários, ajudantes de sistema de arquivos, suporte AJAX, cache flexível e muito mais.  Ele ajuda a construir aplicações poderosas com modelos de domínio ricos, e código limpo e de fácil manutenção.',
            'site' =>  $obOrganization->site
        ]);

        // return page view
        return self::getPage('About', $content);
    }
}
