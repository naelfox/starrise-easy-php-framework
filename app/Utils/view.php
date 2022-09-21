<?php

namespace App\Utils;


class View
{
    /**
     * pattern variable
     *
     * @var array
     */
    private static $vars = [];
    /**
     * Methods that define initials data of the class 
     */

    public static function init($vars = [])
    {
        self::$vars = $vars;
    }



    
    private static function getContentView($view, $debug = false)
    {
        $file = __DIR__ . '/../../resources/views/' . $view . '.phtml';

        $err = '';
        if ($debug) {
            $err = 'Não possui essa página: ' . $file;
        } else {
            $err = 'Não possui essa página';
        }


        return file_exists($file) ? file_get_contents($file) : $err;
    }


    /**
     * 
     * This method render the view
     *
     * @access public
     * @param (string)$directory - file name
     * @param (array)$data -data pass in param
     * @return (?) html content
     * @version 1
     **/
    public static function render($view, $vars = [])
    {
        $contentView = self::getContentView($view);

        //merge of variables
        $vars = array_merge(self::$vars, $vars);
        $keys = array_keys($vars);
        $keys = array_map(function ($item) {
            return '{{' . $item . '}}';
        }, $keys);
        return str_replace($keys, array_values($vars), $contentView);
    }
}
