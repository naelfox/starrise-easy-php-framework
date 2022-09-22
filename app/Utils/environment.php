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
        if (!file_exists(self::$directoryEnv)) {
            return false;
        }

        $lines = file(self::$directoryEnv);
        foreach ($lines as $line) {
            $clearLine = trim($line);
            if (!empty($clearLine)) {
                putenv(trim($clearLine));
            }
        }
    }
}
