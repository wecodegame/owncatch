<?php

class login {
   
   private $db = null;
   
   function getLoginStatus() {
       
      include("database.php");

      $this->db = new database();
      $this->db->connect();
      
      /* read out cookie if user already logged in*/
      if (false == empty($_COOKIE["users"])) {
          $userId = stripslashes($_COOKIE["users"]);

          /* compare DB Entries if user really exists */
          if (true == $this->doesUserExist($userId)) {
             
             /* redirect to mainpage */
             $this->redirect();
          }
          
      } else {
         /*check if form was submitted */
         $this->checkPost();
      }      
   }
   
   
   function checkPost() {

      $param = array("name" => "123");
      base::setTwigEngine("login.html", $param);
      
      if (empty($_POST)) {
         return false;
      }
 
      if (!empty($_POST["user"]) && !empty($_POST["password"])) {
          
          /* compare Form data with database entries */
          $users = $this->db->getResults("users");

          foreach ($users as $user) {

              if ($user["user"] == $_POST["user"]) {

                  if ($user["password"] == $_POST["password"]) {
                     
                     setcookie("users", $user["id"], time()+60*60*3);
                     $this->redirect($user["id"]);
                  }
              } else {
                  continue;
              }
          }
          
          base::setTwigEngine("login.html", array("error" => true));
      }
   }
   
   
   private function doesUserExist($id) {
      
      $userExists = $this->db->getResults("users", "*", " WHERE id = " . $id);
      
      if (!$userExists) {
         return false;
      }
      
      return true;
   }
   
   
   private function redirect($userId) {
       var_dump($userId);
      Header("Location: http://localhost/thegame/controller/dashboard.php" . $userId);
      exit();
   }
}
