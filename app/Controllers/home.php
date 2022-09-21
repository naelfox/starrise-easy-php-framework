<?php
// definir o namespace

namespace App\Controllers;

use \App\Utils\View;
use \App\Models\Organization;

class Home extends Page
{

  

    public static function getHome()
    {
        $obOrganization = new Organization;

        // Return view of home
        $content = View::render('layouts/home', [
            'name' => $obOrganization->name,
            'description' =>  $obOrganization->description,
            'site' =>  $obOrganization->site
        ]);

        // retorna a view da página 
        return self::getPage('Início', $content);
    }
}
