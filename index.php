<?php


$base = new base();
$base->index();

class base {
   
   function index () {
      
      include 'Twig/lib/Twig/Autoloader.php';
      Twig_Autoloader::register();
      
      include("controller/login.php");
      
      $login = new login();
      
      $login->getLoginStatus();
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