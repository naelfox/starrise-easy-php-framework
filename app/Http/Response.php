<?php

namespace App\Http;

use InvalidArgumentException;

class Response
{



    const HttpStatusCodes = [
        200 => 'OK',
        201 => 'Created',
        204 => 'No Content',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        500 => 'Internal Server Error'
    ];


    /**
     * The sendHttpCode function is used to set the HTTP status code in the response and optionally display a corresponding status message.
     * @param int $status (default: 200) - an integer that represents the HTTP status code to be sent in the response.
     * @param bool $displayMessage (default: false) - a boolean that determines whether the HTTP status message should be displayed in the response or not.
     * @return void - the function doesn't return anything, but sends the corresponding HTTP header to the response and possibly displays the corresponding status message.
     */

    public static function sendHttpCode($status = 200, $displayMessage = false)
    {

        if (!array_key_exists($status, self::HttpStatusCodes)) {
            throw new InvalidArgumentException('Invalid HTTP status code.');
        }

        http_response_code($status);
        echo ($displayMessage) ? $status . " " . self::HttpStatusCodes[$status] : '';
    }

    public static function addHeaders($httpHeaders = [])
    {
        if (count($httpHeaders)) {
            foreach ($httpHeaders as $httpHeader) {
                header($httpHeader);
            }
            return;
        }
        return false;
    }


}
