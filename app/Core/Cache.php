<?php

namespace App\Core;

class Cache
{
    private $expiration;
    private $filePath;

    public function __construct($expiration, $file)
    {
        self::createCacheStorage();
        $this->expiration = $expiration;
        $this->filePath = ROOT . "cache/{$file}";
    }

    public static function createCacheStorage()
    {
        $cacheDir = 'cache';

        if (!is_dir($cacheDir)) {
            if (!mkdir($cacheDir, 0777, true)) {
                throw new \Exception('Could not create cache folder.');
            }
        }
    }

    public function get()
    {
        if (file_exists($this->filePath) && !$this->isExpired($this->filePath)) {
            return json_decode(file_get_contents($this->filePath), true);
        }
        return null;
    }

    public function set($data)
    {
        file_put_contents($this->filePath, '<?php return ' . var_export($data, true) . ';');
    }

    private function isExpired($filePath)
    {
        if ($this->expiration > time() - filemtime($filePath)) {
            return false;
        }
        return true;
    }
}