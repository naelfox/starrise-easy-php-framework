<?php

namespace App\Utils;

class Environment
{
    private static $directoryEnv = __DIR__ . "/../../.env";
    /**
     *  Method that loads environment variables
     *
     * @return void
     */
    public static function load()
    {
        if (file_exists(self::$directoryEnv)) {
            self::insertVariables(file(self::$directoryEnv));
            return true;
        }
        return false;
    }

    public static function insertVariables($lines)
    {
        foreach ($lines as $line) {
            $cleanLine = trim($line);
            if (!empty($cleanLine)) {
                putenv($cleanLine);
            }
        }
    }
}
