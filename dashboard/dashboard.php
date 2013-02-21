<?php

$template = "dashboard";
if (!empty($_GET)) {
   $template = $_GET["tmpl"];
}

include($template . ".html");
?>