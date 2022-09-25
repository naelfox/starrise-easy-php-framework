<?php

namespace App\Http;

use \Closure;
use \Exception;
use \ReflectionFunction;

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
            if ($value instanceof Closure) {
                $params['controller'] = $value;
                unset($params[$key]);
                continue;
            }
        }

        //route variable
        $params['variables'] = [];
        $patternVariable = '/{(.*?)}/';
        if (preg_match_all($patternVariable, $route, $matches)) {
            $route = preg_replace($patternVariable, '(.*?)', $route);
            $params['variables'] = $matches[1];
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
        $httpMethod = $this->request->getHttpMethod();


        // validate route
        foreach ($this->routes as  $patternRoute => $methods) {
            //check if route is equal with pattern
            if (preg_match($patternRoute, $uri, $matches)) {
                //verifica o método
                if (isset($methods[$httpMethod])) {
                    //return of param of the route
                    unset($matches[0]);
                    //keys
                    $keys = $methods[$httpMethod]['variables'];
                    $methods[$httpMethod]['variables'] = array_combine($keys, $matches);
                    $methods[$httpMethod]['variables']['request'] = $this->request;
                    return $methods[$httpMethod];
                }

                throw new Exception("Method not allowed", 405);
            }
        }
        // URL not found
        throw new Exception("URL not found", 404);
    }

    /**
     * method responsible for run a current route
     */
    public function run()
    {
        try {
            // get current route 
            $route = $this->getRoute();

            //check controller

            if (!isset($route['controller'])) {
                throw new Exception("The url cannot be processed", 500);
            }

            // function argument

            $args = [];

            $reflection = new ReflectionFunction($route['controller']);
            foreach ($reflection->getParameters() as $parameter) {
                $name = $parameter->getName();
                $args[$name] = $route['variables'][$name] ?? '';
            }

            //return the run of function
            return call_user_func_array($route['controller'],  $args);
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
    public function post($route, $params = [])
    {
        return $this->addRoute('POST', $route, $params);
    }
    public function put($route, $params = [])
    {
        return $this->addRoute('PUT', $route, $params);
    }
    public function delete($route, $params = [])
    {
        return $this->addRoute('DELETE', $route, $params);
    }
}
