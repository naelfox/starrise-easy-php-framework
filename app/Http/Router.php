<?php

namespace App\Http;

use \Closure;
use \Exception;

class Router
{

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
    public function __construct($url)
    {
        $this->request = new Request();
        $this->url = $url;
        $this->setPrefix();
    }

    /**
     * set route prefix
     */
    private function setPrefix()
    {
        //info about actual url
        $parseUrl = parse_url($this->url);
        $this->prefix = $parseUrl['path'] ?? '';
    }
    /**
     * Method responsivle for add a route in the class
     * @param string $method
     * @param string $route 
     * @param array $params
     */

    private function addRoute($method, $route, $params = [])
    {

        //validate params
        foreach ($params as $key => $value) {
            $params['controller'] = $value;
            unset($params[$key]);
            continue;
        }

        // pattern of validação da url
        $patternRoute = '/^' . str_replace('/', '\/', $route) . '$/';

        // add route into the class

        $this->routes[$patternRoute][$method] = $params;
    }

    /**
     * Method responsible for returning the URI disreguarding the prefix
     * @return string
     */

    private function getUri()
    {

        //uri of the request
        $uri = $this->request->getUri();


        //split the URI with Prefix
        $xUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];

        // return uri without prefix
        return end($xUri);
    }

    /**
     * Method responsible for return the data of the current route
     * @return array
     */

    private function getRoute()
    {
        $uri = $this->getUri();
    }

    /**
     * method responsible for run a current route
     */

    public function run()
    {
        try {
            // get current route 
            $route = $this->getRoute();
        } catch (Exception $e) {
            return new Response($e->getCode(), $e->getMessage());
        }
    }

    /**
     * Method responsible for define a get route
     * @param string $route
     * @param array $params
     */

    public function get($route, $params = [])
    {

        return $this->addRoute('GET', $route, $params);
    }
}