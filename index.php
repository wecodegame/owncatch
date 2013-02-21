<?php

echo "hallo";die();

$base = new base();
$base->index();

class base {
   
   function index () {

      include("login/login.php");
      
      $login = new login();

      $loginAccepted = $login->checkPost();

      if ($loginAccepted != null) {
         $this->delegate301("http://www.owncatch.de/dashboard/dashboard");
      }

   }
   
   
   function setLoginActions() {
      
   }
   
   
   private function delegate301($url) {

      Header("Location: " . $url);

      exit();
   }
}





?>
