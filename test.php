<?php


$test = new login();
$test->getLoginStatus();



class base {

   public $db = null;
   
   function __construct() {
      include("controller/database.php");
      include("controller/dashboard.php");
      include 'Twig/lib/Twig/Autoloader.php';
      Twig_Autoloader::register();
   }
  
   function connect() {

      $this->db = new database();
      $this->db->connect();
   }
   
   
   function redirect($userId) {

      Header("Location: http://localhost/thegame/controller/dashboard.php?id=" . $userId);
      exit();
   }
   
   
   static function setTwigEngine($tpl, $vars = array()) {

      // include and register Twig auto-loader

      try {
        // specify where to look for templates
        $loader = new Twig_Loader_Filesystem('templates');
        
        // initialize Twig environment
        $twig = new Twig_Environment($loader);

        // load template
        $template = $twig->loadTemplate($tpl);

        // set template variables
        // render template
        echo $template->render($vars);
                
      } catch (Exception $e) {
        die ('ERROR: ' . $e->getMessage());
      }
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
   
   
   function checkPost() {

      $param = array("name" => "123");
      $this->setTwigEngine("login.html", $param);
      
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
          
          $this->setTwigEngine("login.html", array("error" => true));
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

