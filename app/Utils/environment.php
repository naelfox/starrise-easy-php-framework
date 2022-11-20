<?php

namespace App\Utils;

class Environment
{
    private static $directoryEnv = __DIR__ . "/../../.env";
    /**
     *  Loads environment variables
     *
     * @return void
     */
    public static function load()
    {
        if (file_exists(self::$directoryEnv)) {
            $handle = fopen(self::$directoryEnv, "r");
            while (($line = fgets($handle)) !== false) {
                self::insertVar($line);
            }
            fclose($handle);
            return true;
        }
        return false;
    }

    public static function insertVar(string $line)
    {
        $line = trim($line);
        if (self::isValid($line)) {
            putenv($line);
        }
    }

    private static function isValid(string $line)
    {
        $comment = '/^[#]+/';

        if (preg_match($comment, $line) || empty($line)) {
            return false;
        }
        return true;
    }
}
