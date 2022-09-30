<?php

namespace App\Controllers;

use App\Utils\View;
use App\Utils\Environment;

class Features extends Page
{

    // method responsible for returning home content

    public static function getFeatures()
    {
        
        // return view home
        $content = View::render(
            'layouts/features',
            [
                'envConfig' => self::checkEnvFile()
            ]
        );

        // return page view
        return self::getPage('Features', $content);
    }

    public static function checkEnvFile(){

        if(!Environment::load()){
            return 'the .env file not found, you need to create it and set your variables in it.';
        }
        return 'your .env is configured';

    }

    

    
}
