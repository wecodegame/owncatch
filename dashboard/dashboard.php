<?php

var_dump($_REQUEST);
var_dump($_ENV);
var_dump($_SERVER);
$template = "dashboard";

if (!empty($_GET)) {
   $template = $_GET["tmpl"];
   
   if ($_GET["tmpl"] == "fleets") {
       
       $menu->getFleetMenu();
   }
}



include($template . ".html");
?>