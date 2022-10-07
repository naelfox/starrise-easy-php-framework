<?php

namespace App\Http;


class Request
{
    private $router;
    private $httpMethod;
    private $uri;
    private $queryParam = [];

    private $postVars = [];

    private $headers = [];

    public function __construct($router)
    {
        $this->router = $router;
        $this->queryParam = $_GET ?? [];
        $this->postVars = $_POST ?? [];
        $this->headers = getallheaders();
        $this->httpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->setURI();

    }

    private function setUri(){
        $this->uri = $_SERVER['REQUEST_URI'] ?? '';
        $xURI = explode('?', $this->uri);
        $this->uri = $xURI[0];
    }

    public function getRouter(){
        return $this->router;
    }

    public function getHttpMethod()
    {
        return $this->httpMethod;
    }
    public function getUri()
    {
        return $this->uri;
    }
    public function getHeaders()
    {
        return $this->headers;
    }
    public function getQueryParams()
    {
        return $this->queryParam;
    }
    public function getPostVars()
    {
        return $this->postVars;
    }
}
