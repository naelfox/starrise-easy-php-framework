<?php

namespace App\Http;

class Router{

    /**
     * Full project url (source)
     * @var string
     */
    private $url = '';

    /**
     * commmom prefix
     * @var string
     */
    private $prefix = '';

    /**
     * route index
     *
     * @var array
     */
    private $routes = [];
    
    /**
     * Request instance
     * @var Request
     */

    private $request;

    /**
     * method that starts the class
     * @param string $url
     */
    public function __construct($url){
        $this->request = new Request();
        $this->url = $url;
        $this->setPrefix();
    }

    /**
     * Define the prefix
     */
    private function setPrefix(){
        //info about actual url
        $parseUrl = parse_url($this->url);
        $this->prefix = $parseUrl['path'] ?? '';
    }




}