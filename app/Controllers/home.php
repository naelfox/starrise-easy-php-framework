<?php
// definir o namespace

namespace App\Controllers;

use \App\Utils\View;
use \App\Models\Organization;

class Home extends Page
{

    // metodos responsável por retornar o conteúdo (view) da nossa home

    public static function getHome()
    {
        $obOrganization = new Organization;

        // retorna a view da home 
        $content = View::render('layouts/home', [
            'name' => $obOrganization->name,
            'description' =>  $obOrganization->description,
            'site' =>  $obOrganization->site
        ]);

        // retorna a view da página 
        return self::getPage('Início', $content);
    }
}
