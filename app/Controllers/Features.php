<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Utils\Environment;
use App\Models\Entities\Features as Features_Model;

class Features extends Controller
{



    public static function getFeatures()
    {
        
        // return view home
        $content = View::render(
            'pages/features',
            [
                'envConfig' => self::checkEnvFile(),
                'item' => self::getFeaturesItens()
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

    public static function insertFeature($request){
        $postVars = $request->getPostVars();
        $objFeature = new Features_Model;
        $objFeature->name = $postVars['name'];
        $objFeature->message = $postVars['message'];
        $objFeature->send();
        return self::getFeatures();
    }

    /**
     * Return itens
     *
     * @return string
     */
    private static function getFeaturesItens(){
        $itens = '';

        $results = Features_Model::getFeatures();
       
        return $itens;
    }

    
}
