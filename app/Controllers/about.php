<?php
// definir o namespace

namespace App\Controllers;

use \App\Utils\View;
use \App\Models\Organization;

class About extends Page
{

    // metodos responsável por retornar o conteúdo (view) da nossa home

    public static function getHome()
    {
        $obOrganization = new Organization;

        // retorna a view da home 
        $content = View::render('layouts/home', [
            'name' => 'Sobre a organização',
            'description' =>  'Description Lorem ipsum dolor, sit amet consectetur adipisicing elit. Molestias repellendus nobis atque similique ipsa temporibus, repellat sit quis excepturi rem aut, possimus in vel exercitationem! Officia deserunt ducimus repellat fugit.',
            'site' =>  $obOrganization->site
        ]);

        // retorna a view da página 
        return self::getPage('Início', $content);
    }
}
