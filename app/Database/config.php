<?php
namespace App\Database;
use App\Utils\Environment;

// Load environment variables

class Config
{
    //example

    /**
     * database settings 
     * @var array
     */
    private $databaseSettings;

    /**
     * method that assigns environment variables in database setting
     */
    public function __construct()
    {
        Environment::load();

        $this->databaseSettings = array(
            'host' => getenv('DB_HOST'),
            'username' => getenv('DB_USERNAME'),
            'password' => getenv('DB_PASSWORD'),
            'database' => getenv('DB_DATABASE')
        );
    }

    public function getSettings()
    {
        return $this->databaseSettings;
    }

}
