<?php
namespace App\Http;
class Response
{
    /**
     *Code Status Http
     *@var interger
     */
    private $httpCode = 200;

    /**
     * Response Header
     * @var array
     */
    private $headers = [];

    /**
     * Type content return
     * @var string
     */
    private $contentType = 'text/html';

    /**
     * Response content
     * @var mixed
     */
    private $content;

    /**
     * Method will be start the class and define values
     * @param integer $httpCode
     * @param mixed $content
     * @param string $contentType
     */
    public function __construct($httpCode, $content, $contentType = 'text/html')
    {
        $this->$httpCode = $httpCode;
        $this->$content  = $content;      
        $this->setContentType($contentType);
    }
    /**
     * Methods that will be change content type of response
     * @param string $contentType
     */

    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
        $this->addHeader('Content-Type', $contentType);
    }

    /**
     * Método that will add a new resgister to header response
     * @param string $key
     * @param string $value
     */

    public function addHeader($key, $value)
    {
        $this->headers[$key] = $value;
    }


    /**
     * Methods that will be send response to user
     */
    public function sendResponse()
    {

        switch ($this->contentType) {
            case 'text/html':
                echo $this->content;
                exit;
        }

    }
}
