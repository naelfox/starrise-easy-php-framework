<?php

namespace App\Core;

class SecureInputProcessor
{
    private $valueIgnore = ['password'];

    public function sanitizeSuperGlobals()
    {
        if ($_POST) {
            $_POST = $this->sanitizeAll($_POST);
        }
        if ($_GET) {
            $_GET = $this->sanitizeAll($_GET);
        }
        if ($_COOKIE) {
            $_COOKIE = $this->sanitizeAll($_COOKIE);
        }
    }

    private function sanitizeAll($data)
    {
        if (is_array($data)) {
            foreach ($data as $key => &$value) {
                if(is_array($value)){
					$value = $this->sanitizeAll($value);
				}
                if (!in_array($key, $this->valueIgnore)) {
                    $value = $this->sanitize($value);
                }
            }
        } else {
            throw new \Exception('The input provided is not an array.');
        }

        return $data;
    }
    private function sanitize($data)
    {
        if (empty($data) || !is_string($data)) {
            return $data;
        }
        // $data = html_entity_decode($data);
        return trim(htmlspecialchars($data));
    }

    private function hasHtmlTag($userData)
    {
        $filteredInput = strip_tags($userData);
        if ($userData !== $filteredInput) {
            return true;
        }
        return false;
    }
}
