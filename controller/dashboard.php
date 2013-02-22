<?php

$template = "dashboard";

if (!empty($_GET)) {
   $template = $_GET["tmpl"];
   
   if ($_GET["tmpl"] == "fleets") {
       
       $menu->getFleetMenu();
   }
}



include("../templates/" . $template . ".html");
?>