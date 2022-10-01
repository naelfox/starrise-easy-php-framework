<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Utils\Environment;

class Features extends Controller
{



    public static function getFeatures()
    {
        
        // return view home
        $content = View::render(
            'layouts/features',
            [
                'envConfig' => self::checkEnvFile(),
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
