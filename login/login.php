
<?php

class login {
   
   function checkPost() {
      
      include("login.html");

      if (empty($_POST)) {
         return false;
      }
 
      if (!empty($_POST["user"]) && !empty($_POST["password"])) {

          include("database.php");

          $db = new database();

          if (!$db->connect()) {
             return false;
          }

          $users = $db->getResults("users");
          
          foreach ($users as $user) {

              if ($user[0] == $_POST["user"]) {

                  if ($user[1] == $_POST["password"]) {
                     
                     return true;
                  }
              }
          }  
      }
   }
}

      
   





?>
