<?php


$test = new login();
$test->getLoginStatus();



class base {

   public $db = null;
   
   function __construct() {
      include("controller/database.php");
      include("controller/dashboard.php");
   }
  
   function connect() {

      $this->db = new database();
      $this->db->connect();
   }
   
   
   function redirect($userId) {

      Header("Location: http://localhost/thegame/controller/dashboard.php?id=" . $userId);
      exit();
   }
}





class login extends base {
      
   function getLoginStatus() {
             
      $this->connect();
      
      /* read out cookie if user already logged in*/
      if (false == empty($_COOKIE["users"])) {
          $userId = stripslashes($_COOKIE["users"]);

          /* compare DB Entries if user really exists */
          if (true == $this->doesUserExist($userId)) {
             
             /* redirect to mainpage */
             $this->redirect($_COOKIE["users"]);
          }
          
      } else {
         /*check if form was submitted */
         $this->checkPost();
      }      
   }
   
   
   
   function doesUserExist($id) {

      $userExists = $this->db->getResults("users", "*", " WHERE id = " . $id);

      if (!$userExists) {
         return false;
      }
      
      return true;
   }
}

class mainpage {
      
   private $db = null;
   private $user = array();
   
   function index() {

      include("../templates/dashboard.html");

      if (!isset($_GET["id"]) || empty($_GET["id"])) {
         return false;
      }
      
      $this->getUserData($_GET["id"]);
      
      $this->setTemplateVariables();
   }
   
   
   private function getUserData($id) {
      
      if (empty($id)) {
         return false;
      }
      
      
      $this->user = $this->db->getUserData($id);
   }
   
   
   private function setTemplateVariables() {
      
      
      base::setTwigEngine("dashboard.html", $this->user);
      
   }
   
}

