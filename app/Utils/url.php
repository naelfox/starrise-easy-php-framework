<?php

namespace App\Utils;

class Url
{
   private static $protocol;
   private static $domain;


   public function __construct()
   {
      self::$protocol = $this->getProtocol();
      self::$domain = $this->getDomain();
   }

   private function getProtocol()
   {
      if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
         return "https";
      }
      return "http";
   }

   private function getDomain()
   {
      if ($_SERVER['SERVER_NAME'] == 'localhost') {
         return $_SERVER['HTTP_HOST'];
      }
      return $_SERVER['SERVER_NAME'];
   }

   private static function mount()
   {
      return self::$protocol . '://' . self::$domain;
   }

   public static function getUrl()
   {
      return self::mount();
   }
}
