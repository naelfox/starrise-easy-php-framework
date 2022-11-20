<?php

namespace App\Database;

use App\Utils\Environment;

// Load environment variables

class Config
{

    /**
     * database settings 
     * @var array
     */
    private static $databaseSettings;

    /**
     * method that assigns environment variables in database setting
     */
    public function __construct()
    {
        Environment::load();

        self::$databaseSettings = [
            'host' => getenv('DB_HOST'),
            'username' => getenv('DB_USERNAME'),
            'password' => getenv('DB_PASSWORD'),
            'database' => getenv('DB_DATABASE')
        ];
    }

    public static function getSettings()
    {
        return self::$databaseSettings;
    }
}
