<?php


class dashboard {
   
   function index() {
      
      $this->connect();

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

?>