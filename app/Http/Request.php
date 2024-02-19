<?php

namespace App\Http;


class Request
{
    private $httpMethod;
    private $queryString;
    private $headers = [];

    public function __construct()
    {
        $this->httpMethod = $_SERVER['REQUEST_METHOD'] ? $_SERVER['REQUEST_METHOD'] : 'UNKNOWN';
        $this->queryString = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : null;
        $this->headers = getallheaders();
    }

    public function checkMethod($method)
    {
        if (is_array($method)) {
            return $this->checkMultipleMethods($method);
        }

        return $this->matchRequestMethod($method);
    }
    private function checkMultipleMethods($methods)
    {

        foreach ($methods as $method) {

            if ($this->matchRequestMethod($method)) {
                return true;
            }
        }
        return false;
    }

    public function files($key = null, $default = null)
    {
        if (empty($key)) {
            return $_FILES;
        }
        return isset($_FILES[$key]) ? $_FILES[$key] : $default;
    }

    public function post($key = null, $default = null)
    {
        if (empty($key)) {
            return $_POST;
        }
        return isset($_POST[$key]) ? $_POST[$key] : $default;
    }

    public function get($key = null, $default = null)
    {
        if (empty($key)) {
            return $_GET;
        }
        return isset($_GET[$key]) ? $_GET[$key] : $default;
    }

    public function session($key = null, $default = null)
    {
        if (empty($key)) {
            return $_SESSION;
        }
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }


    private function matchRequestMethod($method)
    {
        return $this->method() === strtoupper($method);
    }

    public function getHeaders()
    {
        return $this->headers;
    }
    /**
     * return method
     *
     * @return string
     */
    public function method()
    {
        return $this->httpMethod;
    }
    /**
     * remove all unnecessary forward slashes ("/") from a path string.
     *  @return string
     */
    private function cleanPath()
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
        $newPath = preg_replace("#(/)+#", "/", $path);
        return $newPath;
    }
    /**
     * returns the requested URL path after cleaning done by the "cleanPath()" method
     *
     * @return string
     */
    public function getPath()
    {
        return $this->cleanPath();
    }

    public function getPathInArray($path)
    {
        $path = parse_url($path, PHP_URL_PATH);
        $path = ltrim($path, '/');
        return explode('/', $path);
    }
    /**
     * Get querystring params.
     *
     * @return array | null
     */
    public function getQueryStringParams()
    {
        if (!is_null($this->queryString)) {
            parse_str($this->queryString, $output);
            return $output;
        }
        return null;
    }
}
