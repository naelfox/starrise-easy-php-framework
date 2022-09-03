<?php

namespace App\Http;


class Request
{

    // metodo http da requisição
    private $httpMethod;
    // URI da página
    private $uri;
    //parametros da requisicao
    private $queryParam = [];

    private $postVars = [];

    private $headers = [];

    public function __construct()
    {
        $this->queryParam = $_GET ?? [];
        $this->postVars = $_POST ?? [];
        $this->headers = getallheaders();
        $this->httpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->uri = $_SERVER['REQUEST_URI'] ?? '';



        // metodo responsavel por retornar o metodo http da requisicao
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
