<?php


$base = new base();
$base->index();

class base {
   
   function index () {

      if ($_SERVER["HTTP_HOST"] == "www.owncatch.de") {
          $redirect = "http://www.owncatch.de/dashboard/dashboard.php";
      } else {
          $redirect = "http://localhost/thegame/dashboard/dashboard.php";
      }
      
      include("login/login.php");

      $login = new login();

      $loginAccepted = $login->checkPost();
      if ($loginAccepted != null) {
         $this->delegate301($redirect);
      }

   }
     
   
   private function delegate301($url) {

      Header("Location: " . $url);

      exit();
   }
}