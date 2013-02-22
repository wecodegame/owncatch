<?php


$base = new base();
$base->index();

class base {
   
   function index () {

      include("controller/login.php");

      $login = new login();
      
      $login->getLoginStatus();
   }
}