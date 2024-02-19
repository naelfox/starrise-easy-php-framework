<?php

use Pecee\SimpleRouter\SimpleRouter as Router;
use Pecee\Http\Url;
use Pecee\Http\Response;
use Pecee\Http\Request;

function url(?string $name = null, $parameters = null, ?array $getParams = null): Url
{
    return Router::getUrl($name, $parameters, $getParams);
}

function response(): Response
{
    return Router::response();
}

function request(): Request
{
    return Router::request();
}

function input($index = null, $defaultValue = null, ...$methods)
{
    if ($index !== null) {
        return request()->getInputHandler()->value($index, $defaultValue, ...$methods);
    }

    return request()->getInputHandler();
}

function redirect(string $url, ?int $code = null): void
{
    if ($code !== null) {
        response()->httpCode($code);
    }

    response()->redirect($url);
}

function csrf_token(): ?string
{
    $baseVerifier = Router::router()->getCsrfVerifier();
    if ($baseVerifier !== null) {
        return $baseVerifier->getTokenProvider()->getToken();
    }

    return null;
}

function redirectToSelf($addition = '', $code = 302)
{
    $uri =  ltrim($_SERVER['REQUEST_URI'], '/');

    header('Location: ' . URL . $uri . $addition, $code);
}
function redirectClient($path, $addition = '')
{

    echo "<script>window.location.href = '" . URL . "{$path}{$addition}';</script>";
}
function redirectClientToSelf($addition = '')
{
    $uri =  ltrim($_SERVER['REQUEST_URI'], '/');

    echo '<script>window.location.replace("' . URL . $uri . $addition  . '");</script>';
}

function removeTrailingSlash($str) {
 
    if ($str == '/') {
        return $str; 
    }

   
    if (substr($str, -1) === '/') {
        return substr($str, 0, -1);
    }

    
    return $str;
}

function render($template, $data = [], $code = 200)
{
    http_response_code($code);

    $loader = new \Twig\Loader\FilesystemLoader(VIEWS_PATH);
    $isProduction = IS_PROD;
    $twigOptions = [
        'cache' => CACHE_PATH . 'twig',
        'debug' => true,
        'auto_reload' => !$isProduction,
    ];

    $twig = new \Twig\Environment($loader, $twigOptions);
    $twig->addExtension(new \Twig\Extension\DebugExtension());

    $twig->addFunction(new \Twig\TwigFunction('route', function (?string $name = null, $parameters = null, ?array $getParams = null) {
        return removeTrailingSlash(Router::getUrl($name, $parameters, $getParams));
    }));

    echo $twig->render($template, $data);
}

function templateExists($template)
{
    if (!file_exists(VIEWS_PATH . $template)) {
        throw new \Exception("The file '{$template}' does not exist in directory " . VIEWS_PATH);
    }
    return true;
}
