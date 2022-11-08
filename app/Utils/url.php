<?php

namespace App\Utils;

class Url
{
   private $protocol;
   private $domain;


   public function __construct()
   {
      $this->protocol = $this->getProtocol();
      $this->domain = $this->getDomain();
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

   private function mount()
   {
      return $this->protocol . '://' . $this->domain;
   }

   public function getUrl()
   {
      return $this->mount();
   }
}
